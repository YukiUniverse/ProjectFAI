@extends('layouts.app')
@section('title', 'Status Pendaftaran Panitia')
@section('content')

    <h3 class="mb-3">📋 Status Pendaftaran Panitia</h3>
    <p class="text-muted">Pantau status pendaftaran kamu pada berbagai acara kampus.</p>

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <table class="table table-bordered data_table align-middle">
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
                                    {{ $d->firstChoice->sub_role_name }}
                                @else
                                    {{ $d->firstChoice->sub_role_name }}
                                    @if($d->secondChoice)
                                        & {{ $d->secondChoice->sub_role_name }}
                                    @endif
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

@endsection