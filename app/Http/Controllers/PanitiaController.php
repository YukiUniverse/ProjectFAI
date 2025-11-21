<?php

namespace App\Http\Controllers;

use App\Models\ActivityStructure;
use App\Models\ActivitySchedule;
use App\Models\RecruitmentRegistration;
use App\Models\StudentActivity;
use App\Models\StudentRole;
use App\Models\StudentOrganization;
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
        // Ambil semua data organisasi
        $organizations = StudentOrganization::all();

        return view('siswa.proposal-ajukan', compact('organizations'));
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
        
        $jadwal = ActivitySchedule::where('student_activity_id', $activity->student_activity_id)
                    ->orderBy('start_time', 'asc')
                    ->get();
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
        // 1. Ambil Daftar Semua Panitia di acara ini
        $panitiaList = ActivityStructure::with(['student', 'role', 'subRole'])
            ->where('student_activity_id', $activity->student_activity_id)
            ->get();

        // 2. Ambil Semua Rating di acara ini, lalu Grouping berdasarkan ID orang yang dinilai
        $allRatings = StudentRating::with('rater') // Load data penilai
            ->where('student_activity_id', $activity->student_activity_id)
            ->get()
            ->groupBy('rated_student_id'); // Kelompokkan per mahasiswa yang dinilai
        $listDivisi = SubRole::all();
        $roles = StudentRole::all();
        $studentActivityId = $activity->student_activity_id;
        $listPertanyaanUntukDivisi = SubRole::with([
            'activityQuestions' => function ($query) use ($studentActivityId) {
                // This logic only affects the questions attached, not the SubRole itself
                $query->where('student_activity_id', $studentActivityId);
            }
        ])->get();
        return view('siswa.pengurus-inti', compact('activity', 'dataPanitia', 'listDivisi', 'listPertanyaanUntukDivisi', 'panitiaList', 'allRatings', 'roles'));
    }

    public function updateStructure(Request $request, $activityCode)
    {
        // Validasi
        $request->validate([
            'updates' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            // Loop setiap data yang dikirim dari form
            foreach ($request->updates as $structureId => $newRoleId) {
                
                // Update student_role_id di tabel activity_structures
                ActivityStructure::where('activity_structure_id', $structureId)
                    ->update([
                        'student_role_id' => $newRoleId
                    ]);
            }

            DB::commit();
            return back()->with('success', 'Struktur kepanitiaan berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui struktur: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $activityCode)
    {
        // 1. Validasi Input
        $request->validate([
            'status' => 'required|in:preparation,open_recruitment,interview,active,grading_1,grading_2,finished',
        ]);

        // 2. Ambil Data Activity
        $activity = StudentActivity::where('activity_code', $activityCode)->firstOrFail();

        // 3. LOGIKA KHUSUS: Jika status yang dipilih adalah 'grading_2'
        // Maka jalankan Auto-Fill Rating sebelum update status
        if ($request->status === 'grading_2') {
            
            DB::beginTransaction();
            try {
                // Ambil semua ID mahasiswa yang jadi panitia di acara ini
                $memberIds = ActivityStructure::where('student_activity_id', $activity->student_activity_id)
                    ->pluck('student_id');

                // Looping Ganda: Setiap anggota harus menilai setiap anggota lain
                foreach ($memberIds as $raterId) {       // Si Penilai
                    foreach ($memberIds as $ratedId) {   // Yang Dinilai

                        // Skip jika orang yang sama (tidak menilai diri sendiri)
                        if ($raterId == $ratedId) continue;

                        // Cek & Isi Otomatis
                        // firstOrCreate: Cek database, jika belum ada rating, buat baru.
                        // Jika sudah ada (misal si A sudah menilai si B), biarkan saja (tidak ditimpa).
                        StudentRating::firstOrCreate(
                            [
                                // KUNCI PENCARIAN (Syarat Unik)
                                'student_activity_id' => $activity->student_activity_id,
                                'rater_student_id'    => $raterId,
                                'rated_student_id'    => $ratedId,
                            ],
                            [
                                // DATA DEFAULT (Hanya dipakai jika data baru dibuat)
                                'stars'  => 4,
                                'reason' => 'No Comment',
                            ]
                        );
                    }
                }
                
                DB::commit();
                // Lanjut ke proses update status di bawah...

            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Gagal melakukan auto-fill rating: ' . $e->getMessage());
            }
        }

        // 4. Update Status ke Database
        $activity->update([
            'status' => $request->status
        ]);

        $statusLabels = [
            'preparation'      => 'Preparation',
            'open_recruitment' => 'Open Recruitment',
            'interview'        => 'Interview',
            'active'           => 'Active',
            'grading_1'        => 'Start Grading',   // <--- Sesuai Request
            'grading_2'        => 'Final Grading',   // <--- Sesuai Request
            'finished'         => 'Finished',
        ];

        // Ambil label berdasarkan status yg dipilih (default ke teks asli jika tidak ada di list)
        $statusName = $statusLabels[$request->status] ?? ucfirst($request->status);

        $message = 'Status timeline berhasil diperbarui menjadi: ' . $statusName;
        
        // Tambahan pesan jika masuk ke Final Grading
        if ($request->status === 'grading_2') {
            $message .= '. Sistem otomatis mengisi rating kosong dengan nilai default.';
        }

        return back()->with('success', $message);
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

    public function riwayatAcara()
    {
        // 1. Ambil ID Siswa Login
        $studentId = Auth::user()->student->student_id;

        // 2. Ambil Riwayat Kepanitiaan (HANYA YANG FINISHED)
        $histories = ActivityStructure::with(['activity', 'role', 'subRole'])
            ->where('student_id', $studentId)
            ->whereHas('activity', function($q) {
                // vvv TAMBAHKAN FILTER INI vvv
                $q->where('status', 'finished') 
                ->orderBy('start_datetime', 'desc');
            })
            ->get();

        // 3. Hitung Nilai KPI (Rata-rata Bintang) per Acara
        foreach ($histories as $h) {
            $avgStars = StudentRating::where('student_activity_id', $h->student_activity_id)
                ->where('rated_student_id', $studentId)
                ->avg('stars');

            $h->kpi_score = $avgStars ? number_format($avgStars, 1) : 0;
        }

        // 4. Hitung Statistik Keseluruhan
        $scoredActivities = $histories->where('kpi_score', '>', 0);
        $overallKpi = $scoredActivities->count() > 0 ? number_format($scoredActivities->avg('kpi_score'), 1) : '0.0';
        $totalEvent = $histories->count();

        return view('siswa.riwayat-acara', compact('histories', 'overallKpi', 'totalEvent'));
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