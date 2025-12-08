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
                        <th>Organisasi</th> {{-- Sudah diganti --}}
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- DUMMY DATA 1 --}}
                    <tr>
                        <td>Webinar Kewirausahaan</td>
                        <td>20 Okt 2025</td>
                        <td>Himpunan Mahasiswa Bisnis</td> {{-- Dummy Org --}}
                        <td class="text-center"><span class="badge bg-warning text-dark">Pending</span></td>
                        <td>Menunggu verifikasi admin.</td>
                    </tr>

                    {{-- DUMMY DATA 2 --}}
                    <tr>
                        <td>Festival Kampus 2025</td>
                        <td>15 Okt 2025</td>
                        <td>BEM Fakultas Teknik</td> {{-- Dummy Org --}}
                        <td class="text-center"><span class="badge bg-success">Disetujui</span></td>
                        <td>Sudah disetujui, siap dilaksanakan.</td>
                    </tr>

                    {{-- DUMMY DATA 3 --}}
                    <tr>
                        <td>Lomba Desain Poster</td>
                        <td>10 Sep 2025</td>
                        <td>Himpunan Mahasiswa Bisnis</td> {{-- Dummy Org --}}
                        <td class="text-center"><span class="badge bg-danger">Ditolak</span></td>
                        <td>Judul kurang spesifik, silakan revisi.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection