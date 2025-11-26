<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\StudentActivity;
use App\Models\ActivityStructure;
use App\Models\StudentRating;
use App\Models\RecruitmentRegistration;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Hitung data real dari SQL
        $pendingProposals = Proposal::where('status', 'pending')->count();
        $activeActivities = StudentActivity::whereIn('status', ['active', 'preparation', 'open_recruitment'])->count();
        $totalStudents = Student::count();

        return view('admin.dashboard', compact('pendingProposals', 'activeActivities', 'totalStudents'));
    }

    // --- PROPOSAL ---
    public function proposalList()
    {
        $proposals = Proposal::with('student')->where('status', 'pending')->get();
        return view('admin.proposal-list', compact('proposals'));
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

    // --- KEGIATAN & PANITIA ---
    public function acaraList()
    {
        $activities = StudentActivity::with('proposal.student')->orderBy('start_datetime', 'desc')->get();
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

        foreach($activities as $act) {
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
        foreach($panitiaScores as $p) {
            $avg = StudentRating::where('student_activity_id', $activity->student_activity_id)
                ->where('rated_student_id', $p->student_id)
                ->avg('stars');
                
            $p->kpi_score = $avg ? number_format($avg, 1) : '-';
        }

        return view('admin.laporan-detail', compact('activity', 'panitiaScores'));
    }
}