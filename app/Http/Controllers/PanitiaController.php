<?php

namespace App\Http\Controllers;

use App\Models\ActivityStructure;
use App\Models\RecruitmentRegistration;
use App\Models\StudentActivity;
use App\Models\StudentRole;
use App\Models\SubRole;
use App\Models\StudentRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PanitiaController extends Controller
{
    // Tahap siswa umum
    public function dashboard()
    {
        return view('siswa.dashboard');
    }
    public function profile()
    {
        return view('siswa.profile');
    }

    public function daftarAcara()
    {
        $studentId = Auth::user()->student->student_id;

        $acara = StudentActivity::with('members') // Optional: Eager load members if you need to display them
            ->whereDoesntHave('members', function ($query) use ($studentId) {
                $query->where('activity_structures.student_id', $studentId);
            })
            ->get();
        return view('siswa.daftar-acara', compact('acara'));
    }

    public function formPendaftaran()
    {
        return view('siswa.form-pendaftaran');
    }

    public function statusPendaftaran()
    {
        $data = RecruitmentRegistration::with('activityDetail')->where('student_id', Auth::user()->student->student_id)->get();
        return view('siswa.status-pendaftaran', compact('data'));
    }

    public function statusProposal()
    {
        return view('siswa.status-proposal');
    }

    public function proposalAjukan()
    {
        return view('siswa.proposal-ajukan');
    }

    // Panitia (umum)
    public function panitiaDashboard()
    {
        $studentId = Auth::user()->student->student_id;
        $acara = StudentActivity::with('members')->whereHas('members', function ($query) use ($studentId) {
            $query->where('activity_structures.student_id', $studentId);
        })
            ->get();
        return view('siswa.panitia-dashboard', compact('acara'));
    }

    public function panitiaDetail($activityCode)
    {
        $studentId = Auth::user()->student->student_id;
        $activity = StudentActivity::where('activity_code', operator: $activityCode)->first();
        $dataPanitia = ActivityStructure::with(['activity', 'student', 'role', 'subRole']) // Load both relationships
            ->whereHas('activity', function ($query) use ($activityCode) {
                $query->where('activity_code', $activityCode);
            })
            ->get();
        $existingRatings = StudentRating::where('student_activity_id', $activity->student_activity_id)
        ->where('rater_student_id', $studentId)
        ->get()
        ->keyBy('rated_student_id');
        $dataJadwal = [
            (object) [
                'tanggal' => '10 Des 2025',
                'kegiatan' => 'Rapat Persiapan',
                'ruangan' => 'Ruang B101',
                'status' => 'Dijadwalkan', // Anda bisa menggunakan kode HTML badge di sini jika perlu
            ],
            (object) [
                'tanggal' => '12 Des 2025',
                'kegiatan' => 'Koordinasi Divisi Publikasi',
                'ruangan' => 'Online (Zoom)',
                'status' => 'Selesai',
            ],
            (object) [
                'tanggal' => '15 Des 2025',
                'kegiatan' => 'Cek Perlengkapan',
                'ruangan' => 'Gudang Utama',
                'status' => 'Selesai',
            ],
            (object) [
                'tanggal' => '18 Des 2025',
                'kegiatan' => 'Briefing Panitia Inti',
                'ruangan' => 'Ruang Rapat A',
                'status' => 'Dijadwalkan',
            ],
            (object) [
                'tanggal' => '20 Des 2025',
                'kegiatan' => 'Simulasi Acara',
                'ruangan' => 'Aula Serbaguna',
                'status' => 'Belum Mulai',
            ]
        ];

        $jadwal = collect($dataJadwal);
        $panitia = collect($dataPanitia);
        return view('siswa.panitia-detail', compact('activity', 'panitia', 'jadwal', 'existingRatings'));
    }
    public function panitiaChat()
    {
        return view('siswa.chat');
    }
    public function panitiaPengurus($activityCode)
    {
        $dataPanitia = ActivityStructure::with(['activity', 'student', 'role', 'subRole']) // Load both relationships
            ->whereHas('activity', function ($query) use ($activityCode) {
                $query->where('activity_code', $activityCode);
            })
            ->get();
        $activity = StudentActivity::where('activity_code', $activityCode)->first();
        $listJabatan = StudentRole::all();
        $listDivisi = SubRole::all();
        $studentActivityId = $activity->student_activity_id;
        $listPertanyaanUntukDivisi = SubRole::with([
            'activityQuestions' => function ($query) use ($studentActivityId) {
                // This logic only affects the questions attached, not the SubRole itself
                $query->where('student_activity_id', $studentActivityId);
            }
        ])->get();
        return view('siswa.pengurus-inti', compact('activity', 'dataPanitia', 'listDivisi', 'listPertanyaanUntukDivisi'));
    public function panitiaPengurus(Request $request, $activityCode)
    {
        $activity = StudentActivity::where('activity_code', $activityCode)->firstOrFail();

        // 1. Ambil Daftar Semua Panitia di acara ini
        $panitiaList = ActivityStructure::with(['student', 'role', 'subRole'])
            ->where('student_activity_id', $activity->student_activity_id)
            ->get();

        // 2. Ambil Semua Rating di acara ini, lalu Grouping berdasarkan ID orang yang dinilai
        $allRatings = StudentRating::with('rater') // Load data penilai
            ->where('student_activity_id', $activity->student_activity_id)
            ->get()
            ->groupBy('rated_student_id'); // Kelompokkan per mahasiswa yang dinilai

        return view('siswa.pengurus-inti', compact('activity', 'panitiaList', 'allRatings'));
    }

    public function saveGrading(Request $request, $activityCode)
    {
        // Validasi input
        $request->validate([
            'grading' => 'required|array',
            'grading.*.percentage' => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->grading as $structureId => $data) {
                
                // 1. Ambil array alasan dari checkbox
                $selectedReasons = $data['reasons'] ?? [];
                
                // Jika ada review manual, tambahkan ke array
                if (!empty($data['manual_review'])) {
                    $selectedReasons[] = $data['manual_review'];
                }

                // 2. Gabungkan menjadi satu string dengan ENTER (\n) sebagai pemisah
                // Ini akan membuat setiap alasan berada di baris baru
                $finalReviewText = implode("\n", $selectedReasons);

                // 3. Update Database
                ActivityStructure::where('activity_structure_id', $structureId)->update([
                    'final_point_percentage' => $data['percentage'],
                    'final_review'           => $finalReviewText
                ]);
            }

            DB::commit();
            return back()->with('success', 'Keputusan grading berhasil disimpan! Data telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage());
        }
    }

    public function panitiaJadwal()
    {
        return view('siswa.panitia-jadwal');
    }

    public function panitiaTask()
    {
        return view('siswa.panitia-task');
    }

    // Riwayat umum
    public function riwayatAcara()
    {
        return view('siswa.riwayat-acara');
    }

    public function saveEvaluasi(Request $request, $activityCode) 
    {
        // 1. Validasi Input
        $request->validate([
            'evaluations' => 'required|array',
            'evaluations.*.stars' => 'required|integer|min:1|max:4',
            'evaluations.*.reason' => 'required|string|min:3',
        ]);

        // 2. Ambil Data Pendukung
        $user = Auth::user();
        
        // Pastikan user terhubung ke data student
        if (!$user->student) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $raterId = $user->student->student_id;

        // Cari Activity ID berdasarkan Code
        $activity = StudentActivity::where('activity_code', $activityCode)->firstOrFail();

        // 3. Proses Penyimpanan (Gunakan Transaction biar aman)
        DB::beginTransaction();
        try {
            foreach ($request->evaluations as $ratedStudentId => $data) {
                
                // Skip jika menilai diri sendiri (Double check backend side)
                if ($ratedStudentId == $raterId) continue;

                StudentRating::updateOrCreate(
                    [
                        // Kunci pencarian (agar tidak duplikat)
                        'student_activity_id' => $activity->student_activity_id,
                        'rater_student_id'    => $raterId,           // Penilai (Saya)
                        'rated_student_id'    => $ratedStudentId,    // Yang Dinilai (Teman)
                    ],
                    [
                        // Data yang diupdate/insert
                        'stars'  => $data['stars'],
                        'reason' => $data['reason'],
                    ]
                );
            }

            DB::commit();
            return back()->with('success', 'Terima kasih! Evaluasi rekan kerja berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}