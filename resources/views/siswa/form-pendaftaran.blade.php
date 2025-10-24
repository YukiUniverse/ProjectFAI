@extends('layouts.app')
@section('title', 'Form Pendaftaran Panitia')
@section('content')
<h3>Form Pendaftaran Panitia</h3>
<form class="card p-4 shadow-sm">
    <div class="mb-3">
        <label class="form-label">Pilih Acara</label>
        <select class="form-select">
            <option selected>Festival Kampus 2025</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Divisi</label>
        <select class="form-select">
            <option>Publikasi</option>
            <option>Acara</option>
            <option>Perlengkapan</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Alasan</label>
        <textarea class="form-control" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Upload CV</label>
        <input type="file" class="form-control">
    </div>
    <a href="{{ route('siswa.status') }}" class="btn btn-primary">Kirim Pendaftaran</a>
</form>
@endsection
