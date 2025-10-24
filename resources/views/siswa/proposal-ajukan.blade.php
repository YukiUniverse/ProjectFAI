@extends('layouts.app')
@section('title', 'Ajukan Proposal Acara')
@section('content')
<h3>Ajukan Proposal Acara Baru</h3>
<p class="text-muted">Isi detail acara baru untuk diajukan ke admin dan dosen pembimbing.</p>

<form class="card p-4 shadow-sm">
    <div class="mb-3">
        <label class="form-label">Nama Acara</label>
        <input type="text" class="form-control">
    </div>
    <div class="mb-3">
        <label class="form-label">Deskripsi Acara</label>
        <textarea class="form-control" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Dosen Pembimbing</label>
        <input type="text" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Kirim Proposal</button>
</form>
@endsection
