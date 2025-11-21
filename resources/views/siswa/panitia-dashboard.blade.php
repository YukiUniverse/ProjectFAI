@extends('layouts.app')
@section('title', 'Dashboard Panitia')
@section('content')
    <div>
        <h3>Dashboard Panitia</h3>
        <p class="text-muted">Lihat detail acara dan kegiatan aktif.</p>
        @foreach ($acara as $a)
            <div class="card shadow-sm p-3">
                <h5>{{ $a->activity_name }}</h5>
                <p>{{ $a->activity_description }}</p>
                <div class="d-flex gap-2">
                    <a href="{{ route('siswa.panitia-detail') }}" class="btn btn-outline-primary">Detail Acara</a>
                    <a href="{{ route('siswa.panitia-jadwal') }}" class="btn btn-outline-success">Lihat Jadwal</a>
                    <a href="{{ route('siswa.panitia-task') }}" class="btn btn-outline-info">Lihat Tugas</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection