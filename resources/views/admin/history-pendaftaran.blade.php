@extends('layouts.admin')
@section('title', 'Log Pendaftaran Organisasi')
@section('content')

<h3 class="mb-3">📋 Log Pendaftaran Organisasi</h3>
<p class="text-muted">Riwayat lengkap seluruh pendaftaran mahasiswa ke dalam kepanitiaan atau organisasi.</p>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-primary">Data Pendaftaran</h5>
        <input type="text" id="searchInput" class="form-control form-control-sm w-25" placeholder="Cari mahasiswa / acara...">
    </div>
    
    <div class="card-body p-0">
        <div style="max-height: 500px; overflow-y: auto;">
            <table class="table table-hover mb-0" id="dataTable">
                <thead class="table-light sticky-top">
                    <tr>
                        <th>Tanggal</th>
                        <th>Mahasiswa</th>
                        <th>Acara Dituju</th>
                        <th>Pilihan Divisi</th>
                        <th>Status Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $log)
                    <tr>
                        <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <div class="fw-bold">{{ $log->student->full_name }}</div>
                            <small class="text-muted">{{ $log->student->student_number }}</small>
                        </td>
                        <td>{{ $log->activityDetail->activity_name }}</td>
                        <td>{{ $log->firstChoice->sub_role_name ?? '-' }}</td>
                        <td>
                            @if($log->status == 'accepted') 
                                <span class="badge bg-success">Diterima</span>
                            @elseif($log->status == 'rejected') 
                                <span class="badge bg-danger">Ditolak</span>
                            @else 
                                <span class="badge bg-warning text-dark">{{ ucfirst($log->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada riwayat pendaftaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card-footer bg-white">
        {{ $history->links() }}
    </div>
</div>

{{-- SCRIPT SEARCH & SORTING --}}
<style>
    th { cursor: pointer; user-select: none; }
    th:hover { background-color: #f1f1f1; }
    th::after { content: ' ⇅'; opacity: 0.3; float: right; font-size: 0.8em; }
    th.asc::after { content: ' ▲'; opacity: 1; color: #0d6efd; }
    th.desc::after { content: ' ▼'; opacity: 1; color: #0d6efd; }
</style>

<script>
    // Search Function
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#dataTable tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // Sorting Function
    document.addEventListener('DOMContentLoaded', function() {
        const headers = document.querySelectorAll('th');
        headers.forEach(header => {
            header.addEventListener('click', () => {
                const table = header.closest('table');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                const index = Array.from(header.parentNode.children).indexOf(header);
                const isAsc = header.classList.contains('asc');
                
                table.querySelectorAll('th').forEach(th => th.classList.remove('asc', 'desc'));

                if (isAsc) {
                    header.classList.add('desc');
                } else {
                    header.classList.add('asc');
                }
                
                const modifier = isAsc ? -1 : 1;

                rows.sort((rowA, rowB) => {
                    const cellA = rowA.children[index].innerText.trim();
                    const cellB = rowB.children[index].innerText.trim();
                    
                    if (cellA < cellB) return -1 * modifier;
                    if (cellA > cellB) return 1 * modifier;
                    return 0;
                });

                tbody.append(...rows);
            });
        });
    });
</script>

@endsection