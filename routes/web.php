<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FormPengajuanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\NotificationController;


// Public routes
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::get('/pengajuanmahasiswa', [FormPengajuanController::class, 'pengajuanmahasiswa'])->name('pengajuanmahasiswa');
Route::post('/pengajuanmahasiswa', [FormPengajuanController::class, 'store'])->name('pengajuanmahasiswa.store');
Route::get('/pengajuannonmahasiswa', [FormPengajuanController::class, 'pengajuannonmahasiswa'])->name('pengajuannonmahasiswa');
Route::post('/pengajuannonmahasiswa', [FormPengajuanController::class, 'storeNonMahasiswa'])->name('pengajuannonmahasiswa.store');
Route::get('/pantau', [HomeController::class, 'pantau'])->name('pantau');
Route::post('/pantau/cek', [HomeController::class, 'cekStatus'])->name('pantau.cek');
Route::get('/pantau/{no_pengajuan}', [HomeController::class, 'showStatus'])->name('pantau.show');
Route::get('/layanan', [HomeController::class, 'layanan'])->name('layanan');
Route::get('/survei', [HomeController::class, 'survei'])->name('survei');
Route::post('/survei/submit', [HomeController::class, 'submitSurvei'])->name('survei.submit');

// Authentication routes
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Add this route to routes/web.php
// This should be accessible to both admin and staff users

// Common authenticated routes (for both admin and staff)
Route::middleware(['auth'])->group(function () {
    Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    Route::get('/akun', [AdminController::class, 'akun'])->name('akun');
    // User management routes
    Route::post('/akun', [AdminController::class, 'storeUser'])->name('akun.store');
    Route::put('/akun/{id}', [AdminController::class, 'updateUser'])->name('akun.update');
    Route::delete('/akun/{id}', [AdminController::class, 'deleteUser'])->name('akun.delete');
    Route::get('/akun/data', [AdminController::class, 'getUsersData'])->name('akun.data');
    Route::get('/akun/{id}', [AdminController::class, 'getUserById'])->name('akun.show');
    // Data surat routes
    Route::get('/datasurat', [AdminController::class, 'datasurats'])->name('admin.datasurat');
    Route::get('/penerbitan/{id}/download', [AdminController::class, 'downloadDocument'])->name('admin.penerbitan.download');
    Route::get('/penerbitan/{id}/download-file', [AdminController::class, 'downloadUploadedFile'])->name('admin.penerbitan.downloadFile');
     // Add these routes to the admin routes group
Route::get('/dataresponden', [AdminController::class, 'dataresponden'])->name('admin.dataresponden');
Route::delete('/dataresponden/{email}', [AdminController::class, 'deleteRespondenData'])->name('admin.dataresponden.delete');
Route::get('/dataresponden/export', [AdminController::class, 'exportResponden'])->name('admin.dataresponden.export');
    // Add these routes to the admin routes group in routes/web.php
    Route::get('/datasurvei', [AdminController::class, 'datasurvei'])->name('admin.datasurvei');
    Route::post('/datasurvei', [AdminController::class, 'storeSurvei'])->name('admin.datasurvei.store');
    Route::get('/datasurvei/{id}', [AdminController::class, 'getSurveiById'])->name('admin.datasurvei.show');
    Route::put('/datasurvei/{id}', [AdminController::class, 'updateSurvei'])->name('admin.datasurvei.update');
    Route::delete('/datasurvei/{id}', [AdminController::class, 'deleteSurvei'])->name('admin.datasurvei.delete');
    Route::get('/dataresponden/export-pdf', [AdminController::class, 'exportRespondenPdf'])->name('admin.dataresponden.export-pdf');


});

// Staff routes
Route::prefix('staff')->middleware(['auth', 'role:staff'])->group(function () {
    Route::get('/', [StaffController::class, 'index'])->name('staff');
    Route::get('/datapengajuanmahasiswa', [StaffController::class, 'datapengajuanmahasiswa'])->name('datapengajuanmahasiswa');
    Route::put('/datapengajuanmahasiswa/{id}/tolak', [StaffController::class, 'tolakPengajuan'])->name('mahasiswa.tolak');
    Route::put('/datapengajuanmahasiswa/{id}/proses', [StaffController::class, 'prosesKembali'])->name('mahasiswa.proses');
    Route::delete('/datapengajuanmahasiswa/{id}/hapus', [StaffController::class, 'hapusPengajuan'])->name('mahasiswa.hapus');
    Route::get('/penerbitan', [StaffController::class, 'penerbitan'])->name('penerbitan');
    Route::get('/datasurat', [StaffController::class, 'datasurat'])->name('datasurat');
     Route::get('/datapengajuannonmahasiswa', [StaffController::class, 'datapengajuannonmahasiswa'])->name('datapengajuannonmahasiswa');
    Route::put('/datapengajuannonmahasiswa/{id}/tolak', [StaffController::class, 'tolakPengajuanNonMahasiswa'])->name('Non-Mahasiswa.tolak');
    Route::put('/datapengajuannonmahasiswa/{id}/proses', [StaffController::class, 'prosesKembaliNonMahasiswa'])->name('Non-Mahasiswa.proses');
    Route::delete('/datapengajuannonmahasiswa/{id}/hapus', [StaffController::class, 'hapusPengajuanNonMahasiswa'])->name('Non-Mahasiswa.hapus');
    Route::get('/penerbitan/get-mahasiswa', [StaffController::class, 'getMahasiswaData'])->name('penerbitan.getMahasiswa');
    Route::get('/penerbitan/get-non-mahasiswa', [StaffController::class, 'getNonMahasiswaData'])->name('penerbitan.getNonMahasiswa');
    Route::post('/penerbitan/store', [StaffController::class, 'storePenerbitan'])->name('penerbitan.store');
    Route::put('/penerbitan/{id}/update-status', [StaffController::class, 'updateStatus'])->name('penerbitan.updateStatus');
    Route::delete('/penerbitan/{id}', [StaffController::class, 'destroy'])->name('penerbitan.destroy');
    Route::post('/send-whatsapp-notification', [NotificationController::class, 'sendWhatsAppNotification'])->name('send.whatsapp.notification');
    Route::get('/penerbitan/{id}/download', [StaffController::class, 'downloadDocument'])->name('penerbitan.download');
    // Route untuk upload file surat
    Route::post('/penerbitan/{id}/update-file', [StaffController::class, 'updateSuratFile'])->name('penerbitan.updateFile');
    // Route untuk download file yang diupload
    Route::get('/penerbitan/{id}/download-file', [StaffController::class, 'downloadUploadedFile'])->name('penerbitan.downloadFile');
    Route::put('/penerbitan/{id}/update', [StaffController::class, 'updateSurat'])->name('penerbitan.update');
    Route::post('/send-email-notification', [NotificationController::class, 'sendEmailNotification'])->name('send.email.notification');
    Route::post('/send-approval-email-notification', [NotificationController::class, 'sendApprovalEmailNotification'])->name('send.approval.email.notification');
});