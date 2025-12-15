@extends('layouts.admin')
@section('title', 'Detail Panitia Acara')
@section('content')
    <h3 class="mb-3">👥 Daftar Panitia — Festival Kampus 2025</h3>
    <p class="text-muted">Berikut daftar panitia yang terlibat pada acara ini beserta rata-rata nilai KPI masing-masing.</p>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th>Nama Panitia</th>
                        <th>Divisi</th>
                        <th>Jabatan</th>
                        <th>Rata-Rata Nilai KPI</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Andi Wijaya</td>
                        <td>Publikasi</td>
                        <td>Ketua</td>
                        <td class="text-warning fs-5 text-center">★ ★ ★ ★</td>
                        <td><span class="badge bg-success">Sangat Baik</span></td>
                    </tr>
                    <tr>
                        <td>Rani Putri</td>
                        <td>Acara</td>
                        <td>Koordinator</td>
                        <td class="text-warning fs-5 text-center">★ ★ ★ ☆</td>
                        <td><span class="badge bg-primary">Baik</span></td>
                    </tr>
                    <tr>
                        <td>David Halim</td>
                        <td>Perlengkapan</td>
                        <td>Anggota</td>
                        <td class="text-warning fs-5 text-center">★ ★ ☆ ☆</td>
                        <td><span class="badge bg-warning text-dark">Cukup</span></td>
                    </tr>
                    <tr>
                        <td>Yuni Kartika</td>
                        <td>Konsumsi</td>
                        <td>Anggota</td>
                        <td class="text-warning fs-5 text-center">★ ★ ★ ☆</td>
                        <td><span class="badge bg-primary">Baik</span></td>
                    </tr>
                    <tr>
                        <td>Fajar Nugraha</td>
                        <td>Keamanan</td>
                        <td>Anggota</td>
                        <td class="text-warning fs-5 text-center">★ ★ ☆ ☆</td>
                        <td><span class="badge bg-warning text-dark">Cukup</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-end mt-3">
        <a href="{{ route('admin.acara-list') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Daftar Acara</a>
    </div>

@endsection