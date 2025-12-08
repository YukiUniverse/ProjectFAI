@extends('layouts.app')
@section('title', 'Dashboard Siswa')

@push('styles')
<style>
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .icon-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        border-radius: 12px;
    }
    .card-border-left-primary { border-left: 4px solid #4e73df; }
    .card-border-left-info { border-left: 4px solid #36b9cc; }
</style>
@endpush

@section('content')
<div class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Dashboard Siswa</h3>
            <p class="text-muted mb-0">Selamat datang kembali! Berikut ringkasan aktivitasmu.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                <i class="bi bi-calendar-event me-1"></i> {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <a href="{{ route('siswa.panitia-dashboard') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift card-border-left-primary">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase fw-bold text-primary mb-1">Panitia Aktif</h6>
                                <h2 class="mb-0 fw-bold text-dark">{{ $jumAcara }}</h2>
                                <span class="small text-muted">Kepanitiaan yang sedang diikuti</span>
                            </div>
                            <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-people-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6">
            <a href="{{ route('siswa.status-pendaftaran') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100 hover-lift card-border-left-info">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-uppercase fw-bold text-info mb-1">Status Pendaftaran</h6>
                                <h2 class="mb-0 fw-bold text-dark">{{ $jumPendaftaran }}</h2>
                                <span class="small text-muted">Lamaran kepanitiaan diajukan</span>
                            </div>
                            <div class="icon-box bg-info bg-opacity-10 text-info">
                                <i class="bi bi-file-earmark-text-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="d-flex align-items-center mb-4">
        <h5 class="fw-bold mb-0 me-3"><i class="bi bi-mic-fill text-danger me-2"></i>Quick Access Interview</h5>
        <div class="flex-grow-1 border-bottom"></div>
    </div>

    <div class="row g-4">
        @forelse ($interviewList as $a)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('siswa.panitia-pendaftar', $a->activity_code) }}" class="text-decoration-none text-reset">
                    <div class="card border-0 shadow-sm h-100 hover-lift">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-circle" style="width: 40px; height: 40px; font-size: 1.2rem;">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                @php
                                    $statusColor = match($a->status) {
                                        'accepted' => 'success',
                                        'rejected' => 'danger',
                                        'pending' => 'warning',
                                        default => 'primary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }} px-3 py-2 rounded-pill">
                                    {{ ucfirst(str_replace('_', ' ', $a->status)) }}
                                </span>
                            </div>
                            
                            <h5 class="fw-bold text-dark mb-2">{{ $a->activity_name }}</h5>
                            <p class="text-muted small mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $a->activity_description }}
                            </p>
                            
                            <div class="d-flex align-items-center text-primary fw-semibold mt-auto">
                                <span>Lihat Detail</span>
                                <i class="bi bi-arrow-right ms-2"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 bg-light rounded-3 p-5 text-center">
                    <div class="mb-3 text-muted" style="font-size: 3rem;">
                        <i class="bi bi-clipboard-x"></i>
                    </div>
                    <h5 class="fw-bold text-muted">Belum ada jadwal interview</h5>
                    <p class="text-muted mb-0">Saat ini kamu belum memiliki jadwal interview aktif.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection