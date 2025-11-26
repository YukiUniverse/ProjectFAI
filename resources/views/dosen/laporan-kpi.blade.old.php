@extends('layouts.dosen')
@section('title', 'Laporan KPI Mahasiswa')
@section('content')

<h3 class="mb-3">Laporan KPI Mahasiswa</h3>
<p class="text-muted">Berikut daftar seluruh mahasiswa bimbingan Anda beserta rata-rata KPI (penilaian kinerja) mereka dari berbagai acara.</p>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Program Studi</th>
                    <th>Acara Terakhir</th>
                    <th>Rata-rata KPI</th>
                    <th>Status Kinerja</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Andi Wijaya</td>
                    <td>220110123</td>
                    <td>Teknik Informatika</td>
                    <td>Festival Kampus 2025</td>
                    <td class="text-center text-warning fs-5">★ ★ ★ ★</td>
                    <td><span class="badge bg-success">Sangat Baik</span></td>
                </tr>

                <tr>
                    <td>Bella Sari</td>
                    <td>220110456</td>
                    <td>Manajemen</td>
                    <td>Seminar Nasional 2025</td>
                    <td class="text-center text-warning fs-5">★ ★ ★ ☆</td>
                    <td><span class="badge bg-primary">Baik</span></td>
                </tr>

                <tr>
                    <td>Cindy Prameswari</td>
                    <td>220110789</td>
                    <td>Desain Komunikasi Visual</td>
                    <td>Webinar AI 2025</td>
                    <td class="text-center text-warning fs-5">★ ★ ☆ ☆</td>
                    <td><span class="badge bg-warning text-dark">Cukup</span></td>
                </tr>

                <tr>
                    <td>David Halim</td>
                    <td>220110321</td>
                    <td>Teknik Industri</td>
                    <td>Festival Kampus 2025</td>
                    <td class="text-center text-warning fs-5">★ ★ ★ ★</td>
                    <td><span class="badge bg-success">Sangat Baik</span></td>
                </tr>

                <tr>
                    <td>Evelyn Putri</td>
                    <td>220110654</td>
                    <td>Hukum</td>
                    <td>Seminar Nasional 2025</td>
                    <td class="text-center text-warning fs-5">★ ★ ★ ☆</td>
                    <td><span class="badge bg-primary">Baik</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="text-end mt-3">
    <a href="{{ route('dosen.dashboard') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Dashboard</a>
</div>

@endsection
