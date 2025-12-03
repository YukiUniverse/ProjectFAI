@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('content')

<h3 class="mb-3">📊 Dashboard Admin</h3>
<p class="text-muted">Selamat datang di panel admin. Pantau aktivitas kampus secara real-time.</p>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 p-3 text-center bg-white h-100">
            <h6 class="text-secondary mb-1">Acara Aktif</h6>
            <h3 class="fw-bold text-primary">{{ $activeActivities }}</h3>
            <a href="{{ route('admin.acara-list') }}" class="btn btn-outline-primary btn-sm mt-2">📅 Lihat Acara</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 p-3 text-center bg-white h-100">
            <h6 class="text-secondary mb-1">Proposal Pending</h6>
            <h3 class="fw-bold text-warning">{{ $pendingProposals }}</h3>
            <a href="{{ route('admin.proposal-list') }}" class="btn btn-outline-warning btn-sm mt-2">📄 Verifikasi</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 p-3 text-center bg-white h-100">
            <h6 class="text-secondary mb-1">Total Mahasiswa</h6>
            <h3 class="fw-bold text-success">{{ $totalStudents }}</h3>
            <button class="btn btn-outline-success btn-sm mt-2" disabled>🎓 Data Master</button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary">📋 Log Pendaftaran Terbaru</h5>
                <input type="text" id="searchLog" class="form-control form-control-sm w-25" placeholder="Cari...">
            </div>
            <div class="card-body p-0">
                <div style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover mb-0" id="tableLog">
                        <thead class="table-light sticky-top" style="z-index: 1;">
                            <tr>
                                <th>Mahasiswa</th>
                                <th>Acara</th>
                                <th>Divisi</th>
                                <th>Status</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentRegistrations as $reg)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $reg->student->full_name }}</div>
                                    <small class="text-muted">{{ $reg->student->student_number }}</small>
                                </td>
                                <td>{{ $reg->activityDetail->activity_name }}</td>
                                <td>{{ $reg->firstChoice->sub_role_name ?? '-' }}</td>
                                <td>
                                    @if($reg->status == 'accepted') <span class="badge bg-success">Diterima</span>
                                    @elseif($reg->status == 'rejected') <span class="badge bg-danger">Ditolak</span>
                                    @else <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $reg->created_at->format('d M, H:i') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4">Belum ada pendaftaran baru.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold text-success">📈 KPI Acara Selesai</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-success">
                            <tr>
                                <th>Acara</th>
                                <th class="text-center">Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kpiSummary as $kpi)
                            <tr>
                                <td>
                                    <div class="text-truncate" style="max-width: 150px;" title="{{ $kpi->activity_name }}">
                                        {{ $kpi->activity_name }}
                                    </div>
                                    <small class="text-muted">{{ $kpi->end_datetime ? $kpi->end_datetime->format('d M Y') : '-' }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-warning">★ {{ $kpi->avg_rating }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="2" class="text-center py-4 text-muted">Belum ada acara selesai.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white text-center">
                <a href="{{ route('admin.laporan') }}" class="btn btn-sm btn-link text-decoration-none">Lihat Laporan Lengkap →</a>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT SEARCH & SORTING --}}
<style>
    /* Styling cursor sorting */
    th { cursor: pointer; user-select: none; }
    th:hover { background-color: #f1f1f1; }
    th::after { content: ' ⇅'; opacity: 0.3; float: right; font-size: 0.8em; }
    th.asc::after { content: ' ▲'; opacity: 1; color: #0d6efd; }
    th.desc::after { content: ' ▼'; opacity: 1; color: #0d6efd; }
</style>

<script>
    // 1. Script Search Log Pendaftaran
    document.getElementById('searchLog').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableLog tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // 2. Script Sorting Table (Universal)
    document.addEventListener('DOMContentLoaded', function() {
        const headers = document.querySelectorAll('th');

        headers.forEach(header => {
            header.addEventListener('click', () => {
                const table = header.closest('table');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));
                const index = Array.from(header.parentNode.children).indexOf(header);
                const isAsc = header.classList.contains('asc');
                
                // Reset header lain
                table.querySelectorAll('th').forEach(th => th.classList.remove('asc', 'desc'));

                // Set arah sort baru
                if (isAsc) {
                    header.classList.add('desc');
                } else {
                    header.classList.add('asc');
                }
                
                const modifier = isAsc ? -1 : 1;

                rows.sort((rowA, rowB) => {
                    const cellA = rowA.children[index].innerText.trim();
                    const cellB = rowB.children[index].innerText.trim();
                    
                    const valA = isNaN(cellA) ? cellA : parseFloat(cellA);
                    const valB = isNaN(cellB) ? cellB : parseFloat(cellB);

                    if (valA < valB) return -1 * modifier;
                    if (valA > valB) return 1 * modifier;
                    return 0;
                });

                tbody.append(...rows);
            });
        });
    });
</script>

@endsection