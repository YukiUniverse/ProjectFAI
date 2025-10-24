@extends('layouts.app')
@section('title', 'Riwayat Keikutsertaan Acara')
@section('content')

<h3 class="mb-3">Riwayat Keikutsertaan Acara</h3>
<p class="text-muted">Lihat daftar acara yang pernah kamu ikuti beserta peran dan hasil evaluasi kinerjamu (KPI).</p>

<!-- 🟢 RATA-RATA KPI -->
<div class="card shadow-sm mb-4 border-0">
    <div class="card-body text-center">
        <h5 class="fw-bold text-primary mb-2">Rata-Rata Nilai KPI Keseluruhan</h5>
        <div class="fs-3 text-warning">★ ★ ★ ☆</div>
        <h6 class="mt-2 text-secondary">Rata-rata: <strong>3.0 / 4.0</strong> (Baik)</h6>
        <small class="text-muted">Berdasarkan 3 acara yang pernah diikuti</small>
    </div>
</div>

<!-- 📋 DAFTAR ACARA -->
<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>Nama Acara</th>
                    <th>Periode</th>
                    <th>Divisi</th>
                    <th>Jabatan</th>
                    <th>Nilai KPI</th>
             
                </tr>
            </thead>
            <tbody>
                <!-- Contoh baris 1 -->
                <tr>
                    <td>Festival Kampus 2024</td>
                    <td>Desember 2024</td>
                    <td>Publikasi</td>
                    <td>Koordinator Divisi</td>
                    <td class="text-center">
                        <span class="text-warning fs-5">★ ★ ★ ★</span><br>
                        <small class="text-muted">Sangat Baik (4.0)</small>
                    </td>
                 
                </tr>

                <!-- Contoh baris 2 -->
                <tr>
                    <td>Seminar Nasional 2023</td>
                    <td>November 2023</td>
                    <td>Acara</td>
                    <td>Anggota</td>
                    <td class="text-center">
                        <span class="text-warning fs-5">★ ★ ★ ☆</span><br>
                        <small class="text-muted">Baik (3.0)</small>
                    </td>
                
                </tr>

                <!-- Contoh baris 3 -->
                <tr>
                    <td>Webinar Creative Week</td>
                    <td>Oktober 2022</td>
                    <td>Perlengkapan</td>
                    <td>Anggota</td>
                    <td class="text-center">
                        <span class="text-warning fs-5">★ ★ ☆ ☆</span><br>
                        <small class="text-muted">Cukup (2.0)</small>
                    </td>
             
                </tr>
            </tbody>
        </table>
    </div>
</div>



@endsection
