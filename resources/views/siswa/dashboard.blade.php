@extends('layouts.app')
@section('title', 'Dashboard Siswa')
@section('content')
    <h3>Dashboard Siswa</h3>
    <p class="text-muted">Ringkasan aktivitas, status pendaftaran, KPI pribadi, dan notifikasi.</p>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6>Jumlah Panitia Aktif</h6>
                    <p>Belum mengikuti panitia</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <h6>Jumlah Pendaftaran</h6>
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

    </div>
@endsection