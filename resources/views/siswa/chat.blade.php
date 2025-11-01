@extends('layouts.app')
@section('title', 'Chat')
@section('content')
    <a href="{{ route('siswa.panitia-detail') }}" class="btn btn-danger">Back</a>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold text-primary mb-0">💬 Forum / Chat Panitia</h5>
            <span class="badge bg-success">Online: 5</span>
    </div>
    <p class="text-muted mb-3">Gunakan forum ini untuk berdiskusi dan berkoordinasi antar panitia secara internal.
    </p>
    <div id="chat">
        <div class="card shadow-sm p-4">
            <!-- AREA PESAN -->
            <div class="border rounded p-3 mb-3 bg-light" style="height: 350px; overflow-y: auto;">
                <!-- Pesan dari orang lain -->
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <img src="https://ui-avatars.com/api/?name=Andi+Wijaya&background=198754&color=fff"
                            class="rounded-circle" width="40" height="40">
                    </div>
                    <div class="ms-2">
                        <div class="bg-white border rounded p-2 shadow-sm" style="max-width: 75%;">
                            <strong>Andi (Ketua)</strong><br>
                            Jangan lupa upload poster besok ya!
                        </div>
                        <small class="text-muted">09:15</small>
                    </div>
                </div>

                <!-- Pesan dari user sendiri -->
                <div class="d-flex justify-content-end mb-3">
                    <div class="text-end">
                        <div class="bg-success text-white rounded p-2 shadow-sm" style="max-width: 75%;">
                            Sudah kak, tinggal posting sore ini 🙌
                        </div>
                        <small class="text-muted">09:20</small>
                    </div>
                </div>

                <!-- Pesan lain -->
                <div class="d-flex mb-3">
                    <div class="flex-shrink-0">
                        <img src="https://ui-avatars.com/api/?name=Rina+Sari&background=0d6efd&color=fff"
                            class="rounded-circle" width="40" height="40">
                    </div>
                    <div class="ms-2">
                        <div class="bg-white border rounded p-2 shadow-sm" style="max-width: 75%;">
                            <strong>Rina (Publikasi)</strong><br>
                            Mau sekalian pakai logo fakultas juga gak?
                        </div>
                        <small class="text-muted">09:25</small>
                    </div>
                </div>

                <div class="d-flex justify-content-end mb-3">
                    <div class="text-end">
                        <div class="bg-success text-white rounded p-2 shadow-sm" style="max-width: 75%;">
                            Boleh banget, biar lebih resmi!
                        </div>
                        <small class="text-muted">09:26</small>
                    </div>
                </div>
            </div>

            <!-- FORM INPUT PESAN -->
            <form class="input-group">
                <input type="text" class="form-control" placeholder="Ketik pesan di sini...">
                <button class="btn btn-success">Kirim</button>
            </form>
        </div>
    </div>
@endsection