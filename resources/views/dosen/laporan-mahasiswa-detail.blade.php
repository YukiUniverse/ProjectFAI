@extends('layouts.dosen')
@section('title', 'Detail Riwayat Mahasiswa')
@section('content')

<a href="{{ route('dosen.laporan-mahasiswa') }}" class="btn btn-sm btn-outline-secondary mb-3">⬅ Kembali</a>

<div class="card mb-4 border-0 shadow-sm bg-success text-white">
    <div class="card-body d-flex align-items-center gap-3">
        <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
            🎓
        </div>
        <div>
            <h4 class="mb-0">{{ $student->full_name }}</h4>
            <small>{{ $student->student_number }} | {{ $student->department->department_name ?? 'Umum' }}</small>
        </div>
    </div>
</div>

<h5 class="fw-bold mb-3">Riwayat Kepanitiaan</h5>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Acara</th>
                    <th>Tanggal</th>
                    <th>Jabatan</th>
                    <th>Kinerja (Review)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $h)
                <tr>
                    <td>{{ $h->activity->activity_name }}</td>
                    <td>{{ $h->activity->start_datetime->format('d M Y') }}</td>
                    <td>{{ $h->role->role_name }}</td>
                    <td>
                        {{-- Contoh menampilkan final review dari ketua --}}
                        {{ $h->final_review ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4 text-muted">Mahasiswa ini belum pernah mengikuti kepanitiaan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection