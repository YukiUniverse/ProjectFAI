@extends('layouts.app')
@section('title', 'Detail Acara Panitia')
@section('content')

<h3 class="mb-3">Detail Informasi Acara</h3>

<div class="card shadow-sm mb-4 p-4">
    <h4 class="fw-bold text-primary">Festival Kampus 2025</h4>
    <p>Acara tahunan kampus yang diselenggarakan oleh mahasiswa lintas jurusan dengan berbagai kegiatan, lomba, dan seminar inspiratif.</p>
    <ul class="list-unstyled">
        <li><strong>Tanggal:</strong> 12–15 Desember 2025</li>
        <li><strong>Lokasi:</strong> Aula Utama Kampus</li>
        <li><strong>Status:</strong> Aktif</li>
        <li><strong>Posisimu:</strong> Ketua Panitia</li>
    </ul>
</div>

<!-- NAVIGATION TAB -->
<ul class="nav nav-tabs mb-3">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#jadwal">📅 Jadwal</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#anggota">👥 Anggota</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tugas">🗒️ Tugas</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#chat">💬 Chat</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#evaluasi">⭐ Evaluasi</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pengurus">🧭 Pengurus Inti</button></li>
</ul>

<div class="tab-content">

    <!-- 📅 JADWAL -->
    <div class="tab-pane fade show active" id="jadwal">
        <div class="card shadow-sm p-4">
            <h5 class="fw-bold text-primary mb-3">📅 Jadwal & Kegiatan</h5>
            <table class="table table-bordered align-middle">
                <thead class="table-success text-center">
                    <tr><th>Tanggal</th><th>Agenda</th><th>Tempat</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <tr><td>10 Des 2025</td><td>Rapat Persiapan</td><td>Ruang B101</td><td><span class="badge bg-info text-dark">Dijadwalkan</span></td></tr>
                    <tr><td>12 Des 2025</td><td>Technical Meeting</td><td>Aula Utama</td><td><span class="badge bg-success">Selesai</span></td></tr>
                </tbody>
            </table>

            <h6 class="fw-bold text-secondary mt-3">➕ Tambah Jadwal Baru</h6>
            <form class="row g-2">
                <div class="col-md-4"><input type="text" class="form-control" placeholder="Nama Kegiatan"></div>
                <div class="col-md-3"><input type="date" class="form-control"></div>
                <div class="col-md-3"><input type="text" class="form-control" placeholder="Lokasi"></div>
                <div class="col-md-2"><button class="btn btn-success w-100">Tambah</button></div>
            </form>
        </div>
    </div>

    <!-- 👥 ANGGOTA -->
    <div class="tab-pane fade" id="anggota">
        <div class="card shadow-sm p-4">
            <h5 class="fw-bold text-primary mb-3">👥 Struktur Panitia</h5>
            <table class="table table-bordered">
                <thead class="table-primary text-center">
                    <tr><th>Nama</th><th>Jabatan</th><th>Divisi</th></tr>
                </thead>
                <tbody>
                    <tr><td>Andi Wijaya</td><td>Ketua</td><td>-</td></tr>
                    <tr><td>Bella Sari</td><td>Wakil</td><td>-</td></tr>
                    <tr><td>Dinda Ayu</td><td>Sekretaris</td><td>-</td></tr>
                    <tr><td>Rina Sari</td><td>Koordinator</td><td>Publikasi</td></tr>
                    <tr><td>Budi Hartono</td><td>Anggota</td><td>Perlengkapan</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 🗒️ TUGAS -->
    <div class="tab-pane fade" id="tugas">
        <div class="card shadow-sm p-4">
            <h5 class="fw-bold text-primary mb-3">🗒️ Daftar Tugas Divisi</h5>
            <table class="table table-bordered align-middle mb-3">
                <thead class="table-warning text-center">
                    <tr><th>Tugas</th><th>Tenggat</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <tr><td>Desain Poster</td><td>5 Des 2025</td><td><span class="badge bg-success">Selesai</span></td></tr>
                    <tr><td>Publikasi IG Kampus</td><td>7 Des 2025</td><td><span class="badge bg-warning text-dark">Proses</span></td></tr>
                </tbody>
            </table>

            <h6 class="fw-bold text-secondary mt-3">➕ Tambah Tugas Baru</h6>
            <form class="row g-2">
                <div class="col-md-6"><input type="text" class="form-control" placeholder="Nama Tugas"></div>
                <div class="col-md-4"><input type="date" class="form-control"></div>
                <div class="col-md-2"><button class="btn btn-success w-100">Tambah</button></div>
            </form>
        </div>
    </div>

    <!-- 💬 CHAT -->
    <div class="tab-pane fade" id="chat">
        <div class="card shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-primary mb-0">💬 Forum / Chat Panitia</h5>
                <span class="badge bg-success">Online: 5</span>
            </div>
            <p class="text-muted mb-3">Gunakan forum ini untuk berdiskusi dan berkoordinasi antar panitia secara internal.</p>

            <!-- AREA PESAN -->
            <div class="border rounded p-3 mb-3 bg-light" style="height: 350px; overflow-y: auto;">
                <!-- Pesan dari orang lain -->
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <img src="https://ui-avatars.com/api/?name=Andi+Wijaya&background=198754&color=fff" 
                            class="rounded-circle" width="40" height="40">
                    </div>
                    <div class="ms-2">
                        <div class="bg-white border rounded p-2 shadow-sm" style="max-width: 75%;">
                            <strong>Andi (Ketua)</strong><br>
                            Jangan lupa upload poster besok ya!
                        </div>
                        <small class="text-muted">09:15</small>
                    </div>
                </div>

                <!-- Pesan dari user sendiri -->
                <div class="d-flex justify-content-end mb-3">
                    <div class="text-end">
                        <div class="bg-success text-white rounded p-2 shadow-sm" style="max-width: 75%;">
                            Sudah kak, tinggal posting sore ini 🙌
                        </div>
                        <small class="text-muted">09:20</small>
                    </div>
                </div>

                <!-- Pesan lain -->
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <img src="https://ui-avatars.com/api/?name=Rina+Sari&background=0d6efd&color=fff" 
                            class="rounded-circle" width="40" height="40">
                    </div>
                    <div class="ms-2">
                        <div class="bg-white border rounded p-2 shadow-sm" style="max-width: 75%;">
                            <strong>Rina (Publikasi)</strong><br>
                            Mau sekalian pakai logo fakultas juga gak?
                        </div>
                        <small class="text-muted">09:25</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end mb-3">
                    <div class="text-end">
                        <div class="bg-success text-white rounded p-2 shadow-sm" style="max-width: 75%;">
                            Boleh banget, biar lebih resmi!
                        </div>
                        <small class="text-muted">09:26</small>
                    </div>
                </div>
            </div>

            <!-- FORM INPUT PESAN -->
            <form class="input-group">
                <input type="text" class="form-control" placeholder="Ketik pesan di sini...">
                <button class="btn btn-success">Kirim</button>
            </form>
        </div>
    </div>


    <!-- ⭐ EVALUASI -->
    <div class="tab-pane fade" id="evaluasi">
        <div class="card shadow-sm p-4">
            <h5 class="fw-bold text-primary mb-3">⭐ Evaluasi Kinerja Semua Panitia</h5>
            <p class="text-muted mb-3">Berikan rating (1–4 bintang) dan alasan kontribusi setiap panitia.</p>

            <form>
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr><th>Nama Panitia</th><th>Divisi</th><th>Rating</th><th>Alasan</th></tr>
                    </thead>
                    <tbody>
                        @foreach(['Andi Wijaya'=>'Ketua','Bella Sari'=>'Wakil','Dinda Ayu'=>'Sekretaris','Rina Sari'=>'Publikasi','Budi Hartono'=>'Perlengkapan'] as $nama => $divisi)
                        <tr>
                            <td>{{ $nama }}</td>
                            <td>{{ $divisi }}</td>
                            <td class="text-center">
                                <select class="form-select w-auto mx-auto">
                                    <option>★ ☆ ☆ ☆ (1)</option>
                                    <option>★ ★ ☆ ☆ (2)</option>
                                    <option>★ ★ ★ ☆ (3)</option>
                                    <option selected>★ ★ ★ ★ (4)</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" placeholder="Masukkan alasan singkat"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-end mt-3">
                    <button class="btn btn-success">💾 Simpan Semua Evaluasi</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 🧭 PENGURUS INTI -->
    <div class="tab-pane fade" id="pengurus">
        <div class="card shadow-sm p-4">
            <h5 class="fw-bold text-primary mb-3">🧭 Fitur Pengurus Inti</h5>

            <!-- Manajemen Pendaftar -->
            <h6 class="fw-bold text-success mt-3">🧾 Manajemen Pendaftar Panitia</h6>
            <p class="text-muted small">Tinjau data pendaftar panitia baru. Lihat CV dan berikan keputusan berdasarkan pertimbangan yang relevan.</p>

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



            <!-- Struktur BPH -->
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

            <hr>

            <!-- Tambah Jadwal -->
            <h6 class="fw-bold text-secondary mt-3">🕓 Tambah Jadwal Rapat</h6>
            <form class="row g-2 mb-3">
                <div class="col-md-5"><input type="text" class="form-control" placeholder="Nama Kegiatan"></div>
                <div class="col-md-4"><input type="date" class="form-control"></div>
                <div class="col-md-3"><button class="btn btn-outline-primary w-100">Tambah Jadwal</button></div>
            </form>

            <!-- Tambah Tugas -->
            <h6 class="fw-bold text-secondary mt-3">🗂️ Tambah Tugas Panitia</h6>
            <form class="row g-2">
                <div class="col-md-6"><input type="text" class="form-control" placeholder="Nama Tugas"></div>
                <div class="col-md-4"><input type="date" class="form-control"></div>
                <div class="col-md-2"><button class="btn btn-outline-primary w-100">Tambah Tugas</button></div>
            </form>
        </div>
    </div>

</div>

<hr class="my-4">
<a href="{{ route('siswa.panitia-dashboard') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Dashboard Panitia</a>

@endsection
