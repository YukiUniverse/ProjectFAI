@extends('layouts.admin')
@section('title', 'Daftar Acara')
@section('content')

<h3 class="mb-3">Daftar Acara Aktif</h3>
<p class="text-muted">Berikut daftar acara kampus yang telah disetujui dan sedang berlangsung.</p>

<table class="table table-bordered align-middle">
    <thead class="table-primary text-center">
        <tr>
            <th>Nama Acara</th>
            <th>Ketua</th>
            <th>Periode</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Festival Kampus 2025</td>
            <td>Andi Wijaya</td>
            <td>Desember 2025</td>
            <td><span class="badge bg-success">Aktif</span></td>
            <td>
                <a href="{{ route('admin.panitia-acara-detail', ['acara' => 'festival-kampus-2025']) }}" class="btn btn-outline-primary btn-sm">
                    👥 Lihat Panitia
                </a>
            </td>
        </tr>
        <tr>
            <td>Seminar Teknologi</td>
            <td>Bella Sari</td>
            <td>November 2025</td>
            <td><span class="badge bg-success">Aktif</span></td>
            <td>
                <a href="{{ route('admin.panitia-acara-detail', ['acara' => 'seminar-teknologi']) }}" class="btn btn-outline-primary btn-sm">
                    👥 Lihat Panitia
                </a>
            </td>
        </tr>
    </tbody>
</table>

@endsection
