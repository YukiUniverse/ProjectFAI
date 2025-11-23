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

                        <h5 class="mb-3 fw-bold text-primary"><i class="bi bi-clock-history me-2"></i>Riwayat Organisasi
                            (Top 5)</h5>
                        <div class="card border-0 bg-light mb-5">
                            <div class="card-body p-0">
                                <div class="list-group list-group-flush rounded-3">

                                    @forelse($histories as $history)
                                        <div class="list-group-item bg-transparent border-bottom p-3">
                                            <div class="d-flex justify-content-between align-items-start">

                                                {{-- Left Side: Role & Activity --}}
                                                <div>
                                                    <div class="mb-1">
                                                        <span class="badge bg-dark me-2">
                                                            {{ $history->role->role_name ?? 'Anggota' }}
                                                        </span>
                                                        @if($history->subRole)
                                                            <span class="badge bg-secondary text-light">
                                                                {{ $history->subRole->sub_role_name }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <h6 class="fw-bold text-dark mb-0">
                                                        {{ $history->activity->activity_name ?? 'Nama Kegiatan' }}
                                                    </h6>
                                                    @if($history->kpi_score > 0)
                                                        <span class="text-warning fs-5">
                                                            @php $roundedScore = round($history->kpi_score); @endphp
                                                            @for($i = 1; $i <= 4; $i++)
                                                                {{ $i <= $roundedScore ? '★' : '☆' }}
                                                            @endfor
                                                        </span>
                                                        <strong class="text-dark">{{ $history->kpi_score }}</strong>
                                                    @else
                                                        <span class="text-muted small fst-italic">Belum Dinilai</span>
                                                    @endif
                                                </div>

                                                {{-- Right Side: Year / Date --}}
                                                <div class="text-end">
                                                    <small class="text-muted fw-bold">
                                                        {{ \Carbon\Carbon::parse($history->activity->start_datetime)->format('Y') }}
                                                    </small>
                                                    <br>
                                                    <small class="text-muted" style="font-size: 0.75rem;">
                                                        {{ \Carbon\Carbon::parse($history->activity->start_datetime)->format('d M') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-4 text-center text-muted">
                                            <i class="bi bi-clipboard-x display-6 mb-2 d-block opacity-50"></i>
                                            <span>Belum ada riwayat organisasi yang selesai.</span>
                                        </div>
                                    @endforelse

                                </div>
                            </div>
                        </div>

                        {{-- SECTION 1: INTERVIEWER RECOMMENDATION (Revised) --}}
                        <div class="card shadow-sm border-0 mb-5">
                            <div class="card-header bg-white p-4">
                                <h5 class="mb-0 fw-bold text-secondary"><i class="bi bi-person-check me-2"></i>Rekomendasi
                                    Interviewer</h5>
                            </div>
                            <div class="card-body p-4 bg-light">
                                <form
                                    action="{{ route('siswa.store-decision', [$activity->activity_code, $currentStudent->id]) }}"
                                    method="POST">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Rekomendasi Anda</label>
                                            <select name="verdict" class="form-select">
                                                <option value="" selected disabled>-- Pilih --</option>
                                                <option value="accept" class="text-success fw-bold">Disarankan Terima
                                                </option>
                                                <option value="reject" class="text-danger fw-bold">Disarankan Tolak
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label fw-semibold">Alasan / Catatan</label>
                                            <textarea name="reason" class="form-control" rows="1"
                                                placeholder="Tulis alasan singkat..." required></textarea>
                                        </div>
                                        <div class="col-12 text-end mt-3">
                                            <button type="submit" class="btn btn-secondary">
                                                <i class="bi bi-send me-1"></i> Kirim Rekomendasi
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- SECTION 2: LEADER'S FINAL DECISION (New) --}}
                        <div class="card shadow border-0 rounded-4 overflow-hidden mb-5">
                            <div class="card-header bg-dark text-white p-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-gavel fs-3 me-3"></i>
                                    <div>
                                        <h4 class="mb-0 fw-bold">Keputusan Final (Leader)</h4>
                                        <small class="text-white-50">Review rekomendasi anggota dan putuskan.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body p-4">

                                {{-- A. List of Recommendations --}}
                                <h6 class="fw-bold text-uppercase text-muted small mb-3">Daftar Masukan Interviewer</h6>
                                <div class="list-group mb-4">
                                    @forelse($previousDecisions as $decision)
                                        <div
                                            class="list-group-item d-flex justify-content-between align-items-start p-3 bg-light border-0 mb-2 rounded">
                                            <div class="form-check pt-1">
                                                {{-- The Checkbox --}}
                                                <input class="form-check-input reason-checkbox" type="checkbox"
                                                    value="{{ $decision->reason }}" id="reasonCheck{{ $loop->index }}">
                                                <label class="form-check-label ms-2" for="reasonCheck{{ $loop->index }}">
                                                    <strong>{{ $decision->judge->full_name ?? 'Interviewer' }}</strong>
                                                    <span
                                                        class="badge {{ $decision->verdict == 'accept' ? 'bg-success' : 'bg-danger' }} ms-2">
                                                        {{ strtoupper($decision->verdict) }}
                                                    </span>
                                                    <p class="mb-0 text-muted mt-1 fst-italic">"{{ $decision->reason }}"</p>
                                                </label>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="alert alert-info small">Belum ada rekomendasi dari interviewer lain.</div>
                                    @endforelse
                                </div>

                                <hr class="my-4">

                                {{-- B. Final Decision Form --}}
                                <form
                                    action="{{ route('siswa.store-decision-akhir', [$activity->activity_code, $currentStudent->id]) }}"
                                    method="POST">
                                    @csrf

                                    <div class="row g-4">
                                        {{-- 1. Final Status --}}
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Status Final</label>
                                            <select name="final_status" id="finalStatusSelect"
                                                class="form-select form-select-lg" required>
                                                <option value="" disabled selected>-- Putuskan --</option>
                                                <option value="accepted" class="text-success fw-bold">✅ DITERIMA</option>
                                                <option value="rejected" class="text-danger fw-bold">🚫 DITOLAK</option>
                                            </select>
                                        </div>

                                        {{-- 2. Final Division (All Divisions) --}}
                                        <div class="col-md-8 d-none" id="finalDivisionContainer">
                                            <label class="form-label fw-bold text-success">Tempatkan di Divisi
                                                (Final)</label>
                                            <select name="final_division_id" class="form-select form-select-lg">
                                                <option value="" disabled selected>Pilih Divisi...</option>
                                                @foreach($allDivisions as $div)
                                                    <option value="{{ $div->sub_role_id }}" {{-- Highlight if it was student's
                                                        choice --}}
                                                        @if($div->sub_role_id == $currentStudent->choice_1_sub_role_id)
                                                        class="fw-bold bg-light" @endif>
                                                        {{ $div->sub_role_name }}
                                                        @if($div->sub_role_id == $currentStudent->choice_1_sub_role_id) (Pilihan
                                                            1)
                                                        @endif
                                                        @if($div->sub_role_id == $currentStudent->choice_2_sub_role_id) (Pilihan
                                                            2)
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- 3. Final Reason (Auto-filled) --}}
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Alasan Final (Summary)</label>
                                            <textarea name="final_reason" id="finalReasonArea" class="form-control" rows="4"
                                                placeholder="Klik checkbox di atas atau ketik manual..."></textarea>
                                            <div class="form-text">Centang masukan di atas untuk menggabungkan alasan secara
                                                otomatis.</div>
                                        </div>

                                        {{-- 4. Submit --}}
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-dark w-100 py-3 fw-bold">
                                                <i class="bi bi-check-circle-fill me-2"></i> SIMPAN KEPUTUSAN FINAL
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
    </div>

    {{-- JavaScript for Show/Hide Logic --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // --- PART 1: SHOW/HIDE DIVISION DROPDOWN ---
            const finalStatus = document.getElementById('finalStatusSelect');
            const finalDivContainer = document.getElementById('finalDivisionContainer');
            const finalDivInput = finalDivContainer.querySelector('select');

            finalStatus.addEventListener('change', function () {
                if (this.value === 'accepted') {
                    finalDivContainer.classList.remove('d-none');
                    finalDivInput.setAttribute('required', 'required');
                } else {
                    finalDivContainer.classList.add('d-none');
                    finalDivInput.removeAttribute('required');
                    finalDivInput.value = "";
                }
            });

            // --- PART 2: CHECKBOX REASON COMPILER ---
            const checkboxes = document.querySelectorAll('.reason-checkbox');
            const textArea = document.getElementById('finalReasonArea');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateFinalReason);
            });

            function updateFinalReason() {
                // 1. Get existing manual text (Optional: simplistic approach clears and rebuilds)
                // Ideally, we just want to collect checked boxes

                let compiledReasons = [];

                // 2. Loop through all checked boxes
                checkboxes.forEach(box => {
                    if (box.checked) {
                        compiledReasons.push("- " + box.value);
                    }
                });

                // 3. Update Text Area
                // Note: This replaces current text. 
                // If you want to append without deleting manual text, logic needs to be much more complex.
                // For now, this is the standard "Generate Reason" behavior.
                if (compiledReasons.length > 0) {
                    textArea.value = "Kesimpulan dari tim:\n" + compiledReasons.join("\n");
                } else {
                    textArea.value = ""; // Clear if nothing checked
                }
            }
        });
    </script>
@endsection