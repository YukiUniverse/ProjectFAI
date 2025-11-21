@extends('layouts.app')
@section('title', 'BPH')
@section('content')
    <a href="{{ route('siswa.panitia-detail', $activity->activity_code) }}" class="btn btn-danger">Back</a>
    <h5 class="fw-bold text-primary mb-3">🧭 Fitur Pengurus Inti</h5>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pendaftar">
                Pendaftar</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#struktur">Struktur</button>
        </li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jadwal">Jadwal</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tugas">Tugas</button>
        </li>

        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#hasil-evaluasi">
                Hasil Evaluasi
            </button>
        </li>
    </ul>
    <div class="tab-content">
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

        <div class="tab-pane fade" id="hasil-evaluasi">
            <div class="card shadow-sm p-4">
                <h6 class="fw-bold text-primary mt-3">📊 Rekapitulasi & Finalisasi Nilai</h6>
                <p class="text-muted small">Centang alasan yang valid untuk dimasukkan ke rapor akhir, dan tentukan persentase poin kelulusan.</p>

                {{-- FORM WRAPPER --}}
                <form action="{{ route('siswa.panitia-save-grading', $activity->activity_code) }}" method="POST">
                    @csrf
                    
                    <div class="accordion" id="accordionEvaluasi">
                        @foreach($panitiaList as $index => $p)
                            @php
                                $studentId = $p->student->student_id;
                                $structId  = $p->activity_structure_id; // ID untuk update database
                                $ratings   = $allRatings->get($studentId);
                                
                                // Hitung Rata-rata
                                $avgRating = 0;
                                $count = 0;
                                if($ratings) {
                                    $avgRating = $ratings->avg('stars');
                                    $count = $ratings->count();
                                }
                            @endphp

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#collapse{{ $index }}">
                                        
                                        <div class="d-flex justify-content-between w-100 align-items-center me-3">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <strong>{{ $p->student->full_name }}</strong>
                                                    <div class="text-muted" style="font-size: 0.8em">
                                                        {{ $p->role->role_name }} - {{ $p->subRole->sub_role_name_en ?? 'Core' }}
                                                    </div>
                                                </div>

                                                {{-- INPUT PERSENTASE (Dengan stopPropagation agar accordion tidak toggle saat diklik) --}}
                                                <div class="ms-4 d-flex align-items-center" onclick="event.stopPropagation();">
                                                    <label class="small me-2 fw-bold text-dark">Poin:</label>
                                                    <input type="number" 
                                                        name="grading[{{ $structId }}][percentage]" 
                                                        class="form-control form-control-sm text-center border-primary" 
                                                        style="width: 70px; font-weight: bold;"
                                                        value="{{ $p->final_point_percentage ?? 100 }}" 
                                                        min="0" max="100" step="1">
                                                    <span class="ms-1 fw-bold">%</span>
                                                </div>
                                            </div>
                                            
                                            {{-- Badge Rata-rata Nilai --}}
                                            <div>
                                                @if($count > 0)
                                                    <span class="badge {{ $avgRating >= 3 ? 'bg-success' : ($avgRating >= 2 ? 'bg-warning' : 'bg-danger') }}">
                                                        ⭐ {{ number_format($avgRating, 1) }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">No Data</span>
                                                @endif
                                            </div>
                                        </div>

                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#accordionEvaluasi">
                                    <div class="accordion-body bg-light">
                                        
                                        @if($ratings && $ratings->count() > 0)
                                            <table class="table table-sm table-bordered bg-white align-middle">
                                                <thead class="table-light text-center">
                                                    <tr>
                                                        <th style="width: 5%;">Pilih</th> <th style="width: 20%;">Penilai</th>
                                                        <th style="width: 15%;">Rating</th>
                                                        <th>Alasan / Masukan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($ratings as $r)
                                                        <tr>
                                                            <td class="text-center">
                                                                {{-- CHECKBOX ALASAN --}}
                                                                <input class="form-check-input border-secondary" 
                                                                    type="checkbox" 
                                                                    name="grading[{{ $structId }}][reasons][]" 
                                                                    value="{{ $r->reason }}"
                                                                    checked> </td>
                                                            <td>{{ $r->raterStudent->full_name ?? 'Anonim' }}</td>
                                                            <td class="text-center">
                                                                <span class="badge bg-light text-dark border">
                                                                    {{ $r->stars }} ⭐
                                                                </span>
                                                            </td>
                                                            <td>{{ $r->reason }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div class="text-muted small fst-italic">
                                                * Uncheck (hapus centang) pada alasan yang tidak ingin dimasukkan ke review akhir.
                                            </div>
                                        @else
                                            <div class="text-center py-3">
                                                <p class="text-muted mb-2">Belum ada review masuk.</p>
                                                {{-- Jika tidak ada review, input manual --}}
                                                <textarea name="grading[{{ $structId }}][manual_review]" 
                                                        class="form-control form-control-sm" 
                                                        placeholder="Tulis review manual ketua disini... (Opsional)"></textarea>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- TOMBOL SIMPAN DI BAWAH --}}
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg shadow fw-bold">
                            💾 Simpan Keputusan Akhir (Grading)
                        </button>
                    </div>

                </form>
            </div>
        </div>







    </div>
    </div>
    </div>
@endsection