@extends('layouts.app')
@section('title', 'Dashboard Siswa')
@section('content')
<h3>Dashboard Siswa</h3>
<p class="text-muted">Ringkasan aktivitas, status pendaftaran, KPI pribadi, dan notifikasi.</p>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>Status Pendaftaran</h6>
                <p>Belum ada pendaftaran aktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>KPI Pribadi</h6>
                <h3 class="text-primary">-</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>Notifikasi</h6>
                <p>Tidak ada notifikasi baru</p>
            </div>
        </div>
    </div>
</div>
@endsection
