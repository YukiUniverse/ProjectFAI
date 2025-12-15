<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\StudentActivity;
use App\Models\ActivityStructure;
use App\Models\StudentRating;
use App\Models\ActivitySubRole; // Import model ActivitySubRole
use App\Models\SubRole; // Pastikan model ini ada
use App\Models\RecruitmentRegistration;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Statistik Utama
        $pendingProposals = Proposal::where('status', 'pending')->count();
        $activeActivities = StudentActivity::whereIn('status', ['active', 'preparation', 'open_recruitment'])->count();
        $totalStudents = Student::count();

        // 2. Data Tabel Log Pendaftaran (100 Terakhir)
        $recentRegistrations = RecruitmentRegistration::with(['student', 'activityDetail', 'firstChoice'])
            ->latest()
            ->limit(100)
            ->get();

        // 3. Data Ringkasan KPI (5 Acara Terakhir yang Selesai) -- BARU
        $kpiSummary = StudentActivity::where('status', 'finished')
            ->orderBy('end_datetime', 'desc') // Urutkan dari yang baru selesai
            ->take(5)
            ->get();

        // Hitung rata-rata rating untuk masing-masing acara
        foreach ($kpiSummary as $act) {
            $avg = StudentRating::where('student_activity_id', $act->student_activity_id)->avg('stars');
            $act->avg_rating = $avg ? number_format($avg, 1) : 0;
        }

        return view('admin.dashboard', compact(
            'pendingProposals',
            'activeActivities',
            'totalStudents',
            'recentRegistrations',
            'kpiSummary' // <-- Kirim variabel baru ini
        ));
    }
    // --- PROPOSAL ---
    public function proposalList()
    {
        // Ambil semua proposal, urutkan dari yang terbaru
        $proposals = Proposal::with(['student', 'studentOrganization'])
            ->latest()
            ->get();
        return view('admin.proposal-list', compact('proposals'));
    }

    public function approve($id)
    {
        DB::transaction(function () use ($id) {
            $proposal = Proposal::findOrFail($id);

            // 1. Update Status Proposal
            $proposal->update(['status' => 'accepted']);

            // Cek duplikasi agar tidak double insert
            $existingActivity = StudentActivity::where('proposal_id', $proposal->id)->first();

            if (!$existingActivity) {

                // --- LOGIC 1: GENERATE SEQUENTIAL CODE (ACTXXX) ---

                // Ambil activity terakhir berdasarkan ID terbesar
                $lastActivity = StudentActivity::orderBy('student_activity_id', 'desc')->first();

                if ($lastActivity) {
                    // Ambil string kode terakhir (Misal: ACT003)
                    $lastCode = $lastActivity->activity_code;

                    // Ambil angka dibelakang "ACT" (index ke-3 sampai akhir) -> "003" jadi int 3
                    $lastNumber = (int) substr($lastCode, 3);

                    // Tambah 1
                    $nextNumber = $lastNumber + 1;
                } else {
                    // Jika belum ada data sama sekali, mulai dari 1
                    $nextNumber = 1;
                }

                // Format ulang menjadi ACT + 3 digit angka (001, 002, dst)
                $newActivityCode = 'ACT' . sprintf('%03d', $nextNumber);


                // --- LOGIC 2: BUAT ACTIVITY ---

                $activity = StudentActivity::create([
                    'proposal_id' => $proposal->id,
                    'activity_code' => $newActivityCode, // Pakai kode urut baru
                    'activity_catalog_code' => 'CAT-DEF',
                    'student_organization_id' => $proposal->student_organization_id,
                    'activity_name' => $proposal->title,
                    'activity_description' => $proposal->description,
                    'start_datetime' => $proposal->start_datetime,
                    'end_datetime' => $proposal->end_datetime,
                    'status' => 'preparation',
                ]);


                // --- LOGIC 3: MASUKKAN KETUA KE ACTIVITY STRUCTURE (ROLE BPH) ---

                // Cari ID SubRole "BPH".
                $bphRole = SubRole::where('sub_role_name', 'BPH')->first();

                if ($bphRole) {
                    // [BARU] Tambahkan BPH ke ActivitySubRole (Daftar sub role yang aktif di activity ini)
                    ActivitySubRole::create([
                        'student_activity_id' => $activity->student_activity_id,
                        'sub_role_id' => $bphRole->sub_role_id
                    ]);
                }

                ActivityStructure::create([
                    'student_activity_id' => $activity->student_activity_id,
                    'student_id' => $proposal->student_id, // ID Ketua dari Proposal
                    'student_role_id' => 1, // HARDCODE: 1 = Ketua / Role Utama
                    'sub_role_id' => $bphRole ? $bphRole->sub_role_id : null, // ID Sub Role BPH
                    'structure_name' => 'Ketua Pelaksana',
                    'structure_points' => 0, // Poin awal
                ]);
            }
        });

        return redirect()->back()->with('success', 'Proposal disetujui. Activity Code baru dibuat dan Ketua telah ditambahkan sebagai BPH.');
    }

    /**
     * Menolak Proposal dengan Alasan.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reject_reason' => 'required|string|max:1000',
        ]);

        $proposal = Proposal::findOrFail($id);

        $proposal->update([
            'status' => 'rejected',
            'reject_reason' => $request->reject_reason
        ]);

        return redirect()->back()->with('success', 'Proposal telah ditolak.');
    }

    public function verifyProposal(Request $request, $id)
    {
        $request->validate(['action' => 'required|in:approve,reject', 'reason' => 'nullable']);
        $proposal = Proposal::findOrFail($id);

        if ($request->action == 'reject') {
            $proposal->update(['status' => 'rejected', 'reject_reason' => $request->reason]);
            return back()->with('success', 'Proposal Ditolak.');
        }

        // APPROVE: Buat Kegiatan Baru
        DB::transaction(function () use ($proposal) {
            $proposal->update(['status' => 'accepted']);
            StudentActivity::create([
                'proposal_id' => $proposal->id,
                'student_organization_id' => 1, // Default ke Himpunan (ID 1 di SQL)
                'activity_code' => 'ACT' . rand(1000, 9999),
                'activity_catalog_code' => 'EVT',
                'activity_name' => $proposal->title,
                'activity_description' => $proposal->description,
                'start_datetime' => now()->addMonth(),
                'status' => 'preparation'
            ]);
        });
        return back()->with('success', 'Proposal Disetujui & Kegiatan Dibuat.');
    }

    // --- REVISI: DAFTAR ACARA + LAPORAN ACARA (GABUNGAN) ---
    public function acaraList(Request $request)
    {
        $query = StudentActivity::with('proposal.student')
            ->orderBy('start_datetime', 'desc');

        // Filter: Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter: Search Nama Acara
        if ($request->filled('search')) {
            $query->where('activity_name', 'like', '%' . $request->search . '%');
        }

        $activities = $query->get();

        // Hitung KPI jika acara sudah selesai (Untuk keperluan laporan)
        foreach ($activities as $act) {
            if ($act->status == 'finished') {
                $avg = StudentRating::where('student_activity_id', $act->student_activity_id)->avg('stars');
                $act->avg_kpi = $avg ? number_format($avg, 1) : '-';
            } else {
                $act->avg_kpi = 'On Going';
            }
        }

        return view('admin.acara-list', compact('activities'));
    }

    public function panitiaDetail($activityCode)
    {
        $activity = StudentActivity::where('activity_code', $activityCode)->firstOrFail();

        // 1. Panitia Resmi (Tabel activity_structures)
        $officialMembers = ActivityStructure::with(['student', 'role', 'subRole'])
            ->where('student_activity_id', $activity->student_activity_id)
            ->get();

        // 2. Log Pendaftaran (Tabel recruitment_registrations) -> Untuk Audit
        $registrations = RecruitmentRegistration::with(['student', 'firstChoice'])
            ->where('student_activity_id', $activity->student_activity_id)
            ->get();

        return view('admin.panitia-detail', compact('activity', 'officialMembers', 'registrations'));
    }
    // --- BARU: LAPORAN MAHASISWA ---
    public function laporanMahasiswa(Request $request)
    {
        $query = Student::with('department');

        // Filter: Search Nama Mahasiswa
        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%')
                ->orWhere('student_number', 'like', '%' . $request->search . '%');
        }

        $students = $query->paginate(50); // Pakai paginate biar rapi

        // Hitung Rata-rata KPI Global
        foreach ($students as $s) {
            $avg = StudentRating::where('rated_student_id', $s->student_id)->avg('stars');
            $s->global_kpi = $avg ? number_format($avg, 1) : '-';
        }

        return view('admin.laporan-mahasiswa', compact('students'));
    }
    public function laporanMahasiswaDetail($id)
    {
        $student = Student::with('department')->findOrFail($id);

        // 1. Ambil History Pendaftaran (Diterima / Ditolak / Pending)
        // Gunakan RecruitmentRegistration untuk melihat semua history lamaran
        $historyApplications = RecruitmentRegistration::with(['activityDetail', 'firstChoice'])
            ->where('student_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();



        $histories = ActivityStructure::with(['activity', 'role', 'subRole'])
            ->where('student_id', $id)
            ->whereHas('activity', function ($q) {
                // vvv TAMBAHKAN FILTER INI vvv
                $q->where('status', 'finished')
                    ->orderBy('start_datetime', 'desc');
            })
            ->get();

        // 3. Hitung Nilai KPI (Rata-rata Bintang) per Acara
        foreach ($histories as $h) {
            $avgStars = StudentRating::where('student_activity_id', $h->student_activity_id)
                ->where('rated_student_id', $id)
                ->avg('stars');

            $h->kpi_score = $avgStars ? number_format($avgStars, 1) : 0;
        }

        // 4. Hitung Statistik Keseluruhan
        $scoredActivities = $histories->where('kpi_score', '>', 0);
        $overallKpi = $scoredActivities->count() > 0 ? number_format($scoredActivities->avg('kpi_score'), 1) : '0.0';
        $totalEvent = $histories->count();

        return view('admin.laporan-mahasiswa-detail', compact('student', 'historyApplications', 'histories', 'overallKpi', 'totalEvent'));
    }

    // --- HISTORY GLOBAL ---
    public function historyPendaftaran()
    {
        $history = RecruitmentRegistration::with(['student', 'activityDetail'])->latest()->paginate(20);
        return view('admin.history-pendaftaran', compact('history'));
    }

    // --- FITUR E: LAPORAN KPI ---
    public function laporan()
    {
        // 1. Ambil acara yang sudah selesai (finished)
        // Kita juga bisa ambil yang 'active' jika ingin melihat monitoring berjalan
        $activities = StudentActivity::where('status', 'finished')
            ->orWhere('status', 'active')
            ->orderBy('start_datetime', 'desc')
            ->get();

        foreach ($activities as $act) {
            // 2. Hitung rata-rata bintang di acara tersebut
            $avg = StudentRating::where('student_activity_id', $act->student_activity_id)->avg('stars');

            // Format angka (misal: 3.5)
            $act->avg_rating = $avg ? number_format($avg, 1) : 0;

            // Hitung total panitia
            $act->total_staff = ActivityStructure::where('student_activity_id', $act->student_activity_id)->count();
        }

        return view('admin.laporan', compact('activities'));
    }

    public function laporanDetail($activityCode)
    {
        // Fungsi untuk melihat detail nilai per orang di satu acara
        $activity = StudentActivity::where('activity_code', $activityCode)->firstOrFail();

        $panitiaScores = ActivityStructure::with(['student', 'subRole', 'role'])
            ->where('student_activity_id', $activity->student_activity_id)
            ->get();

        // Inject score rata-rata per orang
        foreach ($panitiaScores as $p) {
            $avg = StudentRating::where('student_activity_id', $activity->student_activity_id)
                ->where('rated_student_id', $p->student_id)
                ->avg('stars');

            $p->kpi_score = $avg ? number_format($avg, 1) : '-';
        }

        return view('admin.laporan-detail', compact('activity', 'panitiaScores'));
    }
}