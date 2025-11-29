@extends('layouts.app')
@section('title', 'BPH - Pengurus Inti')
@section('content')

    {{-- CSS Kustom --}}
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
        .stepper-item.completed .step-counter {
            background-color: #198754;
            border-color: #198754;
            color: white;
        }
        .stepper-item.completed .step-name {
            color: #198754;
            font-weight: 600;
        }
        .stepper-item.active .step-counter {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
            transform: scale(1.1);
        }
        .stepper-item.active .step-name {
            color: #0d6efd;
            font-weight: bold;
        }
    </style>

    {{-- Header & Navigasi --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold text-primary m-0">🧭 Fitur Pengurus Inti</h5>
            <small class="text-muted">Kelola kegiatan, struktur, dan penilaian panitia.</small>
        </div>
        <a href="{{ route('siswa.panitia-detail', $activity->activity_code) }}" class="btn btn-outline-danger btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- NAVIGATION TABS (HANYA 3 TAB) --}}
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#timeline">Timeline</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#divisi">Divisi</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#struktur">Struktur</button></li>
    </ul>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
            <strong>Perhatikan:</strong>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- KONTEN TAB --}}
    <div class="tab-content">

        {{-- TAB 1: TIMELINE --}}
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
                $currentStatusIndex = array_search($activity->status, $statusKeys);
            @endphp

            <div class="timeline-container mt-3">
                <div class="stepper-wrapper">
                    @foreach($steps as $key => $data)
                        @php 
                            $loopIndex = $loop->index; 
                            $statusClass = '';

                            if ($currentStatusIndex !== false) {
                                if ($loopIndex < $currentStatusIndex) {
                                    $statusClass = 'completed';
                                } elseif ($loopIndex == $currentStatusIndex) {
                                    $statusClass = 'active';
                                }
                            }
                        @endphp

                        <div class="stepper-item {{ $statusClass }}" 
                             onclick="updateDescription(this, '{{ addslashes($data['desc']) }}')" 
                             style="cursor: pointer;">
                            <div class="step-counter">
                                @if($statusClass == 'completed') ✔ @else {{ $loopIndex + 1 }} @endif
                            </div>
                            <div class="step-name">{{ $data['label'] }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="description-box mt-4 p-3 border rounded bg-light">
                    <strong>Description:</strong>
                    <p class="m-0" id="desc-text">
                        {{ $steps[$activity->status]['desc'] ?? 'Click on a step to see details.' }}
                    </p>
                </div>
            </div>

            {{-- Form Update Status --}}
            <form action="{{ route('siswa.panitia-update-status', $activity->activity_code) }}" class="row g-2 mb-3 mt-3" method="POST">
                @csrf
                <select class="form-select col-md-3" name="status">
                    @foreach($steps as $key => $val)
                        <option value="{{ $key }}" {{ $activity->status == $key ? 'selected' : '' }}>
                            {{ $val['label'] }}
                        </option>
                    @endforeach
                </select>
                <button class="btn btn-primary col-md-2" type="submit">Update Timeline</button>
            </form>
        </div>

        {{-- TAB 2: MANAJEMEN DIVISI (SUB ROLE) --}}
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
                                                {{-- Tombol Edit dengan Modal di dalam Loop --}}
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

                                                {{-- MODAL EDIT --}}
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
                                                                        <input type="text" name="sub_role_code" class="form-control" value="{{ $div->sub_role_code }}" required maxlength="10">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">Nama Divisi (ID)</label>
                                                                        <input type="text" name="sub_role_name" class="form-control" value="{{ $div->sub_role_name }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">Nama Divisi (EN)</label>
                                                                        <input type="text" name="sub_role_name_en" class="form-control" value="{{ $div->sub_role_name_en }}">
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
                                <button type="submit" class="btn btn-success fw-bold">Simpan Divisi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- TAB 3: STRUKTUR (UTAMA) --}}
        <div class="tab-pane fade" id="struktur">
            <div class="card shadow-sm p-4">
                
                {{-- HEADER STRUKTUR --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-success m-0">🏗️ Atur Struktur BPH & Koordinator Divisi</h6>
                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#inviteModal">
                        <i class="bi bi-person-plus-fill"></i> + Invite Member
                    </button>
                </div>

                {{-- FORM UPDATE MASSAL --}}
                <form action="{{ route('siswa.panitia-update-struktur', $activity->activity_code) }}" method="POST">
                    @csrf
                    
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Nama</th>
                                    <th style="width: 35%">Divisi (Sub Role)</th>
                                    <th style="width: 30%">Jabatan (Role)</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($panitiaList as $p)
                                    @php 
                                        $currentRoleName = $p->role?->role_name; 
                                        $isKetua = ($currentRoleName === 'Ketua'); 
                                    @endphp

                                    <tr>
                                        <td>
                                            <strong>{{ $p->student->full_name }}</strong>
                                        </td>
                                        
                                        {{-- KOLOM DIVISI --}}
                                        <td>
                                            @if($isKetua)
                                                <div class="text-center text-muted small fst-italic">
                                                    - Pengurus Inti -
                                                    <input type="hidden" name="updates[{{ $p->activity_structure_id }}][sub_role_id]" value="">
                                                </div>
                                            @else
                                                <select class="form-select form-select-sm border-secondary" name="updates[{{ $p->activity_structure_id }}][sub_role_id]">
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
                                        
                                        {{-- KOLOM JABATAN --}}
                                        <td>
                                            @if($isKetua)
                                                <div class="text-center text-primary fw-bold small">
                                                    <i class="bi bi-star-fill me-1"></i> Ketua Panitia
                                                    <input type="hidden" name="updates[{{ $p->activity_structure_id }}][role_id]" value="{{ $p->student_role_id }}">
                                                </div>
                                            @else
                                                <select class="form-select form-select-sm border-secondary" name="updates[{{ $p->activity_structure_id }}][role_id]">
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
                                                <span class="text-muted small"><i class="bi bi-shield-lock"></i></span>
                                            @else
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmKick('{{ route('siswa.panitia-kick', $p->activity_structure_id) }}')"
                                                    title="Keluarkan Anggota">
                                                    <i class="bi bi-person-x"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            Belum ada anggota panitia. Silakan invite member baru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success px-4 fw-bold shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan Struktur
                        </button>
                    </div>
                </form>

                {{-- FORM HIDDEN UNTUK PROSES KICK (Wajib ada untuk JS confirmKick) --}}
                <form id="kickForm" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>

            </div>
        </div>

    </div> {{-- END TAB CONTENT --}}

    {{-- MODAL INVITE MEMBER --}}
    <div class="modal fade" id="inviteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('siswa.panitia-invite', $activity->activity_code) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="bi bi-envelope-plus me-2"></i>Undang Anggota Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="mb-3">
                            <label for="searchNim" class="form-label fw-bold">Cari Mahasiswa (NIM)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchNim" placeholder="Masukkan NIM..." onchange="findStudent(this.value)">
                                <button class="btn btn-outline-secondary" type="button" onclick="triggerSearch()">
                                    <i class="bi bi-search"></i> Cari
                                </button>
                            </div>
                            <small class="text-muted">Tekan Enter atau klik Cari setelah mengetik NIM.</small>
                        </div>

                        <div id="studentResult" class="d-none bg-light p-3 rounded border">
                            <div class="d-flex align-items-center mb-2 text-success">
                                <i class="bi bi-check-circle-fill me-2"></i> <strong>Mahasiswa Ditemukan!</strong>
                            </div>
                            <div class="mb-2">
                                <label class="form-label small text-muted">Nama Lengkap</label>
                                <input type="text" class="form-control" id="studentName" readonly>
                            </div>
                            <input type="hidden" name="student_id" id="studentIdHidden">
                        </div>

                        <div id="studentError" class="alert alert-danger py-2 d-none mt-2">
                            <i class="bi bi-x-circle me-1"></i> Mahasiswa tidak ditemukan.
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success" id="btnInvite" disabled>
                            <i class="bi bi-send me-1"></i> Kirim Undangan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT --}}
    <script>
        // Update deskripsi timeline
        function updateDescription(element, text) {
            document.getElementById('desc-text').innerText = text;
            document.querySelectorAll('.stepper-item').forEach(el => el.classList.remove('step-selected'));
            element.classList.add('step-selected');
        }

        // Trigger Pencarian Mahasiswa
        function triggerSearch() {
            const nim = document.getElementById('searchNim').value;
            findStudent(nim);
        }

        // Logic AJAX Cari Mahasiswa
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

            // Fetch ke API
            fetch(`{{ route('api.search-student') }}?q=${nim}`)
                .then(response => {
                    if (!response.ok) throw new Error('Not found');
                    return response.json();
                })
                .then(res => {
                    resultDiv.classList.remove('d-none');
                    nameInput.value = res.data.full_name;
                    idInput.value = res.data.student_id;
                    btnInvite.disabled = false;
                })
                .catch(error => {
                    errorDiv.classList.remove('d-none');
                    nameInput.value = '';
                    idInput.value = '';
                });
        }

        // Logic Konfirmasi Kick Member
        function confirmKick(url) {
            if (confirm('⚠️ PERINGATAN: Apakah Anda yakin ingin mengeluarkan anggota ini dari kepanitiaan?')) {
                let form = document.getElementById('kickForm');
                form.action = url;
                form.submit();
            }
        }
    </script>
@endsection