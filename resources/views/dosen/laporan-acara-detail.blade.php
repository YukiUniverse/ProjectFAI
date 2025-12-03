@extends('layouts.dosen')
@section('title', 'Detail Peserta Acara')
@section('content')

<a href="{{ route('dosen.laporan-acara') }}" class="btn btn-sm btn-outline-secondary mb-3">⬅ Kembali</a>

<div class="card mb-4 border-0 shadow-sm bg-primary text-white">
    <div class="card-body">
        <h4 class="mb-1">{{ $activity->activity_name }}</h4>
        <small>Kode: {{ $activity->activity_code }} | Tanggal: {{ $activity->start_datetime->format('d M Y') }}</small>
    </div>
</div>

<h5 class="fw-bold mb-3">Daftar Mahasiswa Terlibat</h5>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NRP</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jurusan</th>
                    <th>Peran / Jabatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($participants as $p)
                <tr>
                    <td>{{ $p->student->student_number }}</td>
                    <td>{{ $p->student->full_name }}</td>
                    <td>{{ $p->student->department->department_name ?? '-' }}</td>
                    <td>
                        <strong>{{ $p->role->role_name }}</strong> <br>
                        <small class="text-muted">{{ $p->subRole->sub_role_name ?? 'Inti' }}</small>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center">Belum ada peserta di acara ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection