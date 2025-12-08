@extends('layouts.app')
@section('title', 'Dashboard Panitia')
@section('content')
    <div>
        <h3>Acara Siap Interview</h3>
        <p class="text-muted">Quick Access untuk Interview</p>

        @foreach ($acara as $a)
            <a href="{{ route('siswa.panitia-pendaftar', $a->activity_code) }}" class="text-decoration-none text-reset">
                <div class="card shadow-sm p-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="fw-bold">{{ $a->activity_name }}</h5>
                            <p class="text-muted mb-3">{{ $a->activity_description }}</p>
                        </div>
                        {{-- Optional: Badge for current status text --}}
                        <span class="badge bg-primary">{{ ucfirst(str_replace('_', ' ', $a->status)) }}</span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection