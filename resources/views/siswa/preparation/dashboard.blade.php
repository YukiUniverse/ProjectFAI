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

        <div class="tab-pane fade show active" id="timeline">
            
        </div>

        {{-- TAB 4: STRUKTUR --}}
        <div class="tab-pane fade" id="struktur">
            <div class="card shadow-sm p-4">
                <h6 class="fw-bold text-success mt-4">🏗️ Atur Struktur BPH & Koordinator Divisi</h6>
                
                {{-- FORM START --}}
                <form action="{{ route('siswa.panitia-update-struktur', $activity->activity_code) }}" method="POST">
                    @csrf
                    
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>Nama</th>
                                    <th>Divisi</th>
                                    <th>Jabatan Sekarang</th>
                                    <th style="width: 30%">Ubah Jabatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($panitiaList as $p)
                                    <tr>
                                        <td>
                                            <strong>{{ $p->student->full_name }}</strong>
                                        </td>
                                        <td class="text-center">
                                            {{ $p->subRole->sub_role_name_en ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info text-dark">{{ $p->role->role_name }}</span>
                                        </td>
                                        <td>
                                            {{-- SELECT BOX --}}
                                            {{-- Name array: updates[ID_STRUCTURE] = NEW_ROLE_ID --}}
                                            <select class="form-select" name="updates[{{ $p->activity_structure_id }}]">
                                                @foreach($roles as $r)
                                                    <option value="{{ $r->student_role_id }}" 
                                                        {{ $p->student_role_id == $r->student_role_id ? 'selected' : '' }}>
                                                        {{ $r->role_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">
                            💾 Simpan Perubahan Struktur
                        </button>
                    </div>
                </form>
                {{-- FORM END --}}
                
            </div>
        </div>

        

    </div> {{-- END TAB CONTENT --}}

    <script>
        function updateDescription(element, text) {
            document.getElementById('desc-text').innerText = text;
            document.querySelectorAll('.stepper-item').forEach(el => el.classList.remove('step-selected'));
            element.classList.add('step-selected');
        }
    </script>
@endsection