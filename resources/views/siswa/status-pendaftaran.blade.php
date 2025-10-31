@extends('layouts.app')
@section('title', 'Status Pendaftaran Panitia')
@section('content')

<h3 class="mb-3">📋 Status Pendaftaran Panitia</h3>
<p class="text-muted">Pantau status pendaftaran kamu pada berbagai acara kampus.</p>

<div class="card shadow-sm mb-3">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>Nama Acara</th>
                    <th>Divisi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Festival Kampus 2025</td>
                    <td>Publikasi</td>
                    <td><span class="badge bg-success">Diterima</span></td>
                </tr>
                <tr>
                    <td>Dies Natalis 2025</td>
                    <td>Perlengkapan</td>
                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                </tr>
                <tr>
                    <td>Seminar Digital Marketing</td>
                    <td>Acara</td>
                    <td><span class="badge bg-danger">Ditolak</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="text-end">
    <a href="{{ route('siswa.daftar-acara') }}" class="btn btn-outline-primary">📅 Lihat Daftar Acara</a>
    <a href="{{ route('siswa.status-proposal') }}" class="btn btn-primary">➡️ Lihat Status Proposal</a>
</div>

@endsection
