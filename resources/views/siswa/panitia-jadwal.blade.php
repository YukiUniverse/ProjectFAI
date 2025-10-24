@extends('layouts.app')
@section('title', 'Jadwal Meeting & Kegiatan')
@section('content')
<h3>Jadwal Meeting & Kegiatan</h3>

<table class="table table-bordered shadow-sm bg-white">
    <thead class="table-primary">
        <tr>
            <th>Tanggal</th>
            <th>Agenda</th>
            <th>Divisi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>28 Okt 2025</td>
            <td>Rapat Koordinasi Awal</td>
            <td>Semua</td>
        </tr>
    </tbody>
</table>

<!-- Tombol kembali -->
<div class="text-end mt-3">
    <a href="{{ route('siswa.panitia-detail') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Detail Acara</a>
</div>
@endsection
