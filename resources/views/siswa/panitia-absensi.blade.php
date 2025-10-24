@extends('layouts.app')
@section('title', 'Absensi Meeting')
@section('content')
<h3>Absensi Meeting</h3>
<p class="text-muted">Isi kehadiran setiap rapat yang diadakan oleh panitia.</p>

<table class="table table-bordered shadow-sm bg-white">
    <thead class="table-primary">
        <tr>
            <th>Tanggal</th>
            <th>Agenda</th>
            <th>Kehadiran</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>28 Okt 2025</td>
            <td>Rapat Koordinasi Awal</td>
            <td>
                <select class="form-select form-select-sm" style="width:130px;">
                    <option>Hadir</option>
                    <option>Tidak Hadir</option>
                </select>
            </td>
        </tr>
    </tbody>
</table>

<!-- Tombol kembali -->
<div class="text-end mt-3">
    <a href="{{ route('siswa.panitia-detail') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Detail Acara</a>
</div>
@endsection
