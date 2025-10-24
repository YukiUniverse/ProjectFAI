@extends('layouts.app')
@section('title', 'Atur Struktur Panitia & BPH')
@section('content')
<h3>Atur Struktur Panitia & BPH</h3>
<p class="text-muted">Tetapkan ketua, wakil, sekretaris, dan koordinator divisi.</p>

<table class="table table-bordered shadow-sm bg-white">
    <thead class="table-primary">
        <tr>
            <th>Nama</th>
            <th>Divisi</th>
            <th>Jabatan</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>Andi</td><td>Publikasi</td><td><select class="form-select form-select-sm"><option>Koordinator</option></select></td></tr>
        <tr><td>Bella</td><td>Acara</td><td><select class="form-select form-select-sm"><option>Anggota</option></select></td></tr>
    </tbody>
</table>

<!-- Tombol kembali -->
<div class="text-end mt-3">
    <a href="{{ route('siswa.panitia-detail') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Detail Acara</a>
</div>
@endsection
