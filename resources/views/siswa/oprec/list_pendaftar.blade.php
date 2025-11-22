@extends('layouts.app')
@section('title', 'List Pendaftar')
@section('content')
    <a class="btn btn-primary" href="{{ back() }}">Back</a>
    <a class="btn btn-primary">Halaman pertanyaan</a>
    <div class="card shadow-sm p-4">

        <h6 class="fw-bold text-success mt-3">🧾 Manajemen Pendaftar Panitia</h6>
        <p class="text-muted small">Tinjau data pendaftar panitia baru.</p>

        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Nama</th>
                    <th>Divisi 1</th>
                    <th>Divisi 2</th>
                    <th>Detail</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Yulia Pratiwi</td>
                    <td>Publikasi</td>
                    <td>Publikasi</td>
                    <td class="text-center"><a href="#" class="btn btn-sm btn-outline-primary">📄 Lihat</a></td>
                    <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                    <td class="text-center">
                        <button class="btn btn-success btn-sm">Terima</button>
                        <button class="btn btn-danger btn-sm">Tolak</button>
                    </td>
                </tr>
                <tr>
                    <td>Dani Setiawan</td>
                    <td>Perlengkapan</td>
                    <td>Perlengkapan</td>
                    <td class="text-center"><a href="#" class="btn btn-sm btn-outline-primary">📄 Lihat</a></td>
                    <td><span class="badge bg-success">Diterima</span></td>
                    <td class="text-center"><button class="btn btn-secondary btn-sm" disabled>Sudah Diproses</button></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection