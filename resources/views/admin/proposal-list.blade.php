@extends('layouts.admin')
@section('title', 'Manajemen Proposal')
@section('content')

<h3 class="mb-3">Manajemen Proposal Acara</h3>
<p class="text-muted">Admin dapat memverifikasi dan mengelola semua proposal yang diajukan mahasiswa.</p>

<table class="table table-bordered align-middle">
    <thead class="table-primary text-center">
        <tr>
            <th>Nama Acara</th>
            <th>Pengaju</th>
            <th>Dosen Pembimbing</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Webinar AI 2025</td>
            <td>Andi Pratama</td>
            <td>Dr. Rina Dewi</td>
            <td><span class="badge bg-warning text-dark">Pending</span></td>
            <td class="text-center">
                <a href="#" class="btn btn-success btn-sm">Setujui</a>
                <a href="#" class="btn btn-danger btn-sm">Tolak</a>
            </td>
        </tr>
        <tr>
            <td>Festival Kampus</td>
            <td>Bella Sari</td>
            <td>Dr. Surya Putra</td>
            <td><span class="badge bg-success">Disetujui</span></td>
            <td class="text-center">
                <button class="btn btn-outline-secondary btn-sm" disabled>✔</button>
            </td>
        </tr>
    </tbody>
</table>
@endsection
