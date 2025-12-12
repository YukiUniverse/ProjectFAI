@extends('layouts.admin')
@section('title', 'Manajemen Proposal')
@section('content')

<div class="container-fluid">
    <h3 class="mb-3 text-primary"><i class="bi bi-files me-2"></i>Manajemen Proposal Acara</h3>
    <p class="text-muted">Admin dapat memverifikasi dan mengelola semua proposal yang diajukan mahasiswa.</p>

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>Nama Acara</th>
                            <th style="width: 25%">Deskripsi</th> {{-- Kolom Baru --}}
                            <th>Pengaju (Ketua)</th>
                            <th>Organisasi</th>
                            <th>Tanggal Pelaksanaan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($proposals as $proposal)
                            <tr>
                                <td class="fw-bold text-nowrap">{{ $proposal->title }}</td>

                                {{-- Deskripsi (Dibatasi 100 karakter) --}}
                                <td>
                                    <small class="text-muted">
                                        {{ Str::limit($proposal->description, 100) }}
                                    </small>
                                </td>
                                
                                {{-- Nama Mahasiswa --}}
                                <td>
                                    {{-- Mengambil nama dari relasi student --}}
                                    <span class="fw-semibold">{{ $proposal->student->full_name ?? '-' }}</span>
                                    <br>
                                    <small class="text-muted">{{ $proposal->student->student_number ?? '' }}</small>
                                </td>

                                {{-- Nama Organisasi --}}
                                <td>{{ $proposal->studentOrganization->organization_name ?? '-' }}</td>

                                {{-- Tanggal --}}
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($proposal->start_datetime)->translatedFormat('d M Y') }}
                                </td>

                                {{-- Badge Status --}}
                                <td class="text-center">
                                    @if($proposal->status == 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($proposal->status == 'accepted')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($proposal->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>

                                {{-- Tombol Aksi --}}
                                <td class="text-center">
                                    @if($proposal->status == 'pending')
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- Form Approve --}}
                                            <form action="{{ route('admin.proposals.approve', $proposal->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menyetujui proposal ini? Activity baru akan dibuat.')">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>

                                            {{-- Button Reject (Trigger Modal) --}}
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#rejectModal{{ $proposal->id }}"
                                                    title="Tolak">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    @else
                                        <button class="btn btn-outline-secondary btn-sm" disabled>
                                            <i class="bi bi-lock"></i> Selesai
                                        </button>
                                    @endif
                                </td>
                            </tr>

                            {{-- MODAL REJECT (Per Proposal) --}}
                            <div class="modal fade" id="rejectModal{{ $proposal->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.proposals.reject', $proposal->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Tolak Proposal</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="fw-bold">Acara: {{ $proposal->title }}</p>
                                                <div class="mb-3">
                                                    <label for="reason" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                                                    <textarea name="reject_reason" class="form-control" rows="3" required placeholder="Contoh: Tanggal bertabrakan dengan acara universitas..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-danger">Tolak Proposal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada proposal masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection