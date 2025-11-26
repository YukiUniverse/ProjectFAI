@extends('layouts.app')
@section('title', 'Profile')
@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-12 mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="col-lg-8 offset-lg-2">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4 p-md-5">

                        <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                            <div class="profile-pic-container me-4">
                                <img src="https://avatar.iran.liara.run/public/1" width="100" height="100" alt="Foto Profil"
                                    class="profile-pic">
                            </div>

                            <div>
                                <h2 class="mb-0 fw-bold">
                                    @if(Auth::user()->role == 'student')
                                        {{ Auth::user()->student->full_name }}
                                    @else
                                        {{ Auth::user()->lecturer->full_name }}
                                    @endif
                                </h2>
                                <p class="text-muted">ID:
                                    @if(Auth::user()->role == 'student')
                                        {{ Auth::user()->student_number }}
                                    @else
                                        {{ Auth::user()->lecturer_code }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        <h4 class="mb-3">📄 CV Saat Ini</h4>
                        <div class="cv-embed-container mb-5 p-3 border rounded bg-light">
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-file-earmark-pdf" style="font-size: 3rem;"></i>
                                <p class="mt-2">CV belum diunggah atau tidak dapat ditampilkan.</p>
                                <p class="small">Silakan unggah CV Anda di bawah ini.</p>
                            </div>

                        </div>

                        <h4 class="mb-3">⬆️ Unggah CV Terbaru</h4>
                        <form action="/upload-cv" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="file" class="form-control" id="inputCV" name="cv_file" required
                                    accept=".pdf,.doc,.docx">

                                <button class="btn btn-primary" type="submit" id="button-upload">
                                    <i class="bi bi-cloud-arrow-up"></i> Unggah CV
                                </button>
                            </div>
                            <small class="form-text text-muted">Format yang didukung: PDF, DOC, DOCX. Maksimal ukuran:
                                2MB.</small>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection