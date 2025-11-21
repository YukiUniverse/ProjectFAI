@extends('layouts.app')

@section('title', 'Edit Jadwal')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">✏️ Edit Jadwal Kegiatan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.jadwal-update', $schedule->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Kegiatan</label>
                            <input type="text" name="title" class="form-control" value="{{ $schedule->title }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Waktu Pelaksanaan</label>
                                {{-- Format value datetime-local harus Y-m-d\TH:i --}}
                                <input type="datetime-local" name="start_time" class="form-control" 
                                    value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('Y-m-d\TH:i') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lokasi</label>
                                <input type="text" name="location" class="form-control" value="{{ $schedule->location }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status Kegiatan</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $schedule->status == 'pending' ? 'selected' : '' }}>Pending (Belum Terlaksana)</option>
                                <option value="completed" {{ $schedule->status == 'completed' ? 'selected' : '' }}>Selesai (Terlaksana)</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('siswa.panitia-detail', $schedule->activity->activity_code) }}" class="btn btn-secondary">
                                ⬅️ Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                💾 Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection