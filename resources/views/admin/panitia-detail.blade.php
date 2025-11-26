@extends('layouts.admin') {{-- Sesuaikan layout Anda --}}
@section('content')

<h3>Detail Panitia: {{ $activity->activity_name }}</h3>
<p>Kode: <span class="badge bg-secondary">{{ $activity->activity_code }}</span> | Status: {{ $activity->status }}</p>

<div class="card mb-4 mt-3">
    <div class="card-header bg-success text-white">✅ Panitia Resmi (Diterima)</div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Jabatan</th>
                    <th>Divisi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($officialMembers as $m)
                <tr>
                    <td>{{ $m->student->full_name }}</td>
                    <td>{{ $m->role->role_name }}</td>
                    <td>{{ $m->subRole->sub_role_name ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header bg-dark text-white">📋 Log Seleksi Pendaftaran</div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Pelamar</th>
                    <th>Pilihan Divisi</th>
                    <th>Status</th>
                    <th>Alasan (Jika Ditolak/Keputusan)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registrations as $reg)
                <tr>
                    <td>{{ $reg->student->full_name }}</td>
                    <td>{{ $reg->firstChoice->sub_role_name }}</td>
                    <td>
                        @if($reg->status == 'accepted') 
                            <span class="badge bg-success">Diterima</span>
                        @elseif($reg->status == 'rejected')
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <span class="badge bg-warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        {{-- Menampilkan kolom 'decision_reason' dari SQL --}}
                        {{ $reg->decision_reason ?? '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection