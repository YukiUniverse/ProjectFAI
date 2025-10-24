@extends('layouts.app')
@section('title', 'Daftar Anggota Panitia')
@section('content')
<h3>Daftar Anggota Panitia</h3>
<p class="text-muted">Struktur organisasi panitia acara.</p>

<table class="table table-striped shadow-sm bg-white">
    <thead class="table-primary">
        <tr>
            <th>Nama</th>
            <th>Divisi</th>
            <th>Jabatan</th>
            <th>Kontak</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>Andi</td><td>Publikasi</td><td>Koordinator</td><td>andi@kampus.ac.id</td></tr>
        <tr><td>Bella</td><td>Publikasi</td><td>Anggota</td><td>bella@kampus.ac.id</td></tr>
    </tbody>
</table>

<!-- Tombol kembali -->
<div class="text-end mt-3">
    <a href="{{ route('siswa.panitia-detail') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Detail Acara</a>
</div>
@endsection
