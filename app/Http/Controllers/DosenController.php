<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentRating;
use App\Models\StudentActivity;
use App\Models\ActivityStructure;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function dashboard()
        {
            // Dashboard Dosen: Menampilkan daftar Mahasiswa dengan KPI Terbaru
            // Mengambil semua mahasiswa agar dosen bisa mencari siapa saja
            $students = Student::with('department')->limit(100)->get();

            foreach ($students as $student) {
                $avg = StudentRating::where('rated_student_id', $student->student_id)->avg('stars');
                $student->kpi_score = $avg ? number_format($avg, 1) : '-';
                
                // Acara terakhir
                $last = ActivityStructure::where('student_id', $student->student_id)->latest()->first();
                $student->last_active = $last ? $last->created_at->format('d M Y') : '-';
            }

            return view('dosen.dashboard', compact('students'));
        }


    // --- REVISI: LAPORAN ACARA (PISAH FINISHED & ONGOING) ---
    public function laporanAcara()
    {
        $allActivities = StudentActivity::orderBy('start_datetime', 'desc')->get();
        
        $ongoing = $allActivities->whereIn('status', ['active', 'preparation', 'open_recruitment', 'interview', 'grading_1', 'grading_2']);
        $finished = $allActivities->where('status', 'finished');

        return view('dosen.laporan-acara', compact('ongoing', 'finished'));
    }

    public function laporanAcaraDetail($id)
    {
        $activity = StudentActivity::findOrFail($id);
        
        // Ambil mahasiswa yang jadi panitia di acara ini
        $participants = ActivityStructure::with(['student.department', 'role', 'subRole'])
            ->where('student_activity_id', $id)
            ->get();

        return view('dosen.laporan-acara-detail', compact('activity', 'participants'));
    }

    // --- REVISI: LAPORAN MAHASISWA (GABUNG DENGAN KPI) ---
    public function laporanMahasiswa(Request $request)
    {
        $query = Student::with('department');

        // Filter Search
        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }

        $students = $query->paginate(20);

        foreach ($students as $student) {
            // Logika KPI rata-rata dipindah kesini
            $avg = StudentRating::where('rated_student_id', $student->student_id)->avg('stars');
            $student->kpi_score = $avg ? number_format($avg, 1) : '-';
            
            // Predikat
            if ($avg >= 3.5) $student->predikat = 'Sangat Baik';
            elseif ($avg >= 3.0) $student->predikat = 'Baik';
            elseif ($avg > 0) $student->predikat = 'Cukup';
            else $student->predikat = '-';
        }

        return view('dosen.laporan-mahasiswa', compact('students'));
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

        // 2. Ambil Data KPI per Acara (Hanya untuk acara yang dia diterima & dinilai)
        // Kita loop history di atas nanti di view, lalu cocokkan dengan rating
        foreach($historyApplications as $app) {
            // Cari rating yang dia dapatkan di acara tersebut
            $rating = StudentRating::where('student_activity_id', $app->student_activity_id)
                ->where('rated_student_id', $id)
                ->avg('stars'); // Ambil rata-rata jika ada multiple rater
            
            $app->kpi_score = $rating ? number_format($rating, 1) : '-';
        }

        return view('dosen.laporan-mahasiswa-detail', compact('student', 'historyApplications'));
    }

}