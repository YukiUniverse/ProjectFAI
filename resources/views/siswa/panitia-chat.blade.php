@extends('layouts.app')
@section('title', 'Forum / Chat Panitia')
@section('content')

<h3 class="mb-3">Forum / Chat Panitia</h3>
<p class="text-muted">Gunakan forum ini untuk berkomunikasi dengan sesama panitia. Hanya panitia yang tergabung dalam acara ini yang dapat mengakses chat.</p>

<div class="card shadow-sm border-0">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h6 class="mb-0">💬 Grup Panitia — Festival Kampus 2025</h6>
        <small class="text-light">Online: 8 anggota</small>
    </div>

    <!-- AREA CHAT -->
    <div class="card-body bg-light" style="height: 450px; overflow-y: auto;">
        <!-- Chat kiri (pesan orang lain) -->
        <div class="d-flex mb-3">
            <div class="flex-shrink-0">
                <img src="https://ui-avatars.com/api/?name=Andi" alt="Andi" class="rounded-circle me-2" width="40" height="40">
            </div>
            <div>
                <div class="bg-white p-3 rounded shadow-sm">
                    <strong>Andi (Publikasi)</strong><br>
                    <span>Teman-teman, besok rapat jam berapa ya?</span>
                </div>
                <small class="text-muted ms-1">19:45</small>
            </div>
        </div>

        <!-- Chat kanan (pesan sendiri) -->
        <div class="d-flex mb-3 justify-content-end">
            <div class="text-end">
                <div class="bg-primary text-white p-3 rounded shadow-sm">
                    <span>Jam 9 pagi, di ruang B205 ya. 🙌</span>
                </div>
                <small class="text-muted">19:46</small>
            </div>
        </div>

        <!-- Chat kiri -->
        <div class="d-flex mb-3">
            <div class="flex-shrink-0">
                <img src="https://ui-avatars.com/api/?name=Bella" alt="Bella" class="rounded-circle me-2" width="40" height="40">
            </div>
            <div>
                <div class="bg-white p-3 rounded shadow-sm">
                    <strong>Bella (Acara)</strong><br>
                    <span>Siap kak! Nanti aku bantu buat rundown-nya.</span>
                </div>
                <small class="text-muted ms-1">19:47</small>
            </div>
        </div>

        <!-- Chat kanan -->
        <div class="d-flex mb-3 justify-content-end">
            <div class="text-end">
                <div class="bg-primary text-white p-3 rounded shadow-sm">
                    <span>Oke, terima kasih Bella 👍</span>
                </div>
                <small class="text-muted">19:48</small>
            </div>
        </div>
    </div>

    <!-- INPUT CHAT -->
    <div class="card-footer bg-white border-top">
        <form class="d-flex">
            <input type="text" class="form-control me-2" placeholder="Ketik pesan...">
            <button type="button" class="btn btn-primary">Kirim</button>
        </form>
    </div>
</div>

<!-- Tombol kembali -->
<div class="text-end mt-3">
    <a href="{{ route('siswa.panitia-detail') }}" class="btn btn-outline-secondary">⬅️ Kembali ke Detail Acara</a>
</div>

@endsection
