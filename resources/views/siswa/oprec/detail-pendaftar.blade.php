@extends('layouts.app')
@section('title', 'Profile ' . $currentStudent->student->full_name)

@section('content')
    <div class="container my-5">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <a href="{{ route('siswa.panitia-pendaftar', $activity->activity_code) }}"
                    class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-2"></i> Kembali
                </a>
                <a class="btn btn-primary rounded-pill px-4"
                    href="{{ route('siswa.showInterview', [$activity->activity_code, $currentStudent->id]) }}">
                    <i class="bi bi-journal-text me-2"></i> Lihat Jawaban Pertanyaan
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0 rounded-4 overflow-hidden">

                    <div class="card-header bg-white p-4 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="me-4">
                                <img src="https://avatar.iran.liara.run/public/1" class="rounded-circle shadow-sm"
                                    width="80" height="80" alt="Foto Profil" style="object-fit: cover;">
                            </div>
                            <div>
                                <h3 class="fw-bold text-dark mb-1">{{ $currentStudent->student->full_name }}</h3>
                                <span class="badge bg-light text-secondary border">
                                    NRP: {{ $currentStudent->student->student_number }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">

                        <h5 class="mb-3 fw-bold text-primary"><i class="bi bi-grid me-2"></i>Divisi Pilihan</h5>
                        <div class="row g-3 mb-5">
                            <div class="col-md-6">
                                <div class="p-3 border rounded h-100 bg-light">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-primary">Pilihan 1</span>
                                    </div>
                                    <h6 class="fw-bold">{{ $currentStudent->firstChoice->sub_role_name }}</h6>
                                    <hr>
                                    <p class="small text-muted mb-0">
                                        "{{ $currentStudent->reason_1 }}"
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-3 border rounded h-100 bg-light">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge bg-secondary">Pilihan 2</span>
                                    </div>
                                    <h6 class="fw-bold">
                                        {{ $currentStudent->secondChoice ? $currentStudent->secondChoice->sub_role_name : "-" }}
                                    </h6>
                                    <hr>
                                    <p class="small text-muted mb-0">
                                        "{{ $currentStudent->reason_2 ?? 'Tidak memilih' }}"
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 border rounded-3 bg-opacity-10 bg-primary" style="background-color: #f8f9fa;">
                            <h5 class="mb-3 fw-bold"><i class="bi bi-gavel me-2"></i>Keputusan</h5>

                            <form action="" method="POST">
                                @csrf

                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Status Penerimaan</label>
                                        <select name="status" id="statusSelect" class="form-select form-select-lg">
                                            <option value="" selected disabled>-- Pilih Keputusan --</option>
                                            <option value="rejected" class="text-danger fw-bold">🚫 Tolak (Reject)</option>
                                            <option value="accepted" class="text-success fw-bold">✅ Terima (Accept)</option>
                                        </select>
                                    </div>

                                    <div class="col-12 d-none" id="divisionContainer">
                                        <label class="form-label fw-semibold text-success">
                                            Tempatkan di Divisi mana?
                                        </label>
                                        <select name="accepted_division_id" class="form-select">
                                            <option value="" disabled selected>Pilih Divisi Final...</option>

                                            <option value="{{ $currentStudent->firstChoice->id }}">
                                                (Pilihan 1) {{ $currentStudent->firstChoice->sub_role_name }}
                                            </option>

                                            @if($currentStudent->secondChoice)
                                                <option value="{{ $currentStudent->secondChoice->id }}">
                                                    (Pilihan 2) {{ $currentStudent->secondChoice->sub_role_name }}
                                                </option>
                                            @endif

                                        </select>
                                        <div class="form-text">
                                            Pilih divisi final untuk mahasiswa ini.
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button class="btn btn-dark w-100 py-2 fw-bold" type="submit">
                                            Simpan Keputusan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript for Show/Hide Logic --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('statusSelect');
            const divisionContainer = document.getElementById('divisionContainer');
            const divisionInput = divisionContainer.querySelector('select');

            statusSelect.addEventListener('change', function () {
                if (this.value === 'accepted') {
                    // Show the division input
                    divisionContainer.classList.remove('d-none');
                    // Make it required
                    divisionInput.setAttribute('required', 'required');
                } else {
                    // Hide the division input
                    divisionContainer.classList.add('d-none');
                    // Remove required (so form can submit if rejected)
                    divisionInput.removeAttribute('required');
                    // Optional: Reset value
                    divisionInput.value = "";
                }
            });
        });
    </script>
@endsection