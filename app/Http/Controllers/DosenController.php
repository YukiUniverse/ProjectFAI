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
    public function laporanKpi()
    {
        // Ambil semua mahasiswa + data jurusannya
        $students = Student::with('department')->get();

        foreach ($students as $student) {
            // Hitung rata-rata stars dari tabel 'student_ratings'
            // Dimana 'rated_student_id' adalah mahasiswa tersebut
            $avg = StudentRating::where('rated_student_id', $student->student_id)->avg('stars');
            
            $student->kpi_score = $avg ? number_format($avg, 1) : 'Belum Ada';
            
            // Logika Predikat Sederhana
            if ($avg >= 3.5) $student->predikat = 'Sangat Baik';
            elseif ($avg >= 3.0) $student->predikat = 'Baik';
            elseif ($avg > 0) $student->predikat = 'Cukup';
            else $student->predikat = '-';
        }

        return view('dosen.laporan-kpi', compact('students'));
    }

public function laporanAcara()
    {
        $activities = StudentActivity::orderBy('start_datetime', 'desc')->get();
        return view('dosen.laporan-acara', compact('activities'));
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

    // --- FITUR BARU 2: Laporan Mahasiswa (Lihat History per Mahasiswa) ---
    public function laporanMahasiswa()
    {
        $students = Student::with('department')->orderBy('full_name', 'asc')->get();
        return view('dosen.laporan-mahasiswa', compact('students'));
    }

    public function laporanMahasiswaDetail($id)
    {
        $student = Student::with('department')->findOrFail($id);
        
        // Ambil riwayat kepanitiaan
        $history = ActivityStructure::with(['activity', 'role'])
            ->where('student_id', $id)
            ->get();

        return view('dosen.laporan-mahasiswa-detail', compact('student', 'history'));
    }

}