@extends('layouts.admin') 
@section('title', 'Daftar Acara')
@section('content')

<h3 class="mb-3">📅 Manajemen & Laporan Acara</h3>

{{-- FILTER & SEARCH --}}
<div class="card mb-3 shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('admin.acara-list') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">-- Semua Status --</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active (Berjalan)</option>
                    <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Finished (Selesai)</option>
                    <option value="preparation" {{ request('status') == 'preparation' ? 'selected' : '' }}>Preparation</option>
                </select>
            </div>
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Cari nama acara..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.acara-list') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>Nama Acara</th>
                    <th>Periode</th>
                    <th>Status</th>
                    <th>Rata-rata KPI</th> {{-- Kolom Baru untuk Laporan --}}
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
                    <td>{{ $act->start_datetime->format('d M Y') }}</td>
                    <td class="text-center">
                        @if($act->status == 'finished') <span class="badge bg-dark">Selesai</span>
                        @elseif($act->status == 'active') <span class="badge bg-success">Berjalan</span>
                        @else <span class="badge bg-secondary">{{ ucfirst($act->status) }}</span>
                        @endif
                    </td>
                    <td class="text-center fw-bold text-warning">
                        @if($act->status == 'finished') 
                             ★ {{ $act->avg_kpi }}
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.panitia-detail', $act->activity_code) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4">Data tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{-- TAMBAHAN FITUR SORTING --}}
<style>
    /* Indikator cursor */
    th { cursor: pointer; position: relative; user-select: none; }
    th:hover { background-color: #f8f9fa; }
    
    /* Ikon Panah Default (Netral) */
    th::after { content: ' ⇅'; opacity: 0.2; float: right; font-size: 0.8em; }
    
    /* Ikon Panah Aktif */
    th.asc::after { content: ' ▲'; opacity: 1; color: #198754; }
    th.desc::after { content: ' ▼'; opacity: 1; color: #198754; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil semua header tabel di halaman ini
        const headers = document.querySelectorAll('th');

        headers.forEach(header => {
            header.addEventListener('click', () => {
                const table = header.closest('table');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                const index = Array.from(header.parentNode.children).indexOf(header);
                
                // Cek status sorting saat ini (asc atau desc)
                const isAsc = header.classList.contains('asc');
                
                // Reset semua header di tabel ini
                table.querySelectorAll('th').forEach(th => th.classList.remove('asc', 'desc'));
                
                // Set status baru
                if (isAsc) {
                    header.classList.remove('asc');
                    header.classList.add('desc');
                } else {
                    header.classList.remove('desc');
                    header.classList.add('asc');
                }

                // Logika Sorting
                rows.sort((rowA, rowB) => {
                    const cellA = rowA.children[index].innerText.trim();
                    const cellB = rowB.children[index].innerText.trim();

                    // Cek apakah isinya angka
                    const valA = isNaN(cellA) ? cellA : parseFloat(cellA);
                    const valB = isNaN(cellB) ? cellB : parseFloat(cellB);

                    if (valA < valB) return isAsc ? 1 : -1;
                    if (valA > valB) return isAsc ? -1 : 1;
                    return 0;
                });

                // Masukkan kembali baris yang sudah diurutkan ke tabel
                tbody.append(...rows);
            });
        });
    });
</script>
@endsection