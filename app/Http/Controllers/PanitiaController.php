<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $dataAcara = [
            (object) [
                'nama' => 'Lomba Debat Bahasa Inggris (LDBI)',
                'deskripsi' => 'Ajang kompetisi debat bergengsi untuk mengasah kemampuan argumentasi dan berbahasa Inggris siswa. Terbuka untuk semua jenjang kelas.'
            ],
            (object) [
                'nama' => 'Festival Seni dan Budaya (FSB)',
                'deskripsi' => 'Perayaan kreativitas siswa melalui pameran lukisan, pertunjukan musik tradisional, dan tari modern. Disediakan stand kuliner lokal.'
            ],
            (object) [
                'nama' => 'Seminar Karir: Masa Depan Digital',
                'deskripsi' => 'Seminar inspiratif yang menghadirkan praktisi industri digital terkemuka untuk membahas tren karir di era teknologi 4.0.'
            ],
            (object) [
                'nama' => 'Olimpiade Sains Terapan',
                'deskripsi' => 'Kompetisi ilmiah yang menguji pengetahuan siswa di bidang Fisika, Kimia, dan Biologi dengan fokus pada aplikasi praktis.'
            ],
            (object) [
                'nama' => 'Turnamen E-Sport Pelajar',
                'deskripsi' => 'Kompetisi persahabatan antar kelas untuk game-game populer. Bertujuan mempererat solidaritas dan sportifitas di kalangan siswa.'
            ],
        ];

        // Ubah array tersebut menjadi Collection Laravel
        $acara = collect($dataAcara);
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
        return view('siswa.panitia-dashboard');
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