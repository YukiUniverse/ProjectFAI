@extends('layouts.app')
@section('title', 'Status Proposal Acara')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-0">📊 Status Proposal Acara</h3>
            <p class="text-muted mb-0">Pantau perkembangan proposal acara yang kamu ajukan.</p>
        </div>
        <a href="{{ route('siswa.proposal-ajukan') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Ajukan Baru
        </a>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            
            @if($proposals->isEmpty())
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486747.png" alt="Empty" style="width: 80px; opacity: 0.5;" class="mb-3">
                    <h5 class="text-muted">Belum ada proposal yang diajukan.</h5>
                    <a href="{{ route('siswa.proposal-ajukan') }}" class="btn btn-outline-primary mt-2">Buat Proposal Pertama</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle table-hover">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>Nama Acara</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Organisasi</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proposals as $proposal)
                                <tr>
                                    <td class="fw-bold text-dark">{{ $proposal->title }}</td>
                                    
                                    {{-- Format Tanggal --}}
                                    <td class="text-center">
                                        {{ $proposal->created_at->translatedFormat('d M Y') }}
                                        <br>
                                        <small class="text-muted">{{ $proposal->created_at->format('H:i') }} WIB</small>
                                    </td>

                                    {{-- Nama Organisasi (Relasi) --}}
                                    <td>
                                        {{ $proposal->studentOrganization->organization_name ?? '-' }}
                                    </td>

                                    {{-- Badge Status --}}
                                    <td class="text-center">
                                        @if($proposal->status == 'pending')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-hourglass-split me-1"></i> Pending
                                            </span>
                                        @elseif($proposal->status == 'accepted')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i> Disetujui
                                            </span>
                                        @elseif($proposal->status == 'rejected')
                                            <span class="badge bg-danger">
                                                <i class="bi bi-x-circle me-1"></i> Ditolak
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($proposal->status) }}</span>
                                        @endif
                                    </td>

                                    {{-- Keterangan / Alasan Penolakan --}}
                                    <td>
                                        @if($proposal->status == 'pending')
                                            <span class="text-muted fst-italic small">Sedang ditinjau oleh Admin.</span>
                                        @elseif($proposal->status == 'accepted')
                                            <span class="text-success small fw-bold">
                                                Silakan lanjut ke tahap persiapan kegiatan.
                                            </span>
                                        @elseif($proposal->status == 'rejected')
                                            <div class="alert alert-danger p-1 mb-0 small border-0 bg-danger bg-opacity-10 text-danger">
                                                <strong>Alasan:</strong> {{ $proposal->reject_reason ?? 'Tidak disebutkan.' }}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection