<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PanitiaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('tryLogin');
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('siswa')->middleware(['auth', 'check-role:student'])->group(function () {
    Route::get('/dashboard', [PanitiaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/profile', [PanitiaController::class, 'profile'])->name('siswa.profile');
    Route::get('/daftar-acara', [PanitiaController::class, 'daftarAcara'])->name('siswa.daftar-acara');
    Route::get('/form-pendaftaran', [PanitiaController::class, 'formPendaftaran'])->name('siswa.form-pendaftaran');
    Route::get('/status-pendaftaran', [PanitiaController::class, 'statusPendaftaran'])->name('siswa.status-pendaftaran');
    Route::get('/status-proposal', [PanitiaController::class, 'statusProposal'])->name('siswa.status-proposal');
    Route::get('/proposal-ajukan', [PanitiaController::class, 'proposalAjukan'])->name('siswa.proposal-ajukan');

    // Panitia (umum)
    Route::get('/panitia/dashboard/', [PanitiaController::class, 'panitiaDashboard'])->name('siswa.panitia-dashboard');
    Route::get('/panitia/detail/{activityCode}', [PanitiaController::class, 'panitiaDetail'])->name('siswa.panitia-detail');
    Route::get('/panitia/chat/', [PanitiaController::class, 'panitiaChat'])->name('siswa.panitia-chat');
    Route::get('/panitia/pengurus/{activityCode}', [PanitiaController::class, 'panitiaPengurus'])->name('siswa.panitia-pengurus');
    Route::get('/panitia/jadwal/', [PanitiaController::class, 'panitiaJadwal'])->name('siswa.panitia-jadwal');
    Route::get('/panitia/task/', [PanitiaController::class, 'panitiaTask'])->name('siswa.panitia-task');
    Route::post('/panitia/saveEvaluasi/{activityCode}', [PanitiaController::class, 'saveEvaluasi'])->name('siswa.panitia-save-evaluasi');
    Route::post('/panitia/simpan-grading/{activityCode}', [PanitiaController::class, 'saveGrading'])
    ->name('siswa.panitia-save-grading');
    Route::post('/panitia/update-status/{activityCode}', [PanitiaController::class, 'updateStatus'])
    ->name('siswa.panitia-update-status');
    

    // Riwayat umum
    Route::get('/riwayat/acara', [PanitiaController::class, 'riwayatAcara'])->name('siswa.riwayat-acara');
});

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'check-role:admin'])->group(function () {
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
Route::prefix('dosen')->middleware(['auth', 'check-role:lecturer'])->group(function () {
    Route::view('/dashboard', 'dosen.dashboard')->name('dosen.dashboard');
    Route::view('/laporan-kpi', 'dosen.laporan-kpi')->name('dosen.laporan-kpi');
});

