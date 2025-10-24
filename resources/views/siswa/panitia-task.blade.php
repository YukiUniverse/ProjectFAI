@extends('layouts.app')
@section('title', 'Daftar Tugas Divisi')
@section('content')
<h3>Task List Divisi</h3>
<p class="text-muted">Lihat daftar tugas divisi beserta progres dan deadline-nya.</p>

<table class="table table-bordered shadow-sm bg-white">
    <thead class="table-primary">
        <tr>
            <th>Tugas</th>
            <th>Status</th>
            <th>Deadline</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>Desain Poster Acara</td><td><span class="badge bg-warning">Proses</span></td><td>30 Okt 2025</td></tr>
        <tr><td>Update Instagram</td><td><span class="badge bg-success">Selesai</span></td><td>22 Okt 2025</td></tr>
    </tbody>
</table>

<!-- Tombol kembali -->
<div class="text-end mt-3">
    <a href="{{ route('siswa.panitia-detail') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Detail Acara</a>
</div>
@endsection
