<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailInviteController;
use App\Http\Controllers\OpenRecruitmentController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return   redirect()->route('login');
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
    Route::post('/store-proposal', [PanitiaController::class, 'storeProposal'])->name('siswa.proposal-store');

    // Panitia (umum)

    Route::get('/panitia/dashboard/', [PanitiaController::class, 'panitiaDashboard'])->name('siswa.panitia-dashboard');
    Route::get('/panitia/interview/', [PanitiaController::class, 'panitiaDashboardInterview'])->name('siswa.panitia-dashboard-interview');
    // Oprec
    Route::get('/panitia/pendaftar/{activityCode}', [OpenRecruitmentController::class, 'panitiaPendaftar'])->name('siswa.panitia-pendaftar')->middleware('mode-bph');
    Route::get('/panitia/pendaftar/{activityCode}/detail/{registrationID}', [OpenRecruitmentController::class, 'detailPendaftar'])->name('siswa.detail-pendaftar')->middleware('mode-bph');
    Route::post('/panitia/pendaftar/{activityCode}/detail/{registrationID}/storeDecision', [OpenRecruitmentController::class, 'storeInterviewerDecision'])->name('siswa.store-decision')->middleware('mode-bph');
    Route::post('/panitia/pendaftar/{activityCode}/detail/{registrationID}/storeFinalDecision', [OpenRecruitmentController::class, 'storeFinalDecision'])->name('siswa.store-decision-akhir')->middleware('mode-bph');

    // Route to show the interview page
    Route::get('/panitia/pendaftar/{activityCode}/detail/{registrationId}/interview', [OpenRecruitmentController::class, 'showInterview'])->name('siswa.showInterview')->middleware('mode-bph');
    // Route to save the answers
    Route::post('/panitia/pendaftar/{activityCode}/detail/{registrationId}/interview', [OpenRecruitmentController::class, 'storeInterview'])->name('siswa.storeInterview')->middleware('mode-bph');

    Route::get('/panitia/detail/{activityCode}', [PanitiaController::class, 'panitiaDetail'])->name('siswa.panitia-detail')->middleware('mode-panitia');
    Route::get('/panitia/pengurus/{activityCode}', [PanitiaController::class, 'panitiaPengurus'])->name('siswa.panitia-pengurus')->middleware('mode-bph');
    Route::get('/panitia/pengurus-excel/{activityCode}', [ExcelController::class, 'exportExcelAnggota'])->name('siswa.export_excel')->middleware('mode-bph');
    Route::post('/panitia/pengurus/pertanyaan/{activityCode}', [PanitiaController::class, 'tambahPertanyaan'])->name('siswa.tambah-pertanyaan')->middleware('mode-bph');
    Route::get('/panitia/jadwal/', [PanitiaController::class, 'panitiaJadwal'])->name('siswa.panitia-jadwal')->middleware('mode-panitia');
    Route::put('/panitia/{activityCode}/interview', [PanitiaController::class, 'updateInterviewDate'])
    ->name('student_activities.update_interview')->middleware('mode-ketua');

    Route::post('/panitia/saveEvaluasi/{activityCode}', [PanitiaController::class, 'saveEvaluasi'])->name('siswa.panitia-save-evaluasi')->middleware('mode-panitia');
    Route::post('/panitia/simpan-grading/{activityCode}', [PanitiaController::class, 'saveGrading'])
        ->name('siswa.panitia-save-grading')->middleware('mode-ketua');
    Route::post('/panitia/update-status/{activityCode}', [PanitiaController::class, 'updateStatus'])
        ->name('siswa.panitia-update-status')->middleware('mode-ketua');
    Route::post('/panitia/update-struktur/{activityCode}', [PanitiaController::class, 'updateStructure'])
        ->name('siswa.panitia-update-struktur')->middleware('mode-ketua');
    // Simpan Jadwal (Perlu activityCode untuk tahu ini jadwal acara apa)
    Route::post('/panitia/store-schedule/{activityCode}', [ScheduleController::class, 'store'])->name('siswa.jadwal-store')->middleware('mode-bph');
    // Halaman Edit
    Route::get('/panitia/edit-schedule/{id}/{activityCode}', [ScheduleController::class, 'edit'])->name('siswa.jadwal-edit')->middleware('mode-bph');
    // Update Data
    Route::put('/panitia/update-schedule/{id}/{activityCode}', [ScheduleController::class, 'update'])->name('siswa.jadwal-update')->middleware('mode-bph');
    // Hapus Data
    Route::delete('/panitia/delete-schedule/{id}/{activityCode}', [ScheduleController::class, 'destroy'])->name('siswa.jadwal-delete')->middleware('mode-bph');
    // Riwayat umum
    Route::get('/riwayat/acara', [PanitiaController::class, 'riwayatAcara'])->name('siswa.riwayat-acara');
    Route::get('/activity/{activityCode}/members', [PanitiaController::class, 'showMembers'])->name('activity.members');
    Route::get('/activity/{activityCode}/export', [ExcelController::class, 'exportExcel'])->name('activity.export_excel')->middleware('mode-bph');

    Route::get('/invitations', [MailInviteController::class, 'index'])->name('siswa.invites.index');
    Route::post('/invitations/{id}', [MailInviteController::class, 'respond'])->name('siswa.invites.respond');
    // Route untuk mencari mahasiswa berdasarkan NIM (AJAX)
    Route::get('/api/search-student', [MailInviteController::class, 'searchStudent'])
        ->name('api.search-student');
    // Route Tambah Divisi ke Acara (Pilih dari Master)
    Route::post('/panitia/divisi-add/{activityCode}', [PanitiaController::class, 'storeActivitySubRole'])
        ->name('siswa.panitia-divisi-add')->middleware('mode-bph');


    // Route untuk menyimpan undangan (Invite)
    Route::post('/panitia/invite-member/{activityCode}', [MailInviteController::class, 'storeInvite'])
        ->name('siswa.panitia-invite')->middleware('mode-ketua');
    // Route Hapus Divisi dari Acara
    Route::delete('/panitia/divisi-delete/{id}/{activityCode}', [PanitiaController::class, 'deleteActivitySubRole'])
        ->name('siswa.panitia-divisi-delete')->middleware('mode-ketua');
    Route::delete('/panitia/kick/{structureId}/{activityCode}', [PanitiaController::class, 'kickMember'])
        ->name('siswa.panitia-kick')->middleware('mode-ketua');


});
// ==========================
// 1. GROUP ADMIN
// ==========================
Route::middleware(['auth', 'check-role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Proposal
    Route::get('/proposal', [AdminController::class, 'proposalList'])->name('proposal-list');
    Route::patch('/proposals/{id}/approve', [AdminController::class, 'approve'])->name('proposals.approve');
    Route::patch('/proposals/{id}/reject', [AdminController::class, 'reject'])->name('proposals.reject');
    Route::post('/proposal/{id}/verify', [AdminController::class, 'verifyProposal'])->name('proposal-verify');

    // Acara (Gabungan Daftar & Laporan Acara)
    Route::get('/acara', [AdminController::class, 'acaraList'])->name('acara-list');
    Route::get('/acara/{activityCode}/detail', [AdminController::class, 'panitiaDetail'])->name('panitia-detail');

    // Laporan Mahasiswa (BARU)
    Route::get('/laporan-mahasiswa', [AdminController::class, 'laporanMahasiswa'])->name('laporan-mahasiswa');
    
    // History Global
    Route::get('/history-pendaftaran', [AdminController::class, 'historyPendaftaran'])->name('history-pendaftaran');
});

// ==========================
// 2. GROUP DOSEN
// ==========================
Route::middleware(['auth', 'check-role:lecturer'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dashboard');

    // Laporan Acara (Dibedakan Finish/Ongoing di View)
    Route::get('/laporan-acara', [DosenController::class, 'laporanAcara'])->name('laporan-acara');
    Route::get('/laporan-acara/{id}', [DosenController::class, 'laporanAcaraDetail'])->name('laporan-acara-detail');
    
    // Laporan Mahasiswa (Gabungan dengan KPI)
    Route::get('/laporan-mahasiswa', [DosenController::class, 'laporanMahasiswa'])->name('laporan-mahasiswa');
    Route::get('/laporan-mahasiswa/{id}', [DosenController::class, 'laporanMahasiswaDetail'])->name('laporan-mahasiswa-detail');
});