@extends('layouts.app')
@section('title', 'Kelola Jadwal & Agenda')
@section('content')
<h3>Kelola Jadwal & Agenda</h3>

<form class="card p-3 shadow-sm mb-3">
    <div class="row">
        <div class="col-md-4"><input type="date" class="form-control" placeholder="Tanggal"></div>
        <div class="col-md-5"><input type="text" class="form-control" placeholder="Agenda"></div>
        <div class="col-md-3"><button class="btn btn-primary w-100">Tambah</button></div>
    </div>
</form>

<table class="table table-bordered shadow-sm bg-white">
    <thead class="table-primary"><tr><th>Tanggal</th><th>Agenda</th><th>Aksi</th></tr></thead>
    <tbody><tr><td>28 Okt 2025</td><td>Rapat Koordinasi Awal</td><td><button class="btn btn-danger btn-sm">Hapus</button></td></tr></tbody>
</table>

<!-- Tombol kembali -->
<div class="text-end mt-3">
    <a href="{{ route('siswa.panitia-detail') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Detail Acara</a>
</div>

@endsection
