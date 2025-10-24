@extends('layouts.app')
@section('title', 'Evaluasi Panitia (KPI)')
@section('content')

<h3 class="mb-3">Evaluasi Kinerja Panitia</h3>
<p class="text-muted">Beri penilaian berdasarkan kontribusi, kerja sama, dan tanggung jawab anggota panitia divisi kamu.</p>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>Nama</th>
                    <th>Divisi</th>
                    <th>Penilaian (Bintang)</th>
                    <th>Alasan / Catatan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Andi</td>
                    <td>Publikasi</td>
                    <td class="text-center">
                        <div class="rating d-flex justify-content-center">
                            @for ($i = 1; $i <= 4; $i++)
                                <input type="radio" name="rating_andi" id="andi_{{ $i }}" value="{{ $i }}" class="d-none">
                                <label for="andi_{{ $i }}" style="cursor:pointer; font-size:1.3rem;" class="mx-1 text-warning">★</label>
                            @endfor
                        </div>
                        <small class="text-muted">(Pilih 1–4 bintang)</small>
                    </td>
                    <td>
                        <textarea name="alasan_andi" rows="2" class="form-control" placeholder="Tulis alasan atau catatan penilaian..."></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Bella</td>
                    <td>Acara</td>
                    <td class="text-center">
                        <div class="rating d-flex justify-content-center">
                            @for ($i = 1; $i <= 4; $i++)
                                <input type="radio" name="rating_bella" id="bella_{{ $i }}" value="{{ $i }}" class="d-none">
                                <label for="bella_{{ $i }}" style="cursor:pointer; font-size:1.3rem;" class="mx-1 text-warning">★</label>
                            @endfor
                        </div>
                        <small class="text-muted">(Pilih 1–4 bintang)</small>
                    </td>
                    <td>
                        <textarea name="alasan_bella" rows="2" class="form-control" placeholder="Tulis alasan atau catatan penilaian..."></textarea>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="text-end mt-3">
    <button class="btn btn-primary">💾 Simpan Evaluasi</button>
    <a href="{{ route('siswa.panitia-detail') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Detail Acara</a>
</div>

@endsection
