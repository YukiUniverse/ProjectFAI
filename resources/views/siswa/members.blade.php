@extends('layouts.app')
@section('title', 'Detail Anggota Acara')
@section('content')

{{-- Header & Tombol Kembali --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0">Detail Anggota Panitia</h3>
        <p class="text-muted mb-0">Daftar rekan kerja dalam acara <strong>{{ $activity->activity_name }}</strong></p>
    </div>
    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

{{-- Info Singkat Acara --}}
<div class="alert alert-info d-flex align-items-center mb-4" role="alert">
    <i class="bi bi-info-circle-fill fs-4 me-3"></i>
    <div>
        <strong>Waktu Pelaksanaan:</strong> {{ \Carbon\Carbon::parse($activity->start_datetime)->translatedFormat('d F Y') }} <br>
        <strong>Status:</strong> 
        @if($activity->status == 'finished')
            <span class="badge bg-success">Selesai</span>
        @elseif($activity->status == 'active')
            <span class="badge bg-primary">Aktif</span>
        @else
            <span class="badge bg-secondary">{{ ucfirst($activity->status) }}</span>
        @endif
    </div>
</div>

{{-- Tabel Anggota --}}
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold">Daftar Panitia & Anggota</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 5%">No</th>
                        <th style="width: 35%">Nama Anggota</th>
                        <th style="width: 20%">Peran (Role)</th>
                        <th style="width: 25%">Divisi (Sub Role)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $index => $member)
                        <tr>
                            <td class="ps-4">{{ $index + 1 }}</td>
                            <td>
                                {{-- 
                                    PERBAIKAN: 
                                    Mengambil data dari relasi 'student' karena $member adalah model ActivityStructure 
                                --}}
                                <div class="fw-bold">{{ $member->student->full_name ?? 'Nama Tidak Tersedia' }}</div>
                                <div class="small text-muted">
                                    {{ $member->student->student_number ?? '-' }} 
                                </div>
                            </td>
                            <td>
                                {{-- Menampilkan Role (Misal: Ketua, Anggota) --}}
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                    {{ $member->role->role_name ?? 'Anggota' }}
                                </span>
                            </td>
                            <td>
                                {{-- Menampilkan Sub Role / Divisi (Misal: Acara, Humas) --}}
                                {{ $member->subRole->sub_role_name_en ?? ($member->subRole->sub_role_name ?? '-') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-people display-6 d-block mb-2"></i>
                                Tidak ada data anggota ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
    @if($roleCode == "LEAD")
{{-- Tombol Download Excel (Di Paling Bawah) --}}
<div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
    {{-- 
        PERBAIKAN: 
        1. Mengisi href dengan route yang benar.
        2. Menggunakan primary key 'student_activity_id' (sesuai migrasi).
    --}}
    <a href="{{ route('activity.export_excel', $activity->activity_code) }}" class="btn btn-success btn-lg">
        <i class="bi bi-file-earmark-excel-fill me-2"></i> Download Excel
    </a>
</div>
@endif

@endsection