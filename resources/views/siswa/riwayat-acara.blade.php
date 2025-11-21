@extends('layouts.app')
@section('title', 'Riwayat Keikutsertaan Acara')
@section('content')

<h3 class="mb-3">Riwayat Keikutsertaan Acara</h3>
<p class="text-muted">Lihat daftar acara yang pernah kamu ikuti beserta peran dan hasil evaluasi kinerjamu (KPI).</p>

<div class="card shadow-sm mb-4 border-0">
    <div class="card-body text-center">
        <h5 class="fw-bold text-primary mb-2">Rata-Rata Nilai KPI Keseluruhan</h5>
        <div class="fs-3 text-warning">
            @php $roundedOverall = round($overallKpi); @endphp
            @for($i = 1; $i <= 4; $i++)
                @if($i <= $roundedOverall) ★ @else ☆ @endif
            @endfor
        </div>
        <h6 class="mt-2 text-secondary">Rata-rata: <strong>{{ $overallKpi }} / 4.0</strong> </h6>
        <small class="text-muted">Berdasarkan {{ $totalEvent }} acara yang pernah diikuti</small>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>Nama Acara</th>
                    <th>Peran</th> {{-- Saya gabung Divisi & Jabatan biar hemat tempat --}}
                    <th style="width: 15%;">Nilai KPI</th>
                    <th style="width: 40%;">Catatan / Masukan</th> {{-- KOLOM BARU --}}
                </tr>
            </thead>
            <tbody>
                @forelse($histories as $h)
                    <tr>
                        {{-- KOLOM 1: NAMA ACARA --}}
                        <td>
                            <strong>{{ $h->activity->activity_name }}</strong>
                            <br>
                            <span class="text-muted small">
                                {{ \Carbon\Carbon::parse($h->activity->start_datetime)->translatedFormat('M Y') }}
                            </span>
                            <div class="mt-1">
                                @if($h->activity->status == 'finished')
                                    <span class="badge bg-success" style="font-size: 0.65em">Selesai</span>
                                @elseif($h->activity->status == 'active')
                                    <span class="badge bg-primary" style="font-size: 0.65em">Aktif</span>
                                @else
                                    <span class="badge bg-secondary" style="font-size: 0.65em">{{ $h->activity->status }}</span>
                                @endif
                            </div>
                        </td>
                        
                        {{-- KOLOM 2: PERAN --}}
                        <td>
                            <div class="fw-bold">{{ $h->role->role_name }}</div>
                            <div class="text-muted small">{{ $h->subRole->sub_role_name_en ?? '-' }}</div>
                        </td>
                        
                        {{-- KOLOM 3: NILAI --}}
                        <td class="text-center">
                            @if($h->kpi_score > 0)
                                <span class="text-warning fs-5">
                                    @php $roundedScore = round($h->kpi_score); @endphp
                                    @for($i = 1; $i <= 4; $i++)
                                        {{ $i <= $roundedScore ? '★' : '☆' }}
                                    @endfor
                                </span>
                                <br>
                                <strong class="text-dark">{{ $h->kpi_score }}</strong>
                            @else
                                <span class="text-muted small fst-italic">Belum Dinilai</span>
                            @endif
                        </td>

                        {{-- KOLOM 4: ALASAN / REVIEW --}}
                        <td class="text-start bg-light">
                            @if($h->final_review)
                                <div class="small text-secondary" style="font-style: italic;">
                                    
                                    {{-- 1. Pecah text berdasarkan Enter (\n) --}}
                                    @php $reasons = explode("\n", $h->final_review); @endphp

                                    {{-- 2. Loop setiap alasan --}}
                                    @foreach($reasons as $reason)
                                        {{-- Cek agar baris kosong tidak ikut dicetak --}}
                                        @if(trim($reason) !== "")
                                            "{{ $reason }}" <br><br>
                                        @endif
                                    @endforeach

                                </div>
                            @else
                                <span class="text-muted small">- Tidak ada catatan -</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            <i class="bi bi-calendar-x display-6 d-block mb-2"></i>
                            Belum ada riwayat kepanitiaan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection