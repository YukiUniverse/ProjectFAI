@extends('layouts.app')

@section('title', 'Ajukan Proposal Acara')

@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <h3>Ajukan Proposal Acara Baru</h3>
            <p class="text-muted">Isi detail acara baru untuk diajukan ke admin dan BPH.</p>

            {{-- Tampilkan pesan sukses jika ada --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Form Action mengarah ke route 'proposals.store' --}}
            <form action="{{ route('siswa.proposal-store') }}" method="POST" class="card p-4 shadow-sm">
                @csrf
                
                {{-- Input: Judul Acara --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Acara</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                           placeholder="Contoh: Seminar Teknologi 2025" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input: Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Deskripsi Acara</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                              rows="3" placeholder="Jelaskan tujuan dan gambaran acara..." required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input: Organisasi (Select Box) --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Organisasi Penyelenggara</label>
                    <select class="form-select @error('student_organization_id') is-invalid @enderror" name="student_organization_id" required>
                        <option value="" selected disabled>-- Pilih Organisasi --</option>
                        
                        @foreach($organizations as $org)
                            <option value="{{ $org->student_organization_id }}" {{ old('student_organization_id') == $org->student_organization_id ? 'selected' : '' }}>
                                {{ $org->organization_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('student_organization_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                
                {{-- Input: Waktu Pelaksanaan (Wajib ada karena Schema DB membutuhkannya) --}}
                <h6 class="text-primary mb-3">Waktu Pelaksanaan</h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mulai</label>
                        <input type="datetime-local" name="start_datetime" class="form-control @error('start_datetime') is-invalid @enderror" value="{{ old('start_datetime') }}" required>
                        @error('start_datetime')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Selesai</label>
                        <input type="datetime-local" name="end_datetime" class="form-control @error('end_datetime') is-invalid @enderror" value="{{ old('end_datetime') }}" required>
                        @error('end_datetime')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-send me-2"></i> Kirim Proposal
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection