@extends('layouts.app')
@section('title', 'BPH')
@section('content')
    <style>
        .description-box {
            background-color: #f8f9fa;
            /* Light gray */
            border-left: 5px solid #0d6efd;
            /* Blue accent on the left */
            transition: all 0.3s ease;
        }

        /* Optional: Specific style for the item currently being clicked/viewed */
        .stepper-item.step-selected .step-counter {
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.3);
            /* Glow effect */
            transform: scale(1.1);
        }
    </style>
    <a href="{{ route('siswa.panitia-detail', $activity->activity_code) }}" class="btn btn-danger">Back</a>
    <h5 class="fw-bold text-primary mb-3">🧭 Fitur Pengurus Inti</h5>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#timeline">
                Timeline</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pertanyaan">
                Pertanyaan</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#pendaftar">
                Pendaftar</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#struktur">Struktur</button>
        </li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#jadwal">Jadwal</button></li>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade" id="pendaftar">
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
                                <th>Jabatan</th>
                                <th>Divisi</th>

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

                            @foreach($dataPanitia as $p)
                                <tr>
                                    <td>{{ $p->student->full_name }}</td>
                                    <td>{{ $p->role->role_name }}</td>
                                    <td>{{ $p->subRole->sub_role_name_en }}</td>
                                    <!-- <td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <select class="form-select">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <option selected>- Pilih Jabatan -</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        @foreach($jabatan as $j)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <option>{{ $j }}</option>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        @endforeach
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </select>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </td> -->
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

        <!-- Master Pertanyaan -->
        <div class="tab-pane fade" id="pertanyaan">
            @foreach ($listPertanyaanUntukDivisi as $d)
                <div class="card shadow-sm p-4">
                    <h6 class="fw-bold text-secondary mt-3">Pertanyaan untuk divisi {{ $d->sub_role_name }}</h6>
                    <ol>
                        @forelse($d->activityQuestions as $question)
                            <li>{{ $question->question }}</li>
                        @empty
                            <div class="alert alert-secondary">
                                No questions available for this division.
                            </div>
                        @endforelse
                    </ol>
                    <form class="row g-2 mb-3" method="post" action="">
                        @csrf
                        <div class="col-md-5"><input type="text" name="question" class="form-control"
                                placeholder="Tambah Pertanyaan"></div>
                        <div class="col-md-3"><button class="btn btn-outline-primary w-100">Tambah Pertanyaan</button></div>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Master Timeline -->
        <div class="tab-pane fade show active" id="timeline">
            @php
                // 1. Define Key => [Label, Description]
                $steps = [
                    'preparation' => [
                        'label' => 'Preparation',
                        'desc' => 'Setting up the committee structure, defining roles, and preparing the timeline.'
                    ],
                    'open_recruitment' => [
                        'label' => 'Open Rec',
                        'desc' => 'Publishing registration forms and gathering applicant data.'
                    ],
                    'interview' => [
                        'label' => 'Interview',
                        'desc' => 'Conducting interviews to assess candidate skills and commitment.'
                    ],
                    'active' => [
                        'label' => 'Active',
                        'desc' => 'Committee is fully formed and currently executing work programs.'
                    ],
                    'grading_1' => [
                        'label' => 'Start Grading',
                        'desc' => 'Evaluating the performance of the committee members.'
                    ],
                    'grading_2' => [
                        'label' => 'Final Grading',
                        'desc' => 'Final evaluation by leader, reviewing the grades.'
                    ],
                    'finished' => [
                        'label' => 'Finished',
                        'desc' => 'Project is complete and the committee is disbanded.'
                    ]
                ];

                $statusKeys = array_keys($steps);

                // Example: Hardcoded current status for logic demo
                $currentStatusKey = 'interview'; 
            @endphp
            <div class="timeline-container mt-3">
                <div class="stepper-wrapper">
                    @foreach($steps as $key => $data)
                        @php
                            $loopIndex = array_search($key, $statusKeys);
                            $statusClass = 'active'; // Your logic here
                        @endphp

                        <div class="stepper-item {{ $statusClass }}"
                            onclick="updateDescription(this, '{{ addslashes($data['desc']) }}')" style="cursor: pointer;">

                            <div class="step-counter">
                                {{ $loopIndex + 1 }}
                            </div>
                            <div class="step-name">{{ $data['label'] }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="description-box mt-4 p-3 border rounded bg-light">
                    <strong>Description:</strong>
                    <p class="m-0" id="desc-text">Click on a step to see details.</p>
                </div>
            </div>
            <form action="" class="row g-2 mb-3" method="post">
                @csrf
                <select class="form-select col-md-3" name="status" id="">
                    <option value="preparation">Preparation</option>
                    <option value="open_recruitment">Open Recruitment</option>
                    <option value="interview">Interview</option>
                    <option value="active">Active</option>
                    <option value="grading_1">Start Grading</option>
                    <option value="grading_2">Final Grading</option>
                    <option value="finished">Finish</option>
                </select>
                <button class="btn btn-active col-md-2" type="submit">Update Timeline</button>
            </form>
        </div>
    </div>
    </div>
    </div>
    <script>
        function updateDescription(element, text) {
            // 1. Update the text
            document.getElementById('desc-text').innerText = text;

            // 2. Optional: Highlight the clicked item visually
            // Remove 'step-selected' from all items
            document.querySelectorAll('.stepper-item').forEach(el => {
                el.classList.remove('step-selected')
            });
            // Add it to the clicked one
            element.classList.add('step-selected');
        }
    </script>
@endsection