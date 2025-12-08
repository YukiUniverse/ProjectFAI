@extends('layouts.app')
@section('title', 'Dashboard Panitia')
@section('content')
    <div>
        <h3>Dashboard Panitia</h3>
        <p class="text-muted">Lihat detail acara dan kegiatan aktif.</p>

        @foreach ($acara as $a)
            @php
                // Define the order of status (Key = DB value, Value = Display Label)
                $steps = [
                    'preparation' => 'Preparation',
                    'open_recruitment' => 'Open Rec',
                    'interview' => 'Interview',
                    'active' => 'Active',
                    'grading' => 'Grading',
                    'finished' => 'Finished'
                ];

                // Find the numeric index of the current status (0 to 5)
                // array_keys gets just the keys, array_search finds where the current status is in that list
                $statusKeys = array_keys($steps);
                // 1. Create a temporary variable for the search
                $searchStatus = $a->status;

                // 2. Check for your specific variations and map them to the main key
                if ($searchStatus == 'grading_1' || $searchStatus == 'grading_2') {
                    $searchStatus = 'grading';
                }

                // 3. Find the index using the normalized $searchStatus instead of $a->status
                $currentIndex = array_search($searchStatus, $statusKeys);
            @endphp
            <div class="card shadow-sm p-3 mb-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="fw-bold">{{ $a->activity_name }}</h5>
                        <p class="text-muted mb-3">{{ $a->activity_description }}</p>
                    </div>
                    {{-- Optional: Badge for current status text --}}
                    <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $a->status)) }}</span>
                </div>

                <div class="timeline-container mt-2">
                    <div class="stepper-wrapper">
                        @foreach($steps as $key => $label)
                            @php
                                // Determine class based on index
                                $loopIndex = array_search($key, $statusKeys);
                                $statusClass = '';

                                if ($loopIndex < $currentIndex) {
                                    $statusClass = 'completed'; // Past steps (Green)
                                } elseif ($loopIndex == $currentIndex) {
                                    $statusClass = 'active';    // Current step (Blue)
                                }
                            @endphp

                            <div class="stepper-item {{ $statusClass }}">
                                <div class="step-counter">
                                    @if($loopIndex < $currentIndex)
                                        ✓ {{-- Checkmark for completed --}}
                                    @else
                                        {{ $loopIndex + 1 }} {{-- Number for future --}}
                                    @endif
                                </div>
                                <div class="step-name">{{ $label }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('siswa.panitia-detail', $a->activity_code) }}"
                        class="btn btn-sm btn-outline-primary">Detail Acara</a>
                    @if($a->status == "interview")
                        <a href="{{ route('siswa.panitia-pendaftar', $a->activity_code) }}"
                            class="btn btn-sm btn-outline-success">List Pendaftar</a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection