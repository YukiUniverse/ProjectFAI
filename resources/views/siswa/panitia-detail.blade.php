@extends('layouts.app')
@section('title', 'Detail Acara Panitia')
@section('content')
    <div style="display: flex; justify-content: space-between;">
        <h3 class="mb-3">Detail Informasi Acara</h3>
        <a href="{{ route('siswa.panitia-pengurus') }}" class="btn btn-primary">Mode BPH</a>
    </div>
    <a class="btn btn-success" href="{{ route('siswa.panitia-chat') }}"
        style="position: fixed; bottom: 20px; right: 20px; z-index: 1000;">💬</a>

    <div class="card shadow-sm mb-4 p-4">
        <h4 class="fw-bold text-primary">{{$activity->activity_name}}</h4>
        <p>{{$activity->activity_description}}</p>
        <ul class="list-unstyled">
            <li>
                <strong>Tanggal:</strong>
                {{ \Carbon\Carbon::parse($activity->start_datetime)->format('d M Y, H:i') }} -
                {{ \Carbon\Carbon::parse($activity->end_datetime)->format('d M Y, H:i') }}
            </li>
            <li><strong>Lokasi:</strong> Aula Utama Kampus</li>
            <li><strong>Status:</strong> {{ $activity->status}}</li>
            <li><strong>Posisimu:</strong> Ketua Panitia</li>
        </ul>
    </div>

    <!-- NAVIGATION TAB -->
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#jadwal">📅
                Jadwal</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#anggota">👥 Anggota</button>
        </li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#evaluasi">⭐ Evaluasi</button>
        </li>
    </ul>

    <div class="tab-content">

        <!-- 📅 JADWAL -->
        <div class="tab-pane fade show active" id="jadwal">
            <div class="card shadow-sm p-4">
                <h5 class="fw-bold text-primary mb-3">📅 Jadwal & Kegiatan</h5>
                <table class="table table-bordered align-middle">
                    <thead class="table-success text-center">
                        <tr>
                            <th>Tanggal</th>
                            <th>Agenda</th>
                            <th>Tempat</th>
                            <th>Status</th>
                            <th>Aksi</th> <!-- Tambahan kolom Action -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($jadwal as $j)
                            <tr>
                                <td>{{ $j->tanggal }}</td>
                                <td>{{ $j->kegiatan }}</td>
                                <td>{{ $j->ruangan }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $j->status }}</span>
                                </td>
                                <td class="text-center">
                                    <!-- Tombol Edit -->
                                    <a href="" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>

                                    <!-- Tombol Delete -->
                                    <form action="" method="POST" style="display:inline-block;"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
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
                        <tr>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Divisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($panitia as $p)
                            <tr>
                                <td>{{ $p->student->full_name}}</td>
                                <td>{{ $p->role->role_name }}</td>
                                <td>{{ $p->subRole->sub_role_name_en }}</td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
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
                            <tr>
                                <th>Nama Panitia</th>
                                <th>Divisi</th>
                                <th>Rating</th>
                                <th>Alasan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($panitia as $p)
                                <tr>
                                    <td>{{ $p->student->full_name}}</td>
                                    <td>{{ $p->role->role_name }}</td>
                                    <td>{{ $p->subRole->sub_role_name_en }}</td>
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


    </div>

    <hr class="my-4">
    <a href="{{ route('siswa.panitia-dashboard') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Dashboard Panitia</a>

@endsection