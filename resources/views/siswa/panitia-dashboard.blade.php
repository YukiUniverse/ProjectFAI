@extends('layouts.app')
@section('title', 'Dashboard Panitia')
@section('content')
<h3>Dashboard Panitia</h3>
<p class="text-muted">Lihat detail acara dan kegiatan aktif.</p>

<div class="card shadow-sm p-3">
    <h5>Festival Kampus 2025</h5>
    <p>Acara aktif yang sedang kamu ikuti.</p>
    <div class="d-flex gap-2">
        <a href="{{ route('siswa.panitia-detail') }}" class="btn btn-outline-primary">Detail Acara</a>
        <a href="{{ route('siswa.panitia-jadwal') }}" class="btn btn-outline-success">Lihat Jadwal</a>
        <a href="{{ route('siswa.panitia-task') }}" class="btn btn-outline-info">Lihat Tugas</a>
    </div>
</div>


@endsection
