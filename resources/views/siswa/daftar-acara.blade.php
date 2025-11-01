@extends('layouts.app')
@section('title', 'Daftar Acara')
@section('content')
    <h3>Daftar Acara Kampus</h3>
    <p class="text-muted">Berikut daftar acara kampus yang sedang membuka pendaftaran panitia.</p>

    <div class="row">
        @foreach($acara as $a)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5>{{ $a->nama }}</h5>
                        <p>{{ $a->deskripsi }}</p>
                        <a href="{{ route('siswa.form-pendaftaran') }}" class="btn btn-primary w-100">Daftar Panitia</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


@endsection