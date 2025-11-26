<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentRating;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function dashboard()
    {
        return view('dosen.dashboard');
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
}