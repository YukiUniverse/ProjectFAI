@extends('layouts.app')

@section('title', 'My Invites')

@section('content')
    <div class="container my-5">

        {{-- Header & Back Button --}}
        <div class="row mb-4 align-items-center">
            <div class="col-auto">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-circle p-2"
                    style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-arrow-left"></i>
                </a>
            </div>
            <div class="col">
                <h2 class="mb-0 fw-bold">Activity Invitations</h2>
                <p class="text-muted mb-0">Manage your committee invitations</p>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="list-group list-group-flush">

                @forelse($invites as $invite)
                    <div
                        class="list-group-item p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">

                        {{-- Left Side: Icon & Info --}}
                        <div class="d-flex align-items-center gap-3">
                            {{-- Icon Placeholder --}}
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary flex-shrink-0"
                                style="width: 50px; height: 50px;">
                                <i class="bi bi-envelope-paper fs-4"></i>
                            </div>

                            <div>
                                <h5 class="fw-bold mb-1 text-dark">
                                    {{ $invite->activity->activity_name }}
                                </h5>
                                <div class="text-muted small">
                                    <i class="bi bi-building me-1"></i> {{ $invite->activity->student_organization_id }}
                                    <span class="mx-1">•</span>
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ \Carbon\Carbon::parse($invite->activity->start_datetime)->format('d M Y') }}
                                </div>
                            </div>
                        </div>

                        {{-- Right Side: Actions or Status --}}
                        <div class="d-flex align-items-center justify-content-md-end gap-2">

                            @if($invite->status === 'pending')
                                {{-- Action Buttons for Pending --}}

                                {{-- ACCEPT FORM --}}
                                <form action="{{ route('siswa.invites.respond', $invite->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="accept">
                                    <button type="submit"
                                        class="btn btn-success btn-lg rounded-circle p-0 d-flex align-items-center justify-content-center shadow-sm"
                                        style="width: 45px; height: 45px;" title="Accept Invitation"
                                        onclick="return confirm('Are you sure you want to join this activity?')">
                                        <i class="bi bi-check-lg fs-4"></i>
                                    </button>
                                </form>

                                {{-- DECLINE FORM --}}
                                <form action="{{ route('siswa.invites.respond', $invite->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="decline">
                                    <button type="submit"
                                        class="btn btn-outline-danger btn-lg rounded-circle p-0 d-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;" title="Decline Invitation"
                                        onclick="return confirm('Are you sure you want to decline?')">
                                        <i class="bi bi-x-lg fs-4"></i>
                                    </button>
                                </form>

                            @elseif($invite->status === 'accept')
                                {{-- Accepted Badge --}}
                                <div
                                    class="px-4 py-2 bg-success bg-opacity-10 text-success rounded-pill fw-bold border border-success border-opacity-25">
                                    <i class="bi bi-check-circle-fill me-2"></i> Accepted
                                </div>

                            @else
                                {{-- Declined Badge --}}
                                <div
                                    class="px-4 py-2 bg-danger bg-opacity-10 text-danger rounded-pill fw-bold border border-danger border-opacity-25">
                                    <i class="bi bi-x-circle-fill me-2"></i> Declined
                                </div>
                            @endif

                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="text-center py-5">
                        <div class="mb-3 text-muted opacity-50">
                            <i class="bi bi-inbox fs-1"></i>
                        </div>
                        <h5 class="fw-bold text-secondary">No Invitations Yet</h5>
                        <p class="text-muted small">You're all caught up! Check back later.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
@endsection