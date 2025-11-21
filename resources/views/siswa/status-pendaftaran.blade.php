@extends('layouts.app')
@section('title', 'Status Pendaftaran Panitia')
@section('content')

    <h3 class="mb-3">📋 Status Pendaftaran Panitia</h3>
    <p class="text-muted">Pantau status pendaftaran kamu pada berbagai acara kampus.</p>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Nama Acara</th>
                        <th>Divisi</th>
                        <th>Status</th>
                        <th>Alasan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{$d->activityDetail->activity_name}}</td>
                            <td>
                                @if($d->status == "accepted")
                                    Divisi Akhir
                                @else
                                    Divisi yang Kupilih
                                @endif
                            </td>
                            <td><span
                                    class="badge bg-{{ $d->status == "accepted" ? "success" : ($d->status == "pending" ? "warning" : "danger") }}">{{ $d->status }}</span>
                            </td>
                            <td>{{$d->decision_reason}}</td>
                        </tr>

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <div class="text-end">
        <a href="{{ route('siswa.daftar-acara') }}" class="btn btn-outline-primary">📅 Lihat Daftar Acara</a>
        <a href="{{ route('siswa.status-proposal') }}" class="btn btn-primary">➡️ Lihat Status Proposal</a>
    </div>

@endsection