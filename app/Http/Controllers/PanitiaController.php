<?php

namespace App\Http\Controllers;

use App\Models\ActivityStructure;
use App\Models\RecruitmentRegistration;
use App\Models\StudentActivity;
use App\Models\StudentRole;
use App\Models\SubRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $activity = StudentActivity::where('activity_code', operator: $activityCode)->first();
        $dataPanitia = ActivityStructure::with(['activity', 'student', 'role', 'subRole']) // Load both relationships
            ->whereHas('activity', function ($query) use ($activityCode) {
                $query->where('activity_code', $activityCode);
            })
            ->get();
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
        return view('siswa.panitia-detail', compact('activity', 'panitia', 'jadwal'));
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
}