@extends('layouts.app')
@section('title', 'BPH')
@section('content')
    <a href="{{ route('siswa.panitia-detail') }}" class="btn btn-danger">Back</a>
    <h5 class="fw-bold text-primary mb-3">🧭 Fitur Pengurus Inti</h5>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pendaftar">
                Pendaftar</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#struktur">Struktur</button>
        </li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jadwal">Jadwal</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tugas">Tugas</button>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="pendaftar">
            <div class="card shadow-sm p-4">
                <!-- Manajemen Pendaftar -->
                <h6 class="fw-bold text-success mt-3">🧾 Manajemen Pendaftar Panitia</h6>
                <p class="text-muted small">Tinjau data pendaftar panitia baru. Lihat CV dan berikan keputusan berdasarkan
                    pertimbangan yang relevan.</p>

                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Nama</th>
                            <th>Divisi Pilihan</th>
                            <th>CV / Portofolio</th>
                            <th>Status</th>
                            <th>Alasan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Yulia Pratiwi</td>
                            <td>Publikasi</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-outline-primary">📄 Lihat CV</a>
                            </td>
                            <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                            <td>Masih menunggu hasil wawancara.</td>
                            <td class="text-center">
                                <button class="btn btn-success btn-sm">Terima</button>
                                <button class="btn btn-danger btn-sm">Tolak</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Dani Setiawan</td>
                            <td>Perlengkapan</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-outline-primary">📄 Lihat CV</a>
                            </td>
                            <td><span class="badge bg-success">Diterima</span></td>
                            <td>Berpengalaman di acara tahun lalu.</td>
                            <td class="text-center">
                                <button class="btn btn-secondary btn-sm" disabled>Sudah Diproses</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Nadia Rahma</td>
                            <td>Acara</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-outline-primary">📄 Lihat CV</a>
                            </td>
                            <td><span class="badge bg-danger">Ditolak</span></td>
                            <td>Kuota divisi sudah penuh.</td>
                            <td class="text-center">
                                <button class="btn btn-secondary btn-sm" disabled>Sudah Diproses</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Rafi Ahmad</td>
                            <td>Konsumsi</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-outline-primary">📄 Lihat CV</a>
                            </td>
                            <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                            <td>Baru menyerahkan CV hari ini.</td>
                            <td class="text-center">
                                <button class="btn btn-success btn-sm">Terima</button>
                                <button class="btn btn-danger btn-sm">Tolak</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-success">💾 Simpan Keputusan</button>
                </div>
            </div>
        </div>



        <!-- Struktur BPH -->
        <div class="tab-pane fade" id="struktur">
            <div class="card shadow-sm p-4">
                <h6 class="fw-bold text-success mt-4">🏗️ Atur Struktur BPH & Koordinator Divisi</h6>
                <p class="text-muted small">Pilih jabatan untuk setiap panitia sesuai struktur organisasi.</p>

                <form>
                    <table class="table table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Nama Panitia</th>
                                <th>Divisi</th>
                                <th>Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $panitia = [
                                    ['nama' => 'Andi Wijaya', 'divisi' => '-'],
                                    ['nama' => 'Bella Sari', 'divisi' => '-'],
                                    ['nama' => 'Dinda Ayu', 'divisi' => '-'],
                                    ['nama' => 'Rina Sari', 'divisi' => 'Publikasi'],
                                    ['nama' => 'Budi Hartono', 'divisi' => 'Perlengkapan'],
                                    ['nama' => 'Yulia Pratiwi', 'divisi' => 'Publikasi'],
                                    ['nama' => 'Dani Setiawan', 'divisi' => 'Perlengkapan'],
                                ];
                                $jabatan = ['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Koordinator Divisi', 'Anggota'];
                            @endphp

                            @foreach($panitia as $p)
                                <tr>
                                    <td>{{ $p['nama'] }}</td>
                                    <td>{{ $p['divisi'] }}</td>
                                    <td>
                                        <select class="form-select">
                                            <option selected>- Pilih Jabatan -</option>
                                            @foreach($jabatan as $j)
                                                <option>{{ $j }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">💾 Simpan Struktur</button>
                    </div>
                </form>
            </div>
        </div>
        <hr>

        <!-- Tambah Jadwal -->
        <div class="tab-pane fade" id="jadwal">
            <div class="card shadow-sm p-4">
                <h6 class="fw-bold text-secondary mt-3">🕓 Tambah Jadwal Rapat</h6>
                <form class="row g-2 mb-3">
                    <div class="col-md-5"><input type="text" class="form-control" placeholder="Nama Kegiatan"></div>
                    <div class="col-md-4"><input type="date" class="form-control"></div>
                    <div class="col-md-3"><button class="btn btn-outline-primary w-100">Tambah Jadwal</button></div>
                </form>
            </div>
        </div>

        <!-- Tambah Tugas -->
        <div class="tab-pane fade" id="tugas">
            <div class="card shadow-sm p-4">
                <h6 class="fw-bold text-secondary mt-3">🗂️ Tambah Tugas Panitia</h6>
                <form class="row g-2">
                    <div class="col-md-6"><input type="text" class="form-control" placeholder="Nama Tugas"></div>
                    <div class="col-md-4"><input type="date" class="form-control"></div>
                    <div class="col-md-2"><button class="btn btn-outline-primary w-100">Tambah Tugas</button></div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection