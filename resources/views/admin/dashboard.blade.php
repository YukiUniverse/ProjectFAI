@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('content')

<h3 class="mb-3">📊 Dashboard Admin</h3>
<p class="text-muted">Selamat datang di panel admin. Kelola seluruh kegiatan, proposal, dan laporan KPI panitia di sini.</p>

<!-- RINGKASAN KARTU -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 p-3 text-center">
            <h6 class="text-secondary mb-1">Total Acara</h6>
            <h3 class="fw-bold text-primary">12</h3>
            <a href="{{ route('admin.acara-list') }}" class="btn btn-outline-primary btn-sm">📅 Lihat Semua</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 p-3 text-center">
            <h6 class="text-secondary mb-1">Proposal Pending</h6>
            <h3 class="fw-bold text-warning">5</h3>
            <a href="{{ route('admin.proposal-list') }}" class="btn btn-outline-warning btn-sm">📄 Kelola Proposal</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 p-3 text-center">
            <h6 class="text-secondary mb-1">Laporan KPI Baru</h6>
            <h3 class="fw-bold text-danger">3</h3>
            <a href="{{ route('admin.laporan') }}" class="btn btn-outline-danger btn-sm">📊 Lihat Laporan</a>
        </div>
    </div>
</div>



<!-- RINGKASAN KPI -->
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="fw-bold text-primary mb-3">📈 Ringkasan KPI Acara</h5>
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-success">
                    <tr>
                        <th>Acara</th>
                        <th>Rata-Rata KPI</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Festival Kampus 2025</td>
                        <td class="text-warning fs-5">★ ★ ★ ★</td>
                        <td><span class="badge bg-success">Sangat Baik</span></td>
                    </tr>
                    <tr>
                        <td>Seminar Teknologi</td>
                        <td class="text-warning fs-5">★ ★ ★ ☆</td>
                        <td><span class="badge bg-primary">Baik</span></td>
                    </tr>
                    <tr>
                        <td>Webinar AI</td>
                        <td class="text-warning fs-5">★ ★ ☆ ☆</td>
                        <td><span class="badge bg-warning text-dark">Cukup</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
