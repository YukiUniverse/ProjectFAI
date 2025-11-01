<?php

use App\Http\Controllers\PanitiaController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'login')->name('login');
Route::view('/login', 'login')->name('login.page');

Route::prefix('siswa')->group(function () {
    Route::get('/dashboard', [PanitiaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/profile', [PanitiaController::class, 'profile'])->name('siswa.profile');
    Route::get('/daftar-acara', [PanitiaController::class, 'daftarAcara'])->name('siswa.daftar-acara');
    Route::get('/form-pendaftaran', [PanitiaController::class, 'formPendaftaran'])->name('siswa.form-pendaftaran');
    Route::get('/status-pendaftaran', [PanitiaController::class, 'statusPendaftaran'])->name('siswa.status-pendaftaran');
    Route::get('/status-proposal', [PanitiaController::class, 'statusProposal'])->name('siswa.status-proposal');
    Route::get('/proposal-ajukan', [PanitiaController::class, 'proposalAjukan'])->name('siswa.proposal-ajukan');

    // Panitia (umum)
    Route::get('/panitia/dashboard/', [PanitiaController::class, 'panitiaDashboard'])->name('siswa.panitia-dashboard');
    Route::get('/panitia/detail/', [PanitiaController::class, 'panitiaDetail'])->name('siswa.panitia-detail');
    Route::get('/panitia/chat/', [PanitiaController::class, 'panitiaChat'])->name('siswa.panitia-chat');
    Route::get('/panitia/pengurus/', [PanitiaController::class, 'panitiaPengurus'])->name('siswa.panitia-pengurus');
    Route::get('/panitia/jadwal/', [PanitiaController::class, 'panitiaJadwal'])->name('siswa.panitia-jadwal');
    Route::get('/panitia/task/', [PanitiaController::class, 'panitiaTask'])->name('siswa.panitia-task');

    // Riwayat umum
    Route::get('/riwayat/acara', [PanitiaController::class, 'riwayatAcara'])->name('siswa.riwayat-acara');
});

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/acara', 'admin.acara-list')->name('admin.acara-list');
    Route::view('/proposal', 'admin.proposal-list')->name('admin.proposal-list');
    Route::view('/laporan', 'admin.laporan')->name('admin.laporan');
    Route::view('/laporan/{acara}', 'admin.laporan-detail')->name('admin.laporan-detail');
    Route::view('/acara/{acara}/panitia', 'admin.panitia-acara-detail')->name('admin.panitia-acara-detail');
});

/*
|--------------------------------------------------------------------------
| ROUTE DOSEN
|--------------------------------------------------------------------------
*/
Route::prefix('dosen')->group(function () {
    Route::view('/dashboard', 'dosen.dashboard')->name('dosen.dashboard');
    Route::view('/laporan-kpi', 'dosen.laporan-kpi')->name('dosen.laporan-kpi');
});

