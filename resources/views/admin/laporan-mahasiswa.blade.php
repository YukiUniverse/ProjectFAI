@extends('layouts.admin')
@section('title', 'Laporan Mahasiswa')
@section('content')

    <h3>🎓 Laporan Data Mahasiswa</h3>

    {{-- FILTER NAMA --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <form action="{{ route('admin.laporan-mahasiswa') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama / NRP..."
                    value="{{ request('search') }}">
                <button class="btn btn-primary">Cari</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>NRP</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>KPI Global (Avg)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $s)
                        <tr>
                            <td>{{ $s->student_number }}</td>
                            <td>{{ $s->full_name }}</td>
                            <td>{{ $s->department->department_name ?? '-' }}</td>
                            <td class="fw-bold {{ $s->global_kpi == '-' ? 'text-muted' : 'text-primary' }}">
                                {{ $s->global_kpi }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.laporan-mahasiswa-detail', $s->student_id) }}"
                                    class="btn btn-sm btn-outline-success">Detail Riwayat</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-3">Mahasiswa tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $students->links() }}
        </div>
    </div>
    {{-- TAMBAHAN FITUR SORTING --}}
    <style>
        /* Indikator cursor */
        th {
            cursor: pointer;
            position: relative;
            user-select: none;
        }

        th:hover {
            background-color: #f8f9fa;
        }

        /* Ikon Panah Default (Netral) */
        th::after {
            content: ' ⇅';
            opacity: 0.2;
            float: right;
            font-size: 0.8em;
        }

        /* Ikon Panah Aktif */
        th.asc::after {
            content: ' ▲';
            opacity: 1;
            color: #198754;
        }

        th.desc::after {
            content: ' ▼';
            opacity: 1;
            color: #198754;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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