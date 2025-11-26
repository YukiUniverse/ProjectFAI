@extends('layouts.admin')
@section('title', 'Laporan Evaluasi Panitia')
@section('content')

<h3 class="mb-3">📊 Laporan Evaluasi Panitia</h3>
<p class="text-muted">Laporan ini berisi rekap nilai KPI dari seluruh panitia di setiap acara kampus yang telah selesai atau sedang berjalan.</p>

<form class="row g-2 mb-4" method="GET">
    <div class="col-md-4">
        <select class="form-select" disabled>
            <option selected>Semua Acara</option>
            </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100" type="button" disabled>Tampilkan</button>
    </div>
</form>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <h5 class="fw-bold text-primary mb-3">Rekap KPI Per Acara</h5>
        <table class="table table-bordered align-middle table-hover">
            <thead class="table-primary text-center">
                <tr>
                    <th>Nama Acara</th>
                    <th>Tanggal</th>
                    <th>Jumlah Panitia</th>
                    <th>Rata-rata KPI</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $act)
                <tr>
                    <td>
                        <div class="fw-bold">{{ $act->activity_name }}</div>
                        <small class="text-muted">{{ $act->activity_code }}</small>
                    </td>
                    <td>
                        {{ $act->start_datetime->format('d M Y') }}
                    </td>
                    <td class="text-center">{{ $act->total_staff }} Org</td>
                    
                    {{-- Logika Bintang --}}
                    <td class="text-warning fs-5 text-center">
                        @php $rating = round($act->avg_rating); @endphp
                        @for($i = 0; $i < $rating; $i++) ★ @endfor
                        @for($i = $rating; $i < 4; $i++) <span class="text-muted">☆</span> @endfor
                        <div style="font-size: 12px; color: #333;">({{ $act->avg_rating }})</div>
                    </td>

                    {{-- Logika Badge Status --}}
                    <td class="text-center">
                        @if($act->avg_rating >= 3.5)
                            <span class="badge bg-success">Sangat Baik</span>
                        @elseif($act->avg_rating >= 3.0)
                            <span class="badge bg-primary">Baik</span>
                        @elseif($act->avg_rating >= 2.0)
                            <span class="badge bg-warning text-dark">Cukup</span>
                        @else
                            <span class="badge bg-danger">Kurang</span>
                        @endif
                    </td>

                    <td class="text-center">
                        {{-- FIX ROUTE DISINI --}}
                        <a href="{{ route('admin.laporan-detail', ['activityCode' => $act->activity_code]) }}" 
                           class="btn btn-sm btn-outline-primary">
                            👁 Lihat Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Belum ada data acara yang selesai.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="fw-bold text-primary mb-3">🏅 Contoh Panitia Terbaik (Data Dummy)</h5>
        <div class="alert alert-info py-2"><small>Fitur Top Panitia akan segera hadir berdasarkan akumulasi poin.</small></div>
        <table class="table table-bordered align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>Nama Panitia</th>
                    <th>Acara</th>
                    <th>Divisi</th>
                    <th>Nilai KPI</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Budi Santoso</td>
                    <td>Innovation Hackday</td>
                    <td>Acara</td>
                    <td class="text-warning fs-5 text-center">★ ★ ★ ★</td>
                    <td><span class="badge bg-success">Sangat Baik</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="text-end mt-4">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Dashboard</a>
</div>

@endsection