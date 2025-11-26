<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('tryLogin');
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('siswa')->middleware(['auth', 'role:student'])->group(function () {
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
    Route::post('/panitia/update-struktur/{activityCode}', [PanitiaController::class, 'updateStructure'])
    ->name('siswa.panitia-update-struktur');
    // Simpan Jadwal (Perlu activityCode untuk tahu ini jadwal acara apa)
    Route::post('/panitia/store-schedule/{activityCode}', [ScheduleController::class, 'store'])->name('siswa.jadwal-store');
    // Halaman Edit
    Route::get('/panitia/edit-schedule/{id}', [ScheduleController::class, 'edit'])->name('siswa.jadwal-edit');
    // Update Data
    Route::put('/panitia/update-schedule/{id}', [ScheduleController::class, 'update'])->name('siswa.jadwal-update');
    // Hapus Data
    Route::delete('/panitia/delete-schedule/{id}', [ScheduleController::class, 'destroy'])->name('siswa.jadwal-delete');
    // Riwayat umum
    Route::get('/riwayat/acara', [PanitiaController::class, 'riwayatAcara'])->name('siswa.riwayat-acara');
});

// ==========================
// 1. GROUP ADMIN
// ==========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

// Proposal
    Route::get('/proposal', [AdminController::class, 'proposalList'])->name('proposal-list');
    Route::post('/proposal/{id}/verify', [AdminController::class, 'verifyProposal'])->name('proposal-verify');

    // Acara
    Route::get('/acara', [AdminController::class, 'acaraList'])->name('acara-list');
    Route::get('/acara/{activityCode}/panitia', [AdminController::class, 'panitiaDetail'])->name('panitia-detail');

    // Laporan 
    Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan'); 
    // Resulting Name: 'admin.laporan' <--- This fixes your error
    
    Route::get('/laporan/detail/{activityCode}', [AdminController::class, 'laporanDetail'])->name('laporan-detail');
    Route::get('/history-pendaftaran', [AdminController::class, 'historyPendaftaran'])->name('history-pendaftaran');
});

// ==========================
// 2. GROUP DOSEN
// ==========================
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
    Route::get('/laporan-kpi', [DosenController::class, 'laporanKpi'])->name('laporan-kpi');
});