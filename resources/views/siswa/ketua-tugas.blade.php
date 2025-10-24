@extends('layouts.app')
@section('title', 'Kelola Tugas & Monitoring')
@section('content')
<h3>Kelola Tugas Panitia</h3>
<p class="text-muted">Buat, atur, dan pantau progres tugas seluruh panitia.</p>

<form class="card p-3 shadow-sm mb-3">
    <div class="row">
        <div class="col-md-4"><input type="text" class="form-control" placeholder="Nama Tugas"></div>
        <div class="col-md-4"><input type="date" class="form-control"></div>
        <div class="col-md-4"><button class="btn btn-primary w-100">Tambah</button></div>
    </div>
</form>

<table class="table table-bordered shadow-sm bg-white">
    <thead class="table-primary"><tr><th>Tugas</th><th>Status</th><th>Deadline</th></tr></thead>
    <tbody><tr><td>Koordinasi Vendor</td><td><span class="badge bg-warning">Proses</span></td><td>1 Nov 2025</td></tr></tbody>
</table>

<!-- Tombol kembali -->
<div class="text-end mt-3">
    <a href="{{ route('siswa.panitia-detail') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Detail Acara</a>
</div>
@endsection
