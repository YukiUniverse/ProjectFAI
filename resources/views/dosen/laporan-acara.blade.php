@extends('layouts.dosen')
@section('title', 'Laporan Acara')
@section('content')

<h3>📅 Laporan Per Acara</h3>
<p class="text-muted">Pilih acara untuk melihat daftar mahasiswa yang terlibat.</p>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white">
        <input type="text" id="searchTable" class="form-control" placeholder="Cari nama acara...">
    </div>
    <div class="card-body p-0">
        <div style="max-height: 500px; overflow-y: auto;">
            <table class="table table-hover mb-0" id="dataTable">
                <thead class="table-primary sticky-top">
                    <tr>
                        <th>Nama Acara</th>
                        <th>Status</th>
                        <th>Tanggal Mulai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $act)
                    <tr>
                        <td>{{ $act->activity_name }}</td>
                        <td><span class="badge bg-secondary">{{ $act->status }}</span></td>
                        <td>{{ $act->start_datetime->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('dosen.laporan-acara-detail', $act->student_activity_id) }}" class="btn btn-sm btn-outline-primary">Lihat Peserta</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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