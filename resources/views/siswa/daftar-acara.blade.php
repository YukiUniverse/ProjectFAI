@extends('layouts.app')
@section('title', 'Daftar Acara')
@section('content')
    <h3>Daftar Acara Kampus</h3>
    <p class="text-muted">Berikut daftar acara kampus yang sedang membuka pendaftaran panitia.</p>

    <div class="row">
        @forelse($acara as $a)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>{{ $a->activity_name }}</h5>
                        <p>{{ $a->activity_description }}</p>
                        <a href="{{ route('siswa.form-pendaftaran', $a->student_activity_id) }}"
                            class="btn btn-primary w-100">Daftar Panitia</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-4 mb-3">
                Belum ada acara yang tersedia
            </div>

        @endforelse
    </div>


@endsection