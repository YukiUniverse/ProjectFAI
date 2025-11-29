@extends('layouts.app')
@section('title', 'BPH')
@section('content')

    {{-- CSS Sederhana --}}
    <style>
        .description-box {
            background-color: #f8f9fa;
            border-left: 5px solid #0d6efd;
            transition: all 0.3s ease;
        }
        .stepper-item.step-selected .step-counter {
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.3);
            transform: scale(1.1);
        }
    </style>

    {{-- Header & Navigasi --}}
    <a href="{{ route('siswa.panitia-detail', $activity->activity_code) }}" class="btn btn-danger">Back</a>
    <h5 class="fw-bold text-primary mb-3 mt-2">🧭 Fitur Pengurus Inti</h5>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#timeline">Timeline</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pertanyaan">Pertanyaan</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pendaftar">Pendaftar</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#struktur">Struktur</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jadwal">Jadwal</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#divisi">Divisi</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#hasil-evaluasi">Hasil Evaluasi</button></li>
    </ul>

    {{-- Alert Messages (Ditaruh di luar tab-content agar selalu muncul) --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
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

    {{-- KONTEN TAB --}}
    <div class="tab-content">

        {{-- TAB 1: TIMELINE (Active Default) --}}
        <div class="tab-pane fade show active" id="timeline">
            @php
                $steps = [
                    'preparation'      => ['label' => 'Preparation', 'desc' => 'Setting up the committee structure.'],
                    'open_recruitment' => ['label' => 'Open Rec', 'desc' => 'Publishing registration forms.'],
                    'interview'        => ['label' => 'Interview', 'desc' => 'Conducting interviews.'],
                    'active'           => ['label' => 'Active', 'desc' => 'Committee is executing work programs.'],
                    'grading_1'        => ['label' => 'Start Grading', 'desc' => 'Evaluating performance.'],
                    'grading_2'        => ['label' => 'Final Grading', 'desc' => 'Final evaluation by leader.'],
                    'finished'         => ['label' => 'Finished', 'desc' => 'Project complete.']
                ];
                
                $statusKeys = array_keys($steps);
                
                // 1. Cari Index (Urutan) dari status saat ini di database
                $currentStatusIndex = array_search($activity->status, $statusKeys);
            @endphp


            <div class="timeline-container mt-3">
                <div class="stepper-wrapper">
                    @foreach($steps as $key => $data)
                        @php 
                            $loopIndex = $loop->index; 
                            $statusClass = '';

                            // LOGIKA PENENTUAN STATUS
                            if ($currentStatusIndex !== false) {
                                if ($loopIndex < $currentStatusIndex) {
                                    $statusClass = 'completed'; // Sudah lewat
                                } elseif ($loopIndex == $currentStatusIndex) {
                                    $statusClass = 'active';    // Sedang berlangsung
                                }
                            }
                        @endphp

                        <div class="stepper-item {{ $statusClass }}" 
                            onclick="updateDescription(this, '{{ addslashes($data['desc']) }}')" 
                            style="cursor: pointer;">
                            
                            <div class="step-counter">
                                {{-- Jika selesai, tampilkan Centang, jika tidak tampilkan Nomor --}}
                                @if($statusClass == 'completed')
                                    ✔
                                @else
                                    {{ $loopIndex + 1 }}
                                @endif
                            </div>
                            
                            <div class="step-name">{{ $data['label'] }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="description-box mt-4 p-3 border rounded bg-light">
                    <strong>Description:</strong>
                    {{-- Tampilkan deskripsi status saat ini secara default --}}
                    <p class="m-0" id="desc-text">
                        {{ $steps[$activity->status]['desc'] ?? 'Click on a step to see details.' }}
                    </p>
                </div>
            </div>

            {{-- Form Update Status --}}
            <form action="{{ route('siswa.panitia-update-status', $activity->activity_code) }}" class="row g-2 mb-3 mt-3" method="POST">
                @csrf
                
                <select class="form-select col-md-3" name="status">
                    <option value="preparation" {{ $activity->status == 'preparation' ? 'selected' : '' }}>
                        Preparation
                    </option>
                    <option value="open_recruitment" {{ $activity->status == 'open_recruitment' ? 'selected' : '' }}>
                        Open Recruitment
                    </option>
                    <option value="interview" {{ $activity->status == 'interview' ? 'selected' : '' }}>
                        Interview
                    </option>
                    <option value="active" {{ $activity->status == 'active' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="grading_1" {{ $activity->status == 'grading_1' ? 'selected' : '' }}>
                        Start Grading
                    </option>
                    <option value="grading_2" {{ $activity->status == 'grading_2' ? 'selected' : '' }}>
                        Final Grading
                    </option>
                    <option value="finished" {{ $activity->status == 'finished' ? 'selected' : '' }}>
                        Finish
                    </option>
                </select>

                <button class="btn btn-primary col-md-2" type="submit">Update Timeline</button>
            </form>
        </div>

        {{-- TAB 2: PERTANYAAN --}}
        <div class="tab-pane fade" id="pertanyaan">
            @forelse ($listPertanyaanUntukDivisi as $d)
                <div class="card shadow-sm p-4 mb-3">
                    <h6 class="fw-bold text-secondary mt-3">Pertanyaan untuk divisi {{ $d->sub_role_name }}</h6>
                    <ol>
                        @forelse($d->activityQuestions as $question)
                            <li>{{ $question->question }}</li>
                        @empty
                            <li class="text-muted">Belum ada pertanyaan.</li>
                        @endforelse
                    </ol>
                    <form class="row g-2 mb-3" method="post" action="{{ route('siswa.tambah-pertanyaan', $activity->activity_code) }}">
                        @csrf
                        <input type="text" name="sub_role_id" id="" value="{{ $d->sub_role_id }}" hidden>
                        <input type="text" name="student_activity_id" id="" value="{{ $activity->student_activity_id }}" hidden>
                        <div class="col-md-5">
                            <input type="text" name="question" class="form-control" placeholder="Tambah Pertanyaan">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-primary w-100">Tambah</button>
                        </div>
                    </form>
                </div>
            @empty
                <div class="alert alert-info mt-3">Belum ada data divisi untuk pertanyaan.</div>
            @endforelse
        </div>

        {{-- TAB 3: PENDAFTAR --}}
        <div class="tab-pane fade" id="pendaftar">
            <div class="card shadow-sm p-4">
                <h6 class="fw-bold text-success mt-3">🧾 Manajemen Pendaftar Panitia</h6>
                <p class="text-muted small">Tinjau data pendaftar panitia baru.</p>
                
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Nama</th> <th>Divisi 1</th> <th>Divisi 2</th> <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listPendaftar as $p)
                        <tr>
                            <td>{{$p->student->full_name}}</td> 
                            <td>{{$p->firstChoice->sub_role_name}}</td>
                            <td>{{$p->secondChoice?->sub_role_name}}</td>
                            <td><span class="badge bg-{{ $p->status == "accepted"?"success":($p->status == "rejected"?"danger":"warning") }} text-dark">{{ $p->status }}</span></td>
                        </tr>
                        @empty
                        Belum ada pendaftar
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- TAB 4: STRUKTUR --}}
        <div class="tab-pane fade" id="struktur">
            <div class="card shadow-sm p-4">
                
                {{-- HEADER DENGAN TOMBOL INVITE --}}
                <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                    <h6 class="fw-bold text-success m-0">🏗️ Atur Struktur BPH & Koordinator Divisi</h6>
                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#inviteModal">
                        <i class="bi bi-person-plus-fill"></i> + Invite Member
                    </button>
                </div>

                {{-- FORM UPDATE STRUKTUR --}}
                <form action="{{ route('siswa.panitia-update-struktur', $activity->activity_code) }}" method="POST">
                    @csrf
                    
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Nama</th>
                                    <th style="width: 30%">Divisi (Sub Role)</th>
                                    <th style="width: 25%">Jabatan (Role)</th>
                                    <th style="width: 10%">Aksi</th> {{-- KOLOM BARU --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($panitiaList as $p)
                                    {{-- LOGIKA FLEKSIBEL (ANTI ERROR) --}}
                                    @php 
                                        $currentRoleName = $p->role?->role_name; 
                                        $isKetua = ($currentRoleName === 'Ketua'); 
                                    @endphp

                                    <tr>
                                        <td>
                                            <strong>{{ $p->student->full_name }}</strong>
                                        </td>
                                        
                                        {{-- KOLOM UBAH DIVISI --}}
                                        <td>
                                            @if($isKetua)
                                                <div class="text-center text-muted small">
                                                    - Inti -
                                                    <input type="hidden" name="updates[{{ $p->activity_structure_id }}][sub_role_id]" value="">
                                                </div>
                                            @else
                                                <select class="form-select form-select-sm" name="updates[{{ $p->activity_structure_id }}][sub_role_id]">
                                                    <option value="">-- Non-Divisi / Inti --</option>
                                                    @foreach($subRoles as $sub)
                                                        <option value="{{ $sub->sub_role_id }}" 
                                                            {{ $p->sub_role_id == $sub->sub_role_id ? 'selected' : '' }}>
                                                            {{ $sub->sub_role_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                        
                                        {{-- KOLOM UBAH JABATAN --}}
                                        <td>
                                            @if($isKetua)
                                                <div class="text-center text-primary fw-bold small">
                                                    <i class="bi bi-lock-fill"></i> Ketua Panitia
                                                    <input type="hidden" name="updates[{{ $p->activity_structure_id }}][role_id]" value="{{ $p->student_role_id }}">
                                                </div>
                                            @else
                                                <select class="form-select form-select-sm" name="updates[{{ $p->activity_structure_id }}][role_id]">
                                                    @if(is_null($p->student_role_id))
                                                        <option value="" selected disabled>-- Pilih Jabatan --</option>
                                                    @endif

                                                    @foreach($roles as $r)
                                                        @if($r->role_name !== 'Ketua')
                                                            <option value="{{ $r->student_role_id }}" 
                                                                {{ $p->student_role_id == $r->student_role_id ? 'selected' : '' }}>
                                                                {{ $r->role_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>

                                        {{-- KOLOM AKSI (KICK) --}}
                                        <td class="text-center">
                                            @if($isKetua)
                                                <span class="text-muted small">-</span>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmKick('{{ route('siswa.panitia-kick', $p->activity_structure_id) }}')"
                                                    title="Keluarkan Anggota">
                                                    <i class="bi bi-person-x"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">💾 Simpan Perubahan Struktur</button>
                    </div>
                </form>

                {{-- FORM HIDDEN UNTUK PROSES KICK (Di luar form utama agar valid HTML) --}}
                <form id="kickForm" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>

            </div>
        </div>

    

        {{-- MODAL INVITE MEMBER (Tetap Sama) --}}
        <div class="modal fade" id="inviteModal" tabindex="-1" aria-labelledby="inviteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('siswa.panitia-invite', $activity->activity_code) }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="inviteModalLabel">📩 Undang Anggota Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            
                            {{-- 1. INPUT NIM (Pencarian) --}}
                            <div class="mb-3">
                                <label for="searchNim" class="form-label">Cari Mahasiswa (NIM)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchNim" placeholder="Masukkan NIM..." onchange="findStudent(this.value)">
                                    <button class="btn btn-outline-secondary" type="button" onclick="triggerSearch()">Cari</button>
                                </div>
                                <small class="text-muted">Tekan Enter atau klik Cari setelah mengetik NIM.</small>
                            </div>

                            {{-- 2. HASIL PENCARIAN (Auto Fill) --}}
                            <div id="studentResult" class="d-none">
                                <div class="alert alert-success py-2">
                                    <i class="bi bi-check-circle"></i> Mahasiswa Ditemukan!
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control bg-light" id="studentName" readonly>
                                </div>
                                
                                {{-- Hidden Input untuk kirim ID ke Controller --}}
                                <input type="hidden" name="student_id" id="studentIdHidden">
                            </div>

                            {{-- 3. ERROR MESSAGE --}}
                            <div id="studentError" class="alert alert-danger py-2 d-none">
                                <i class="bi bi-x-circle"></i> Mahasiswa tidak ditemukan.
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" id="btnInvite" disabled>Kirim Undangan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        {{-- TAB 5: JADWAL --}}
        <div class="tab-pane fade" id="jadwal">
            <div class="card shadow-sm p-4">
                <h6 class="fw-bold text-secondary mt-3">🕓 Tambah Jadwal Rapat</h6>
                
                {{-- FORM UPDATE --}}
                <form action="{{ route('siswa.jadwal-store', $activity->activity_code) }}" method="POST" class="row g-2 mb-3">
                    @csrf
                    
                    {{-- 1. Judul Kegiatan --}}
                    <div class="col-md-4">
                        <input type="text" name="title" class="form-control" placeholder="Nama Kegiatan" required>
                    </div>

                    {{-- 2. Waktu (Gunakan datetime-local agar sesuai controller) --}}
                    <div class="col-md-3">
                        <input type="datetime-local" name="start_time" class="form-control" required>
                    </div>

                    {{-- 3. Lokasi (Wajib ditambahkan karena required di DB) --}}
                    <div class="col-md-3">
                        <input type="text" name="location" class="form-control" placeholder="Lokasi / Ruang" required>
                    </div>

                    {{-- 4. Tombol Submit --}}
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-outline-primary w-100">Tambah</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TAB 6: HASIL EVALUASI --}}
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
                                $structId  = $p->activity_structure_id;
                                $ratings   = $allRatings->get($studentId);
                                $avgRating = $ratings ? $ratings->avg('stars') : 0;
                                $count     = $ratings ? $ratings->count() : 0;
                            @endphp

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}">
                                        
                                        <div class="d-flex justify-content-between w-100 align-items-center me-3">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <strong>{{ $p->student->full_name }}</strong>
                                                    <div class="text-muted small">{{ $p->role->role_name ?? "" }}</div>
                                                </div>

                                                {{-- INPUT PERSENTASE --}}
                                                <div class="ms-4 d-flex align-items-center" onclick="event.stopPropagation();">
                                                    <label class="small me-2 fw-bold text-dark">Poin:</label>
                                                    <input type="number" name="grading[{{ $structId }}][percentage]" class="form-control form-control-sm text-center" style="width: 70px;" value="{{ $p->final_point_percentage ?? 100 }}" min="0" max="100">
                                                    <span class="ms-1 fw-bold">%</span>
                                                </div>
                                            </div>
                                            
                                            <div>
                                                @if($count > 0)
                                                    <span class="badge {{ $avgRating >= 3 ? 'bg-success' : 'bg-warning' }}">⭐ {{ number_format($avgRating, 1) }}</span>
                                                @else
                                                    <span class="badge bg-secondary">No Data</span>
                                                @endif
                                            </div>
                                        </div>

                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#accordionEvaluasi">
                                    <div class="accordion-body bg-light">
                                        @if($ratings && $count > 0)
                                            <table class="table table-sm table-bordered bg-white">
                                                <thead><tr><th>Pilih</th><th>Penilai</th><th>Rating</th><th>Alasan</th></tr></thead>
                                                <tbody>
                                                    @foreach($ratings as $r)
                                                        <tr>
                                                            <td class="text-center">
                                                                <input type="checkbox" name="grading[{{ $structId }}][reasons][]" value="{{ $r->reason }}" checked>
                                                            </td>
                                                            <td>{{ $r->raterStudent->full_name ?? 'Anonim' }}</td>
                                                            <td>{{ $r->stars }} ⭐</td>
                                                            <td>{{ $r->reason }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <div class="text-center py-2">
                                                No Review
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success btn-lg shadow fw-bold">💾 Simpan Keputusan Akhir (Grading)</button>
                    </div>
                </form>
            </div>
        </div>


        {{-- TAB BARU: MANAJEMEN DIVISI (SUB ROLE) --}}
        <div class="tab-pane fade" id="divisi">
            <div class="row">
                {{-- KOLOM KIRI: DAFTAR DIVISI --}}
                <div class="col-md-8">
                    <div class="card shadow-sm p-4 h-100">
                        <h6 class="fw-bold text-primary mb-3">📂 Daftar Divisi Acara</h6>
                        
                        @if($activitySubRoles->count() > 0)
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama Divisi (ID)</th>
                                        <th>Nama Divisi (EN)</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activitySubRoles as $div)
                                        <tr>
                                            <td><span class="badge bg-secondary">{{ $div->sub_role_code }}</span></td>
                                            <td>{{ $div->sub_role_name }}</td>
                                            <td>{{ $div->sub_role_name_en ?? '-' }}</td>
                                            <td class="text-center">
                                                {{-- Tombol Edit --}}
                                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $div->sub_role_id }}">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                {{-- Tombol Delete (Soft Delete) --}}
                                                <form action="{{ route('siswa.panitia-subrole-delete', $div->sub_role_id) }}" 
                                                    method="POST" 
                                                    class="d-inline"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus divisi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>

                                                {{-- MODAL EDIT (Di-loop agar setiap data punya modal sendiri) --}}
                                                <div class="modal fade" id="editModal{{ $div->sub_role_id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog text-start">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning text-dark">
                                                                <h5 class="modal-title">✏️ Edit Divisi</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            
                                                            <form action="{{ route('siswa.panitia-subrole-update', $div->sub_role_id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT') 
                                                                
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">Kode Divisi</label>
                                                                        <input type="text" name="sub_role_code" class="form-control" 
                                                                            value="{{ $div->sub_role_code }}" required maxlength="10">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">Nama Divisi (ID)</label>
                                                                        <input type="text" name="sub_role_name" class="form-control" 
                                                                            value="{{ $div->sub_role_name }}" required>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">Nama Divisi (EN)</label>
                                                                        <input type="text" name="sub_role_name_en" class="form-control" 
                                                                            value="{{ $div->sub_role_name_en }}">
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- END MODAL --}}

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-info">
                                Belum ada divisi yang dibuat. Silakan buat divisi baru di formulir sebelah kanan.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- KOLOM KANAN: FORM TAMBAH --}}
                <div class="col-md-4">
                    <div class="card shadow-sm p-4 h-100 bg-light border-primary">
                        <h6 class="fw-bold text-success mb-3">➕ Buat Divisi Baru</h6>
                        <form action="{{ route('siswa.panitia-subrole-store', $activity->activity_code) }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Kode Divisi</label>
                                <input type="text" name="sub_role_code" class="form-control" placeholder="Contoh: PUB, ACR" maxlength="10" required>
                                <div class="form-text">Maksimal 10 karakter unik.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Nama Divisi (Indonesia)</label>
                                <input type="text" name="sub_role_name" class="form-control" placeholder="Contoh: Publikasi & Dokumentasi" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Nama Divisi (Inggris) - Opsional</label>
                                <input type="text" name="sub_role_name_en" class="form-control" placeholder="Contoh: Publication & Documentation">
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success fw-bold">
                                    Simpan Divisi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div> {{-- END TAB CONTENT --}}

    <script>
        function updateDescription(element, text) {
            document.getElementById('desc-text').innerText = text;
            document.querySelectorAll('.stepper-item').forEach(el => el.classList.remove('step-selected'));
            element.classList.add('step-selected');
        }

        function confirmKick(url) {
            if (confirm('⚠️ Apakah Anda yakin ingin mengeluarkan anggota ini dari kepanitiaan?')) {
                let form = document.getElementById('kickForm');
                form.action = url;
                form.submit();
            }
        }

        function triggerSearch() {
            const nim = document.getElementById('searchNim').value;
            findStudent(nim);
        }

        function findStudent(nim) {
            if(!nim) return;

            const resultDiv = document.getElementById('studentResult');
            const errorDiv = document.getElementById('studentError');
            const nameInput = document.getElementById('studentName');
            const idInput = document.getElementById('studentIdHidden');
            const btnInvite = document.getElementById('btnInvite');

            // Reset UI
            resultDiv.classList.add('d-none');
            errorDiv.classList.add('d-none');
            btnInvite.disabled = true;

            // Fetch ke API Controller
            fetch(`{{ route('api.search-student') }}?q=${nim}`)
                .then(response => {
                    if (!response.ok) throw new Error('Not found');
                    return response.json();
                })
                .then(res => {
                    // Jika ketemu
                    resultDiv.classList.remove('d-none');
                    nameInput.value = res.data.full_name; // Sesuaikan dengan kolom DB
                    idInput.value = res.data.student_id;  // Sesuaikan dengan kolom DB
                    btnInvite.disabled = false;
                })
                .catch(error => {
                    // Jika tidak ketemu
                    errorDiv.classList.remove('d-none');
                    nameInput.value = '';
                    idInput.value = '';
                });
            }
    </script>
@endsection