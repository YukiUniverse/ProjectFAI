@extends('layouts.app')
@section('title', 'Detail Acara Panitia')
@section('content')
    
    <div style="display: flex; justify-content: space-between;">
        <h3 class="mb-3">Detail Informasi Acara</h3>
        <a href="{{ route('siswa.panitia-pengurus', $activity->activity_code) }}" class="btn btn-primary">Mode BPH</a>
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

    
    {{-- 1. Pesan Sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 2. Pesan Error (Jaga-jaga ada error database) --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 3. Pesan Validasi (Jika ada form yang kosong/salah) --}}
    @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Perhatikan:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    


    <div class="tab-content">

        <!-- 📅 JADWAL -->
        <div class="tab-pane fade show active" id="jadwal">
            <div class="card shadow-sm p-4">
                <h5 class="fw-bold text-primary mb-3">📅 Jadwal & Kegiatan</h5>
                
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-success text-center">
                            <tr>
                                <th>Tanggal & Waktu</th>
                                <th>Agenda</th>
                                <th>Tempat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jadwal as $j)
                                <tr>
                                    <td class="text-center">
                                        {{-- Format Tanggal menggunakan Carbon --}}
                                        {{ \Carbon\Carbon::parse($j->start_time)->format('d M Y') }} <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($j->start_time)->format('H:i') }} WIB</small>
                                    </td>
                                    <td>{{ $j->title }}</td>
                                    <td>{{ $j->location }}</td>
                                    <td class="text-center">
                                        @if(strtolower($j->status) == 'completed')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('siswa.jadwal-edit', $j->id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>

                                        <!-- Tombol Delete -->
                                        <form action="{{ route('siswa.jadwal-delete', $j->id) }}" method="POST" style="display:inline-block;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted fst-italic py-3">
                                        Belum ada jadwal kegiatan. Silakan tambah jadwal baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <h6 class="fw-bold text-secondary mt-3">➕ Tambah Jadwal Baru</h6>
                {{-- FORM TAMBAH --}}
                <form action="{{ route('siswa.jadwal-store', $activity->activity_code) }}" method="POST" class="row g-2">
                    @csrf
                    <div class="col-md-4">
                        <input type="text" name="title" class="form-control" placeholder="Nama Kegiatan / Agenda" required>
                    </div>
                    <div class="col-md-3">
                        {{-- Gunakan datetime-local agar sesuai dengan field database --}}
                        <input type="datetime-local" name="start_time" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="location" class="form-control" placeholder="Lokasi / Ruangan" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">Tambah</button>
                    </div>
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
                                <td>{{ $p->role->role_name ?? "" }}</td>
                                <td>{{ $p->subRole->sub_role_name_en ?? ""}}</td>
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
                <form action="{{ route('siswa.panitia-save-evaluasi', $activity->activity_code) }}" method="POST">
                    @csrf
                    <table class="table table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Nama Panitia</th>
                                <th>Divisi</th> 
                                <th>Sub Divisi</th> 
                                <th style="width: 200px;">Rating</th>
                                <th>Alasan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($panitia as $p)
                                {{-- Cek agar tidak menilai diri sendiri --}}
                                @if($p->student->student_id !== Auth::user()->student->student_id)
                                
                                {{-- AMBIL DATA RATING SEBELUMNYA (Jika Ada) --}}
                                @php
                                    // Mengambil object rating dari collection berdasarkan ID teman
                                    $rating = $existingRatings->get($p->student->student_id);
                                @endphp

                                <tr style="--bs-table-bg-opacity: .1;">
                                    <td>
                                        {{ $p->student->full_name }}
                                        {{-- @if($rating)
                                            <br><span class="badge bg-success" style="font-size: 0.7em">Sudah Dinilai</span>
                                        @endif --}}
                                    </td>
                                    <td>{{ $p->role->role_name }}</td>
                                    <td>{{ $p->subRole->sub_role_name_en ?? '-' }}</td>
                                    
                                    <td class="text-center">
                                        <select name="evaluations[{{ $p->student->student_id }}][stars]" class="form-select w-auto mx-auto" required>
                                            <option value="" disabled {{ $rating ? '' : 'selected' }}>Pilih Rating</option>
                                            {{-- Cek apakah $rating->stars == nilai opsi. Gunakan ?-> agar tidak error jika null --}}
                                            <option value="1" {{ $rating?->stars == 1 ? 'selected' : '' }}>★ (1 - Buruk)</option>
                                            <option value="2" {{ $rating?->stars == 2 ? 'selected' : '' }}>★★ (2 - Cukup)</option>
                                            <option value="3" {{ $rating?->stars == 3 ? 'selected' : '' }}>★★★ (3 - Baik)</option>
                                            <option value="4" {{ $rating?->stars == 4 ? 'selected' : '' }}>★★★★ (4 - Sangat Baik)</option>
                                        </select>
                                    </td>
                                    
                                    <td>
                                        <input type="text" 
                                            name="evaluations[{{ $p->student->student_id }}][reason]" 
                                            class="form-control" 
                                            placeholder="Alasan / Kritik / Saran" 
                                            {{-- Isi value dengan data database jika ada --}}
                                            value="{{ $rating?->reason }}"
                                            required>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-primary">💾 Simpan / Perbarui Evaluasi</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- 🧭 PENGURUS INTI -->


    </div>

    <hr class="my-4">
    <a href="{{ route('siswa.panitia-dashboard') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Dashboard Panitia</a>

@endsection