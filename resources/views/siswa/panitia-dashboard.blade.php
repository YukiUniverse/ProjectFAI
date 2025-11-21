@extends('layouts.app')
@section('title', 'Dashboard Panitia')
@section('content')
    <style>
        /* Container to allow scrolling on small screens */
        .timeline-container {
            overflow-x: auto;
            padding-bottom: 10px;
        }

        .stepper-wrapper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            min-width: 500px;
            /* Ensures it doesn't squish on mobile */
        }

        .stepper-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }

        .stepper-item::before {
            position: absolute;
            content: "";
            border-bottom: 2px solid #ccc;
            /* Default gray line */
            width: 100%;
            top: 15px;
            left: -50%;
            z-index: 2;
        }

        .stepper-item::after {
            position: absolute;
            content: "";
            border-bottom: 2px solid #ccc;
            width: 100%;
            top: 15px;
            left: 50%;
            z-index: 2;
        }

        .stepper-item .step-counter {
            position: relative;
            z-index: 5;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #ccc;
            margin-bottom: 6px;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }

        .stepper-item.active .step-counter {
            background-color: #0d6efd;
            /* Bootstrap Primary Blue */
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
            /* Pulsing effect */
        }

        .stepper-item.completed .step-counter {
            background-color: #198754;
            /* Bootstrap Success Green */
        }

        .stepper-item.completed::after,
        .stepper-item.completed::before {
            border-bottom: 2px solid #198754;
            /* Green line for finished steps */
        }

        /* Remove line before first item and after last item */
        .stepper-item:first-child::before {
            content: none;
        }

        .stepper-item:last-child::after {
            content: none;
        }

        .step-name {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-align: center;
        }

        .stepper-item.active .step-name {
            color: #0d6efd;
        }

        .stepper-item.completed .step-name {
            color: #198754;
        }
    </style>

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
                $currentIndex = array_search($a->status, $statusKeys);
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
                    <a href="{{ route('siswa.panitia-jadwal') }}" class="btn btn-sm btn-outline-success">Lihat Jadwal</a>
                    <a href="{{ route('siswa.panitia-task') }}" class="btn btn-sm btn-outline-info">Lihat Tugas</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection