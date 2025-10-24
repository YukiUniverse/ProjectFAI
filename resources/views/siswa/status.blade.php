@extends('layouts.app')
@section('title', 'Status Pendaftaran & Proposal')
@section('content')

<h3 class="mb-3">Status Pendaftaran & Proposal</h3>
<p class="text-muted">Pantau status pendaftaran panitia dan proposal acara yang kamu ajukan.</p>

<ul class="nav nav-tabs" id="statusTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pendaftaran-tab" data-bs-toggle="tab" data-bs-target="#pendaftaran" type="button" role="tab">📋 Status Pendaftaran Panitia</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="proposal-tab" data-bs-toggle="tab" data-bs-target="#proposal" type="button" role="tab">📊 Status Proposal Acara</button>
    </li>
</ul>

<div class="tab-content mt-3" id="statusTabsContent">
    <!-- TAB 1: PENDAFTARAN PANITIA -->
    <div class="tab-pane fade show active" id="pendaftaran" role="tabpanel">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="mb-3 fw-bold text-primary">📋 Status Pendaftaran Panitia</h5>
                <table class="table table-bordered align-middle">
                    <thead class="table-primary">
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

        <a href="{{ route('siswa.daftar-acara') }}" class="btn btn-outline-primary">📅 Lihat Daftar Acara</a>
    </div>

    <!-- TAB 2: PROPOSAL ACARA -->
    <div class="tab-pane fade" id="proposal" role="tabpanel">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h5 class="mb-3 fw-bold text-primary">📊 Status Proposal Acara</h5>
                <table class="table table-bordered align-middle">
                    <thead class="table-primary">
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

        <a href="{{ route('siswa.proposal-ajukan') }}" class="btn btn-outline-primary">📝 Ajukan Proposal Baru</a>
    </div>
</div>


@endsection
