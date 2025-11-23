@extends('layouts.app')
@section('title', 'List Pendaftar')
@section('content')
    <a class="btn btn-primary" href="{{ route('siswa.panitia-dashboard') }}">Back</a>

    <div class="card shadow-sm p-4">

        <h6 class="fw-bold text-success mt-3">🧾 Manajemen Pendaftar Panitia</h6>
        <p class="text-muted small">Tinjau data pendaftar panitia baru.</p>

        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Nama</th>
                    <th>Divisi 1</th>
                    <th>Divisi 2</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listPendaftar as $p)
                    <tr>
                        <td>{{ $p->student->full_name }}</td>
                        <td>{{ $p->firstChoice->sub_role_name }}</td>
                        <td>{{ $p->secondChoice ? $p->secondChoice->sub_role_name : "" }}</td>
                        <td><span
                                class="badge bg-{{ $p->status == "accepted" ? "success" : ($p->status == "rejected" ? "danger" : "warning") }} text-dark">{{ $p->status }}</span>
                        </td>
                        <td class="text-center"><a
                                href="{{ route('siswa.detail-pendaftar', [$activity->activity_code, $p->id]) }}"
                                class="btn btn-sm btn-outline-primary">📄 Lihat</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection