@extends('layouts.admin')
@section('title', 'Detail KPI Panitia')
@section('content')

<h3 class="mb-3">📑 Detail KPI Panitia — Festival Kampus 2025</h3>
<p class="text-muted">Berikut daftar seluruh panitia dan nilai KPI mereka untuk acara ini.</p>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>Nama Panitia</th>
                    <th>Divisi</th>
                    <th>Jabatan</th>
                    <th>Nilai KPI</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Andi Wijaya</td>
                    <td>Publikasi</td>
                    <td>Koordinator</td>
                    <td class="text-warning fs-5 text-center">★ ★ ★ ★</td>
                    <td><span class="badge bg-success">Sangat Baik</span></td>
                </tr>
                <tr>
                    <td>David Halim</td>
                    <td>Perlengkapan</td>
                    <td>Anggota</td>
                    <td class="text-warning fs-5 text-center">★ ★ ★ ☆</td>
                    <td><span class="badge bg-primary">Baik</span></td>
                </tr>
                <tr>
                    <td>Rani Putri</td>
                    <td>Acara</td>
                    <td>Anggota</td>
                    <td class="text-warning fs-5 text-center">★ ★ ☆ ☆</td>
                    <td><span class="badge bg-warning text-dark">Cukup</span></td>
                </tr>
                <tr>
                    <td>Yuni Kartika</td>
                    <td>Publikasi</td>
                    <td>Anggota</td>
                    <td class="text-warning fs-5 text-center">★ ★ ★ ☆</td>
                    <td><span class="badge bg-primary">Baik</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="text-end">
    <a href="{{ route('admin.laporan') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Laporan Utama</a>
</div>

@endsection
