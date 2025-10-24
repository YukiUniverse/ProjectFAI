@extends('layouts.app')
@section('title', 'Detail Acara Panitia')
@section('content')
<h3 class="mb-3">Detail Informasi Acara</h3>

<div class="card shadow-sm mb-4 p-4">
    <h4 class="fw-bold text-primary">Festival Kampus 2025</h4>
    <p>Acara tahunan kampus yang diselenggarakan oleh mahasiswa lintas jurusan dengan berbagai kegiatan, lomba, dan seminar inspiratif.</p>
    
    <ul class="list-unstyled">
        <li><strong>Tanggal:</strong> 12–15 Desember 2025</li>
        <li><strong>Lokasi:</strong> Aula Utama Kampus</li>
        <li><strong>Status:</strong> Aktif</li>
        <li><strong>Posisimu:</strong> Koordinator Divisi Publikasi</li>
    </ul>
</div>

<div class="row g-3">
    <!-- Umum Panitia -->
    <div class="col-md-6">
        <div class="card shadow-sm p-3">
            <h5 class="fw-bold text-primary mb-3">📅 Jadwal & Kegiatan</h5>
            <p class="text-muted">Lihat agenda meeting dan timeline acara.</p>
            <a href="{{ route('siswa.panitia-jadwal') }}" class="btn btn-primary w-100">Buka Jadwal</a>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm p-3">
            <h5 class="fw-bold text-primary mb-3">👥 Daftar Anggota</h5>
            <p class="text-muted">Lihat struktur dan anggota setiap divisi.</p>
            <a href="{{ route('siswa.panitia-anggota') }}" class="btn btn-primary w-100">Lihat Anggota</a>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm p-3">
            <h5 class="fw-bold text-primary mb-3">🗒️ Task List Divisi</h5>
            <p class="text-muted">Cek tugas dan progres divisi kamu.</p>
            <a href="{{ route('siswa.panitia-task') }}" class="btn btn-primary w-100">Lihat Tugas</a>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm p-3">
            <h5 class="fw-bold text-primary mb-3">💬 Forum / Chat Panitia</h5>
            <p class="text-muted">Diskusi dan komunikasi antar panitia.</p>
            <a href="{{ route('siswa.panitia-chat') }}" class="btn btn-primary w-100">Masuk Forum</a>
        </div>
    </div>

    {{-- <div class="col-md-6">
        <div class="card shadow-sm p-3">
            <h5 class="fw-bold text-primary mb-3">✅ Absensi Meeting</h5>
            <p class="text-muted">Isi kehadiran rapat dan cek rekap presensi.</p>
            <a href="{{ route('siswa.panitia-absensi') }}" class="btn btn-primary w-100">Isi Absensi</a>
        </div>
    </div> --}}

    <div class="col-md-6">
        <div class="card shadow-sm p-3">
            <h5 class="fw-bold text-primary mb-3">⭐ Evaluasi (KPI)</h5>
            <p class="text-muted">Isi atau lihat penilaian kontribusi panitia.</p>
            <a href="{{ route('siswa.panitia-evaluasi') }}" class="btn btn-primary w-100">Buka Evaluasi</a>
        </div>
    </div>
</div>

<hr class="my-4">

<!-- Jika user adalah Ketua/Wakil/Sekretaris/Koor -->
<h5 class="text-secondary mt-4 mb-3 fw-bold">🧭 Fitur Pengurus Inti</h5>
<div class="row g-3">
    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6 class="fw-bold text-primary">🧾 Manajemen Pendaftar</h6>
            <p class="text-muted small">Lihat dan seleksi calon panitia.</p>
            <a href="{{ route('siswa.ketua-pendaftar') }}" class="btn btn-outline-primary w-100">Kelola Pendaftar</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6 class="fw-bold text-primary">🏗️ Atur Struktur Panitia</h6>
            <p class="text-muted small">Tetapkan BPH dan Koordinator Divisi.</p>
            <a href="{{ route('siswa.ketua-struktur') }}" class="btn btn-outline-primary w-100">Atur Struktur</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6 class="fw-bold text-primary">🕓 Kelola Jadwal</h6>
            <p class="text-muted small">Buat atau ubah jadwal rapat.</p>
            <a href="{{ route('siswa.ketua-jadwal') }}" class="btn btn-outline-primary w-100">Kelola Jadwal</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6 class="fw-bold text-primary">🗂️ Kelola Tugas</h6>
            <p class="text-muted small">Buat dan pantau tugas panitia.</p>
            <a href="{{ route('siswa.ketua-tugas') }}" class="btn btn-outline-primary w-100">Kelola Tugas</a>
        </div>
    </div>
{{-- 
    <div class="col-md-4">
        <div class="card shadow-sm p-3">
            <h6 class="fw-bold text-primary">📈 Input Evaluasi</h6>
            <p class="text-muted small">Nilai semua anggota panitia.</p>
            <a href="{{ route('siswa.ketua-evaluasi') }}" class="btn btn-outline-primary w-100">Input KPI</a>
        </div>
    </div> --}}
</div>

<hr class="my-4">

<a href="{{ route('siswa.panitia-dashboard') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Dashboard Panitia</a>
@endsection
