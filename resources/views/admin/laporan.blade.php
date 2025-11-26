@extends('layouts.admin')
@section('title', 'Laporan Evaluasi Panitia')
@section('content')

<h3 class="mb-3">📊 Laporan Evaluasi Panitia</h3>
<p class="text-muted">Laporan ini berisi rekap nilai KPI dari seluruh panitia di setiap acara kampus. Klik tombol <strong>"Lihat Detail"</strong> untuk melihat daftar panitia per acara.</p>

<!-- 🔍 Filter -->
<form class="row g-2 mb-4">
    <div class="col-md-4">
        <select class="form-select">
            <option selected>Semua Acara</option>
            <option>Festival Kampus 2025</option>
            <option>Seminar Nasional 2025</option>
            <option>Webinar AI 2025</option>
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">Tampilkan</button>
    </div>
</form>

<!-- 📋 TABEL LAPORAN -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="fw-bold text-primary mb-3">Rekap KPI Per Acara</h5>
        <table class="table table-bordered align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>Nama Acara</th>
                    <th>Tanggal</th>
                    <th>Jumlah Panitia</th>
                    <th>Rata-rata KPI</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Festival Kampus 2025</td>
                    <td>12–15 Desember 2025</td>
                    <td>52</td>
                    <td class="text-warning fs-5 text-center">★ ★ ★ ★</td>
                    <td><span class="badge bg-success">Sangat Baik</span></td>
                    <td class="text-center">
                        <a href="{{ route('admin.laporan-detail', ['acara' => 'festival-kampus-2025']) }}" class="btn btn-sm btn-outline-primary">
                            👁 Lihat Detail
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Seminar Nasional 2025</td>
                    <td>20–21 November 2025</td>
                    <td>37</td>
                    <td class="text-warning fs-5 text-center">★ ★ ★ ☆</td>
                    <td><span class="badge bg-primary">Baik</span></td>
                    <td class="text-center">
                        <a href="{{ route('admin.laporan-detail', ['acara' => 'seminar-nasional-2025']) }}" class="btn btn-sm btn-outline-primary">
                            👁 Lihat Detail
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>Webinar AI 2025</td>
                    <td>1–2 Oktober 2025</td>
                    <td>28</td>
                    <td class="text-warning fs-5 text-center">★ ★ ☆ ☆</td>
                    <td><span class="badge bg-warning text-dark">Cukup</span></td>
                    <td class="text-center">
                        <a href="{{ route('admin.laporan-detail', ['acara' => 'webinar-ai-2025']) }}" class="btn btn-sm btn-outline-primary">
                            👁 Lihat Detail
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- 🏅 PANITIA TERBAIK -->
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="fw-bold text-primary mb-3">🏅 Panitia Terbaik</h5>
        <table class="table table-bordered align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>Nama Panitia</th>
                    <th>Acara</th>
                    <th>Divisi</th>
                    <th>Nilai KPI</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Andi Wijaya</td>
                    <td>Festival Kampus 2025</td>
                    <td>Publikasi</td>
                    <td class="text-warning fs-5 text-center">★ ★ ★ ★</td>
                    <td><span class="badge bg-success">Sangat Baik</span></td>
                </tr>
                <tr>
                    <td>Bella Sari</td>
                    <td>Seminar Nasional 2025</td>
                    <td>Acara</td>
                    <td class="text-warning fs-5 text-center">★ ★ ★ ☆</td>
                    <td><span class="badge bg-primary">Baik</span></td>
                </tr>
                <tr>
                    <td>David Halim</td>
                    <td>Festival Kampus 2025</td>
                    <td>Perlengkapan</td>
                    <td class="text-warning fs-5 text-center">★ ★ ★ ☆</td>
                    <td><span class="badge bg-primary">Baik</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="text-end mt-4">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Dashboard</a>
</div>

@endsection
