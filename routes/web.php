<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailInviteController;
use App\Http\Controllers\OpenRecruitmentController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::get('/dummy', [LoginController::class, 'dataDummy'])->name('dummy');
Route::post('/login', [LoginController::class, 'login'])->name('tryLogin');
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::prefix('siswa')->middleware(['auth', 'check-role:student'])->group(function () {
    Route::get('/dashboard', [PanitiaController::class, 'dashboard'])->name('siswa.dashboard');
    Route::get('/profile', [PanitiaController::class, 'profile'])->name('siswa.profile');
    Route::get('/daftar-acara', [PanitiaController::class, 'daftarAcara'])->name('siswa.daftar-acara');
    Route::get('/form-pendaftaran/{studentActivityId}', [PanitiaController::class, 'formPendaftaran'])->name('siswa.form-pendaftaran');
    Route::post('/form-pendaftaran/{studentActivityId}', [PanitiaController::class, 'daftarKepanitiaan'])->name('siswa.daftar');
    Route::get('/status-pendaftaran', [PanitiaController::class, 'statusPendaftaran'])->name('siswa.status-pendaftaran');
    Route::get('/status-proposal', [PanitiaController::class, 'statusProposal'])->name('siswa.status-proposal');
    Route::get('/proposal-ajukan', [PanitiaController::class, 'proposalAjukan'])->name('siswa.proposal-ajukan');

    // Panitia (umum)

    Route::get('/panitia/dashboard/', [PanitiaController::class, 'panitiaDashboard'])->name('siswa.panitia-dashboard');
    // Oprec
    Route::get('/panitia/pendaftar/{activityCode}', [OpenRecruitmentController::class, 'panitiaPendaftar'])->name('siswa.panitia-pendaftar');
    Route::get('/panitia/pendaftar/{activityCode}/detail/{registrationID}', [OpenRecruitmentController::class, 'detailPendaftar'])->name('siswa.detail-pendaftar');
    Route::post('/panitia/pendaftar/{activityCode}/detail/{registrationID}/storeDecision', [OpenRecruitmentController::class, 'storeInterviewerDecision'])->name('siswa.store-decision');
    Route::post('/panitia/pendaftar/{activityCode}/detail/{registrationID}/storeFinalDecision', [OpenRecruitmentController::class, 'storeFinalDecision'])->name('siswa.store-decision-akhir');
    // Route to show the interview page
    Route::get('/panitia/pendaftar/{activityCode}/detail/{registrationId}/interview', [OpenRecruitmentController::class, 'showInterview'])->name('siswa.showInterview');
    // Route to save the answers
    Route::post('/panitia/pendaftar/{activityCode}/detail/{registrationId}/interview', [OpenRecruitmentController::class, 'storeInterview'])->name('siswa.storeInterview');



    Route::get('/panitia/detail/{activityCode}', [PanitiaController::class, 'panitiaDetail'])->name('siswa.panitia-detail');
    Route::get('/panitia/chat/', [PanitiaController::class, 'panitiaChat'])->name('siswa.panitia-chat');
    Route::get('/panitia/pengurus/{activityCode}', [PanitiaController::class, 'panitiaPengurus'])->name('siswa.panitia-pengurus');
    Route::post('/panitia/pengurus/pertanyaan/{activityCode}', [PanitiaController::class, 'tambahPertanyaan'])->name('siswa.tambah-pertanyaan');
    Route::get('/panitia/jadwal/', [PanitiaController::class, 'panitiaJadwal'])->name('siswa.panitia-jadwal');

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

    Route::get('/invitations', [MailInviteController::class, 'index'])->name('siswa.invites.index');
    Route::post('/invitations/{id}', [MailInviteController::class, 'respond'])->name('siswa.invites.respond');
    // Route untuk mencari mahasiswa berdasarkan NIM (AJAX)
    Route::get('/api/search-student', [MailInviteController::class, 'searchStudent'])
    ->name('api.search-student');
    // Route untuk Simpan Divisi Baru
    Route::post('/panitia/subrole-store/{activityCode}', [PanitiaController::class, 'storeSubRole'])
    ->name('siswa.panitia-subrole-store');

// Route untuk menyimpan undangan (Invite)
    Route::post('/panitia/invite-member/{activityCode}', [MailInviteController::class, 'storeInvite'])
    ->name('siswa.panitia-invite');
    // Route untuk Update Divisi (Edit)
    Route::put('/panitia/subrole-update/{id}', [PanitiaController::class, 'updateDivision'])
    ->name('siswa.panitia-subrole-update');
    Route::delete('/panitia/subrole-delete/{id}', [PanitiaController::class, 'deleteDivision'])
    ->name('siswa.panitia-subrole-delete');
    Route::delete('/panitia/kick/{structureId}', [PanitiaController::class, 'kickMember'])
    ->name('siswa.panitia-kick');
});

/*
|--------------------------------------------------------------------------
| ROUTE ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'check-role:admin'])->prefix('admin')->name('admin.')->group(function () {
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

/*
|--------------------------------------------------------------------------
| ROUTE DOSEN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'check-role:lecturer'])->prefix('dosen')->name('dosen.')->group(function () {
       Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');
    Route::get('/laporan-kpi', [DosenController::class, 'laporanKpi'])->name('laporan-kpi');

    Route::get('/laporan-acara', [DosenController::class, 'laporanAcara'])->name('laporan-acara');
    Route::get('/laporan-acara/{id}', [DosenController::class, 'laporanAcaraDetail'])->name('laporan-acara-detail');
    
    Route::get('/laporan-mahasiswa', [DosenController::class, 'laporanMahasiswa'])->name('laporan-mahasiswa');
    Route::get('/laporan-mahasiswa/{id}', [DosenController::class, 'laporanMahasiswaDetail'])->name('laporan-mahasiswa-detail');
});

