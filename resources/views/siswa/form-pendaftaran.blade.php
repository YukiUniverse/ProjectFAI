@extends('layouts.app')
@section('title', 'Form Pendaftaran Panitia')
@section('content')
    <h3>Form Pendaftaran Panitia</h3>
    <div class="card shadow-sm mb-4 p-4">
        <h4 class="fw-bold text-primary">{{$activity->activity_name}}</h4>
        <p>{{$activity->activity_description}}</p>
        <ul class="list-unstyled">
            <li>
                <strong>Tanggal:</strong>
                {{ \Carbon\Carbon::parse($activity->start_datetime)->format('d M Y, H:i') }} -
                {{ \Carbon\Carbon::parse($activity->end_datetime)->format('d M Y, H:i') }}
            </li>
            <li><strong>Lokasi:</strong> Aula Utama Kampus</li>
        </ul>
    </div>
    <form class="card p-4 shadow-sm" method="post" action="{{ route('siswa.daftar', $activity->student_activity_id) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="choice_1_sub_role_id">Pilih Divisi 1</label>
            <select class="form-select" name="choice_1_sub_role_id" required>
                @foreach ($divisi as $d)
                    <option value="{{ $d->sub_role_id }}">{{ $d->sub_role_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="reason_1">Alasan memilih divisi 1</label>
            <textarea name="reason_1" class="form-control" rows="4" placeholder="Tuliskan alasan bergabung divisi ini..."
                required></textarea>

        </div>

        <div class="mb-3">
            <label class="form-label" for="choice_2_sub_role_id">Pilih Divisi 2 (optional)</label>
            <select class="form-select" name="choice_2_sub_role_id">
                @foreach ($divisi as $d)
                    <option value="{{ $d->sub_role_id }}">{{ $d->sub_role_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="reason_1">Alasan memilih divisi 2 (optional)</label>
            <textarea name="reason_2" class="form-control" rows="4"
                placeholder="Tuliskan alasan bergabung divisi ini..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Kirim Pendaftaran</button>
    </form>
@endsection