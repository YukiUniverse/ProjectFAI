@extends('layouts.app')
@section('title', 'Status Proposal Acara')
@section('content')

<h3 class="mb-3">📊 Status Proposal Acara</h3>
<p class="text-muted">Pantau perkembangan proposal acara yang kamu ajukan.</p>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>Nama Acara</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Dosen Pembimbing</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Webinar Kewirausahaan</td>
                    <td>20 Okt 2025</td>
                    <td>Dr. Rina Dewi</td>
                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                    <td>Menunggu verifikasi admin.</td>
                </tr>
                <tr>
                    <td>Festival Kampus 2025</td>
                    <td>15 Okt 2025</td>
                    <td>Dr. Budi Santoso</td>
                    <td><span class="badge bg-success">Disetujui</span></td>
                    <td>Sudah disetujui, siap dilaksanakan.</td>
                </tr>
                <tr>
                    <td>Lomba Desain 2025</td>
                    <td>10 Sep 2025</td>
                    <td>Dr. Surya Putra</td>
                    <td><span class="badge bg-danger">Ditolak</span></td>
                    <td>Revisi proposal diperlukan.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="text-end">
    <a href="{{ route('siswa.status-pendaftaran') }}" class="btn btn-outline-primary">⬅️ Lihat Status Pendaftaran</a>
    <a href="{{ route('siswa.proposal-ajukan') }}" class="btn btn-success">📝 Ajukan Proposal Baru</a>
</div>

@endsection
