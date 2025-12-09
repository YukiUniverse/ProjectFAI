@extends('layouts.dosen')
@section('title', 'Detail Riwayat Mahasiswa')
@section('content')

<a href="{{ route('dosen.laporan-mahasiswa') }}" class="btn btn-sm btn-outline-secondary mb-3">⬅ Kembali</a>
<div class="card mb-4 border-0 shadow-sm bg-success text-white">
    <div class="card-body d-flex align-items-center gap-3">
        <div style="font-size: 40px;">👨‍🎓</div>
        <div>
            <h4 class="mb-0">{{ $student->full_name }}</h4>
            <small>{{ $student->student_number }} | {{ $student->department->department_name ?? 'Umum' }}</small>
        </div>
    </div>
</div>

<h5 class="fw-bold mb-3">📜 Riwayat Pendaftaran & KPI</h5>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Nama Acara</th>
                    <th>Divisi Dilamar</th>
                    <th>Status Lamaran</th>
                    <th>Alasan (Jika Ditolak)</th>
                    <th>Nilai KPI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($historyApplications as $app)
                <tr>
                    <td>{{ $app->activityDetail->activity_name }}</td>
                    <td>{{ $app->firstChoice->sub_role_name ?? '-' }}</td>
                    <td class="text-center">
                        @if($app->status == 'accepted') <span class="badge bg-success">Diterima</span>
                        @elseif($app->status == 'rejected') <span class="badge bg-danger">Ditolak</span>
                        @else <span class="badge bg-warning text-dark">{{ ucfirst($app->status) }}</span>
                        @endif
                    </td>
                    <td>
                        {{-- Tampilkan alasan jika ditolak --}}
                        @if($app->status == 'rejected')
                            <span class="text-danger small">{{ $app->decision_reason ?? 'Tidak ada alasan spesifik.' }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {{-- KPI Score hanya muncul jika status accepted dan acara sudah dinilai --}}
                        @if($app->status == 'accepted' && $app->kpi_score != '-')
                            <span class="fw-bold text-warning">{{ $app->kpi_score }} ★</span>
                        @else
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4">Belum ada riwayat kegiatan.</td></tr>
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

    document.getElementById('searchTable').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#dataTable tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection