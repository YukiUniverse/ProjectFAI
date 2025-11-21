<?php

namespace App\Http\Controllers;

use App\Models\StudentActivity;
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
        return view('siswa.status-pendaftaran');
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

    public function panitiaDetail()
    {
        $dataPanitia = [
            (object) ['nama' => 'Andi Wijaya', 'jabatan' => 'Ketua', 'divisi' => 'Inti Organisasi'],
            (object) ['nama' => 'Bella Sari', 'jabatan' => 'Wakil', 'divisi' => 'Inti Organisasi'],
            (object) ['nama' => 'Dinda Ayu', 'jabatan' => 'Sekretaris', 'divisi' => 'Inti Organisasi'],
            (object) ['nama' => 'Rina Sari', 'jabatan' => 'Publikasi', 'divisi' => 'Humas & Promosi'],
            (object) ['nama' => 'Budi Hartono', 'jabatan' => 'Perlengkapan', 'divisi' => 'Logistik'],
        ];
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
        $dataTugas = [
            (object) [
                'nama' => 'Desain Poster Promosi Acara',
                'deadline' => '25 November 2025',
                'status' => 'Selesai',
                'status_html' => '<span class="badge bg-success">Selesai</span>'
            ],
            (object) [
                'nama' => 'Pemesanan Konsumsi Panitia',
                'deadline' => '05 Desember 2025',
                'status' => 'Menunggu Persetujuan',
                'status_html' => '<span class="badge bg-warning text-dark">Menunggu Persetujuan</span>'
            ],
            (object) [
                'nama' => 'Revisi Rundown Acara Final',
                'deadline' => '10 Desember 2025',
                'status' => 'Belum Dikerjakan',
                'status_html' => '<span class="badge bg-danger">Belum Dikerjakan</span>'
            ],
            (object) [
                'nama' => 'Penyusunan Anggaran Divisi Logistik',
                'deadline' => '30 November 2025',
                'status' => 'Dalam Proses',
                'status_html' => '<span class="badge bg-info text-dark">Dalam Proses</span>'
            ],
            (object) [
                'nama' => 'Konfirmasi Pembicara Utama',
                'deadline' => '01 Januari 2026',
                'status' => 'Selesai',
                'status_html' => '<span class="badge bg-success">Selesai</span>'
            ],
        ];

        $tugas = collect($dataTugas);
        $jadwal = collect($dataJadwal);
        $panitia = collect($dataPanitia);
        return view('siswa.panitia-detail', compact('panitia', 'jadwal', 'tugas'));
    }
    public function panitiaChat()
    {
        return view('siswa.chat');
    }
    public function panitiaPengurus()
    {
        return view('siswa.pengurus-inti');
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