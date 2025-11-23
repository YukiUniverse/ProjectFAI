@extends('layouts.app')

@section('title', 'Interview Session')

@section('content')
    <div class="container my-5">
        <a href="{{ route('siswa.detail-pendaftar', [$activityCode, $registration->id]) }}" class="btn btn-primary">Back</a>
        {{-- Header Info --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-light border-0 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1">Interview Session</h2>
                            <p class="text-muted mb-0">
                                Candidate: <strong>{{ $registration->student->full_name }}</strong>
                                (NRP: {{ $registration->student->student_number }})
                            </p>
                        </div>
                        <div>
                            <span class="badge bg-primary fs-6">{{ $activityCode }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form
            action="{{ route('siswa.storeInterview', ['activityCode' => $activityCode, 'registrationId' => $registrationId]) }}"
            method="POST">
            @csrf

            @foreach($listPertanyaanUntukDivisi as $divisi)
                <div class="card shadow-sm mb-5 border-0">
                    <div class="card-header bg-dark text-white py-3">
                        <h4 class="mb-0"><i class="bi bi-briefcase me-2"></i>{{ $divisi->sub_role_name }}</h4>
                    </div>

                    <div class="card-body">
                        @forelse($divisi->activityQuestions as $index => $question)
                            @php
                                // Helper to get current data safely
                                $current = $existingData[$question->id] ?? null;
                            @endphp

                            <div class="mb-4 pb-4 border-bottom">
                                <label class="form-label fw-bold text-dark mb-2">
                                    Q{{ $index + 1 }}: {{ $question->question }}
                                </label>

                                <div class="row g-3">
                                    {{-- Left Column: Candidate Answer --}}
                                    <div class="col-md-8">
                                        <label class="small text-muted mb-1">Candidate Answer</label>
                                        <textarea name="answers[{{ $question->id }}]" class="form-control" rows="4"
                                            placeholder="Record what the candidate says...">{{ $current->answer_text ?? '' }}</textarea>
                                    </div>

                                    {{-- Right Column: Interviewer Note --}}
                                    <div class="col-md-4">
                                        <label class="small text-muted mb-1">Interviewer Note (Private)</label>
                                        <div class="bg-warning bg-opacity-10 p-2 rounded h-100">
                                            <textarea name="notes[{{ $question->id }}]" class="form-control border-warning"
                                                style="background-color: #fffdf0;" rows="4"
                                                placeholder="Observations, scores, or impressions...">{{ $current->interviewer_note ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-secondary">
                                No questions configured for this division.
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach

            {{-- Floating Save Button --}}
            <div class="fixed-bottom bg-white border-top p-3 shadow-lg" style="z-index: 1050;">
                <div class="container d-flex justify-content-between align-items-center">
                    <span class="text-muted small">
                        <i class="bi bi-info-circle me-1"></i>
                        Notes are private to interviewers.
                    </span>
                    <button type="submit" class="btn btn-success btn-lg px-5 fw-bold">
                        <i class="bi bi-save me-2"></i> Save All Progress
                    </button>
                </div>
            </div>

            <div style="height: 100px;"></div>
        </form>
    </div>
@endsection