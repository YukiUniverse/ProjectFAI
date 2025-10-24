@extends('layouts.app')
@section('title', 'Manajemen Pendaftar & Seleksi')
@section('content')
<h3>Manajemen Pendaftar Panitia</h3>
<p class="text-muted">Kelola dan seleksi calon panitia untuk acara.</p>

<table class="table table-bordered shadow-sm bg-white">
    <thead class="table-primary">
        <tr>
            <th>Nama</th>
            <th>Divisi Pilihan</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Dina</td>
            <td>Acara</td>
            <td><span class="badge bg-warning">Pending</span></td>
            <td>
                <button class="btn btn-success btn-sm">Terima</button>
                <button class="btn btn-danger btn-sm">Tolak</button>
            </td>
        </tr>
    </tbody>
</table>

<!-- Tombol kembali -->
<div class="text-end mt-3">
    <a href="{{ route('siswa.panitia-detail') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Detail Acara</a>
</div>
@endsection
