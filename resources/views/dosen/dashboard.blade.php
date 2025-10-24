@extends('layouts.dosen')
@section('title', 'Dashboard Dosen Pembimbing')
@section('content')

<h3 class="mb-3">Dashboard Dosen Pembimbing</h3>
<p class="text-muted">Selamat datang, Dosen Pembimbing. Anda dapat memantau hasil evaluasi (KPI) mahasiswa pada setiap acara yang mereka ikuti.</p>

<div class="card shadow-sm border-0">
    <div class="card-body text-center">
        <h5 class="text-primary fw-bold mb-2">📊 Total Mahasiswa Bimbingan</h5>
        <h3 class="fw-bold mb-3">7 Mahasiswa</h3>
        <a href="{{ route('dosen.laporan-kpi') }}" class="btn btn-primary">Lihat Laporan KPI</a>
    </div>
</div>

<div class="mt-4">
    <h5 class="fw-bold mb-2">📅 Acara Aktif Mahasiswa</h5>
    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between">
            <span>Festival Kampus 2025</span>
            <small class="text-muted">4 Mahasiswa terlibat</small>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Seminar Nasional 2025</span>
            <small class="text-muted">2 Mahasiswa terlibat</small>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Webinar AI 2025</span>
            <small class="text-muted">1 Mahasiswa terlibat</small>
        </li>
    </ul>
</div>

@endsection
