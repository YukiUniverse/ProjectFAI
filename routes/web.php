<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'login')->name('login');
Route::view('/login', 'login')->name('login.page');

Route::prefix('siswa')->group(function () {
    // Tahap siswa umum
    Route::view('/dashboard', 'siswa.dashboard')->name('siswa.dashboard');
    Route::view('/daftar-acara', 'siswa.daftar-acara')->name('siswa.daftar-acara');
    Route::view('/form-pendaftaran', 'siswa.form-pendaftaran')->name('siswa.form-pendaftaran');
    Route::view('/status-pendaftaran', 'siswa.status-pendaftaran')->name('siswa.status-pendaftaran');
    Route::view('/status-proposal', 'siswa.status-proposal')->name('siswa.status-proposal');
    Route::view('/proposal-ajukan', 'siswa.proposal-ajukan')->name('siswa.proposal-ajukan');


    // Panitia (umum)
    Route::view('/panitia-dashboard', 'siswa.panitia-dashboard')->name('siswa.panitia-dashboard');
    Route::view('/panitia-detail', 'siswa.panitia-detail')->name('siswa.panitia-detail');
    Route::view('/panitia-jadwal', 'siswa.panitia-jadwal')->name('siswa.panitia-jadwal');
    Route::view('/panitia-task', 'siswa.panitia-task')->name('siswa.panitia-task');

    // Riwayat umum
    Route::view('/riwayat-acara', 'siswa.riwayat-acara')->name('siswa.riwayat-acara');

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

