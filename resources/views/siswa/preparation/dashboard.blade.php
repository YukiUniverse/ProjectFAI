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
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#divisi">Divisi</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#struktur">Struktur</button></li>
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
                        <!-- <div class="stepper-item {{ $statusClass }}" 
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
                        </div> -->
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

        <div class="tab-pane fade show active" id="timeline">
            <div class="card shadow-sm border-0 rounded-4">
    <!-- Header -->
    <div class="card-header bg-white p-4 border-bottom">
        <h6 class="fw-bold text-success mb-0 d-flex align-items-center">
            <i class="bi bi-diagram-3-fill me-2 fs-5"></i> Tambah dan Edit Divisi
        </h6>
    </div>

    <div class="card-body p-4">
        
        <!-- Section 1: List of Existing Divisions -->
        <div class="mb-4">
            <h6 class="text-uppercase text-muted fw-bold small mb-3">
                <i class="bi bi-list-ul me-1"></i> Daftar Divisi
            </h6>
            
            @if($listDivisi->isEmpty())
                <div class="alert alert-light border border-dashed text-center text-muted rounded-3 py-3">
                    <small>Belum ada divisi yang dibuat.</small>
                </div>
            @else
                <div class="list-group list-group-flush rounded-3 border">
                    @foreach ($listDivisi as $d)
                        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-3 py-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 text-success rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <span class="fw-bold small">{{ $loop->iteration }}</span>
                                </div>
                                <div>
                                    <span class="fw-semibold text-dark">{{ $d->sub_role_name }}</span>
                                    @if($d->sub_role_name_en)
                                        <small class="text-muted ms-1 fst-italic">({{ $d->sub_role_name_en }})</small>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Edit Button (Optional: You can add JS logic later to populate the form) --}}
                            <button type="button" class="btn btn-sm btn-light text-secondary rounded-circle border-0" 
                                    onclick="editDivision('{{ $d->sub_role_id }}', '{{ $d->sub_role_name }}', '{{ $d->sub_role_name_en }}')">
                                <i class="bi bi-pencil-fill small"></i>
                            </button>
                            <a href="{{ route('siswa.panitia-hapus-divisi', [$activity->student_activity_id, $d->sub_role_id]) }}"></a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <hr class="my-4 text-muted opacity-25">

        <!-- Section 2: Form -->
        <div>
            <h6 class="text-uppercase text-muted fw-bold small mb-3">
                <i class="bi bi-plus-circle me-1"></i> Form Input
            </h6>

            <form action="{{ route('siswa.panitia-tambah-divisi', $activity->student_activity_id) }}" method="post">
                @csrf
                
                {{-- Hidden Input for ID (used for updates) --}}
                <input type="hidden" name="sub_role_id" id="input_sub_role_id" value="">

                <div class="row g-3">
                    {{-- Input Name (ID) --}}
                    <div class="col-md-6">
                        <label for="sub_role_name" class="form-label small text-muted fw-semibold">Nama Divisi (Indonesia)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-flag-fill text-danger"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 ps-0" 
                                   name="sub_role_name" id="input_sub_role_name" 
                                   placeholder="Contoh: Acara" required>
                        </div>
                    </div>

                    {{-- Input Name (EN) --}}
                    <div class="col-md-6">
                        <label for="sub_role_name_en" class="form-label small text-muted fw-semibold">Nama Divisi (English)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-flag-fill text-primary"></i></span>
                            <input type="text" class="form-control bg-light border-start-0 ps-0" 
                                   name="sub_role_name_en" id="input_sub_role_name_en" 
                                   placeholder="Example: Event">
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-12 mt-4 d-flex justify-content-end gap-2">
                        <button type="reset" class="btn btn-light text-muted px-3 fw-semibold" onclick="resetForm()">
                            Reset
                        </button>
                        <button type="submit" class="btn btn-success px-4 rounded-pill fw-bold shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

        </div>
        {{-- TAB 3: STRUKTUR --}}
        <div class="tab-pane fade" id="struktur">
            @include('siswa.preparation.partials.panitia-table')
        </div>
    </div> {{-- END TAB CONTENT --}}

    <script>
        function updateDescription(element, text) {
            document.getElementById('desc-text').innerText = text;
            document.querySelectorAll('.stepper-item').forEach(el => el.classList.remove('step-selected'));
            element.classList.add('step-selected');
        }
        function editDivision(id, name, nameEn) {
            document.getElementById('input_sub_role_id').value = id;
            document.getElementById('input_sub_role_name').value = name;
            document.getElementById('input_sub_role_name_en').value = nameEn;
            document.getElementById('input_sub_role_name').focus();
        }

        function resetForm() {
            document.getElementById('input_sub_role_id').value = '';
        }
    </script>
@endsection