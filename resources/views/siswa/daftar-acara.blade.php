@extends('layouts.app')
@section('title', 'Daftar Acara')
@section('content')
    <h3>Daftar Acara Kampus</h3>
    <p class="text-muted">Berikut daftar acara kampus yang sedang membuka pendaftaran panitia.</p>

    <div class="row">
        @forelse($acara as $a)
            <div class="col-md-5 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>{{ $a->activity_name }}</h5>
                        <p>{{ $a->activity_description }}</p>
                        @if($a->interview_date)
                            {{-- Badge Tanggal & Jam --}}
                            <span class="badge bg-light text-dark border mb-1">
                                <i class="far fa-clock text-primary me-1"></i>
                                Interview Date: {{ \Carbon\Carbon::parse($a->interview_date)->translatedFormat('l, d/m/Y - H:i') }}
                                WIB
                            </span>

                            {{-- Badge Lokasi (Hanya muncul jika ada) --}}
                            @if($a->interview_location)
                                <br> {{-- Baris baru agar rapi ke bawah --}}
                                <span class="badge bg-light text-dark border mb-2">
                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                    Ruangan: {{ $a->interview_location }}
                                </span>
                            @endif
                        @else
                            <span class="badge bg-secondary mb-2">Belum ada Jadwal Interview</span>
                        @endif

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