@extends('layouts.admin') {{-- Pastikan nama layout sesuai file Anda --}}
@section('title', 'Daftar Acara')
@section('content')

<h3 class="mb-3">Daftar Acara Aktif</h3>
<p class="text-muted">Berikut daftar acara kampus yang telah disetujui dan sedang berlangsung.</p>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-bordered align-middle table-hover">
            <thead class="table-primary text-center">
                <tr>
                    <th>Nama Acara</th>
                    <th>Ketua Pelaksana</th>
                    <th>Periode Acara</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                <tr>
                    <td>
                        <div class="fw-bold">{{ $activity->activity_name }}</div>
                        <small class="text-muted">{{ $activity->activity_code }}</small>
                    </td>
                    <td>
                        {{-- Mengambil nama mahasiswa lewat relasi proposal -> student --}}
                        {{ $activity->proposal->student->full_name ?? 'Data tidak ditemukan' }}
                    </td>
                    <td>
                        {{ $activity->start_datetime->format('d M Y') }} 
                        <span class="text-muted">-</span> 
                        {{ $activity->end_datetime ? $activity->end_datetime->format('d M Y') : '?' }}
                    </td>
                    <td class="text-center">
                        @if($activity->status == 'active')
                            <span class="badge bg-success">Aktif</span>
                        @elseif($activity->status == 'preparation')
                            <span class="badge bg-warning text-dark">Persiapan</span>
                        @elseif($activity->status == 'finished')
                            <span class="badge bg-secondary">Selesai</span>
                        @else
                            <span class="badge bg-info">{{ ucfirst($activity->status) }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {{-- PERBAIKAN ROUTE DISINI --}}
                        <a href="{{ route('admin.panitia-detail', ['activityCode' => $activity->activity_code]) }}" 
                           class="btn btn-outline-primary btn-sm">
                            👥 Detail Panitia
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Belum ada acara yang aktif saat ini.
                    </td>
                </tr>
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