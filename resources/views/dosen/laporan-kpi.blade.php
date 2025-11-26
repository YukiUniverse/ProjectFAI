@extends('layouts.dosen') {{-- Sesuaikan layout Anda --}}
@section('content')

<h3 class="mb-4">📊 Laporan KPI Mahasiswa</h3>

<div class="card shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Jurusan</th>
                    <th>Rata-rata Rating (KPI)</th>
                    <th>Predikat</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $s)
                <tr>
                    <td class="text-center">{{ $s->student_number }}</td>
                    <td>{{ $s->full_name }}</td>
                    <td>{{ $s->department->department_name ?? '-' }}</td>
                    
                    <td class="text-center fw-bold text-primary">
                        @if($s->kpi_score !== 'Belum Ada')
                            ⭐ {{ $s->kpi_score }}
                        @else
                            <span class="text-muted small">Belum ada data</span>
                        @endif
                    </td>
                    
                    <td class="text-center">
                        @if($s->predikat == 'Sangat Baik') <span class="badge bg-success">Sangat Baik</span>
                        @elseif($s->predikat == 'Baik') <span class="badge bg-info">Baik</span>
                        @elseif($s->predikat == 'Cukup') <span class="badge bg-warning">Cukup</span>
                        @else <span class="badge bg-secondary">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection