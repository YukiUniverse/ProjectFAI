@extends('layouts.dosen')
@section('title', 'Dashboard Dosen Pembimbing')
@section('content')

<h3 class="mb-3">Dashboard Dosen</h3>
<p class="text-muted">Selamat datang, Dosen. Anda dapat memantau hasil evaluasi (KPI) mahasiswa pada setiap acara yang mereka ikuti.</p>
<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">🎓 Quick Monitor Mahasiswa</h5>
        <input type="text" id="searchMhs" class="form-control form-control-sm w-25" placeholder="Cari mahasiswa...">
    </div>
    <div class="card-body p-0">
        <div style="max-height: 400px; overflow-y: auto;">
            <table class="table table-hover mb-0" id="tableMhs">
                <thead class="table-light sticky-top">
                    <tr>
                        <th>NRP</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>KPI (Avg)</th>
                        <th>Aktivitas Terakhir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $s)
                    <tr>
                        <td>{{ $s->student_number }}</td>
                        <td>{{ $s->full_name }}</td>
                        <td>{{ $s->department->department_name ?? '-' }}</td>
                        <td class="fw-bold {{ $s->kpi_score == '-' ? 'text-muted' : 'text-primary' }}">{{ $s->kpi_score }}</td>
                        <td>{{ $s->last_active }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
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

    document.getElementById('searchMhs').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableMhs tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection
