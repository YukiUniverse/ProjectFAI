@extends('layouts.app')
@section('title', 'Ajukan Proposal Acara')
@section('content')

<h3>Ajukan Proposal Acara Baru</h3>
<p class="text-muted">Isi detail acara baru untuk diajukan ke admin dan BPH.</p>

{{-- Tambahkan method POST dan CSRF untuk keamanan form --}}
<form action=""  class="card p-4 shadow-sm">
    @csrf
    
    <div class="mb-3">
        <label class="form-label">Nama Acara</label>
        <input type="text" name="title" class="form-control" placeholder="Contoh: Seminar Teknologi 2025" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Deskripsi Acara</label>
        <textarea name="description" class="form-control" rows="3" placeholder="Jelaskan tujuan dan gambaran acara..." required></textarea>
    </div>

    {{-- BAGIAN YANG DIUBAH: SELECT BOX ORGANISASI --}}
    <div class="mb-3">
        <label class="form-label">Organisasi Penyelenggara</label>
        <select class="form-select" name="student_organization_id" required>
            <option value="" selected disabled>-- Pilih Organisasi --</option>
            
            @foreach($organizations as $org)
                <option value="{{ $org->student_organization_id }}">
                    {{ $org->organization_name }}
                </option>
            @endforeach
            
        </select>
    </div>

    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-send"></i> Kirim Proposal
        </button>
    </div>
</form>

@endsection