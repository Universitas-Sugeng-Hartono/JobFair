<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ApplicationController;

Route::get('/', function () {
    $companies = \App\Models\Company::with('positions')->get();
    $participantCount = \App\Models\Participant::count();
    $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
    return view('welcome', compact('companies', 'participantCount', 'settings'));
});

use App\Http\Controllers\Admin\AuthController;

Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('admin/companies', CompanyController::class);
    Route::resource('admin/positions', \App\Http\Controllers\Admin\PositionController::class);
    Route::resource('admin/participants', \App\Http\Controllers\Admin\ParticipantController::class);
    Route::post('admin/participants/broadcast-attendance', [\App\Http\Controllers\Admin\ParticipantController::class, 'sendAttendanceReminder'])->name('participants.broadcast-attendance');

    // Update application status (accept/reject)
    Route::patch('admin/applications/{application}/status', [\App\Http\Controllers\Admin\ApplicationStatusController::class, 'update'])->name('applications.status');

    // Admin Attendance
    Route::get('admin/attendance', [\App\Http\Controllers\Admin\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('admin/attendance/data', [\App\Http\Controllers\Admin\AttendanceController::class, 'data'])->name('attendance.data');
    Route::post('admin/attendance/scan', [\App\Http\Controllers\Admin\AttendanceController::class, 'scan'])->name('attendance.scan');

    // Admin Export
    Route::get('admin/export', [\App\Http\Controllers\Admin\ExportController::class, 'index'])->name('export.index');
    Route::post('admin/export/company', [\App\Http\Controllers\Admin\ExportController::class, 'exportCompany'])->name('export.company');
    Route::get('admin/export/unapplied', [\App\Http\Controllers\Admin\ExportController::class, 'exportUnappliedParticipants'])->name('export.unapplied');

    // Admin Profile & Settings
    Route::get('admin/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('admin.profile');
    Route::put('admin/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('admin/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::put('admin/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});

// Participant routes
Route::get('/peserta', [ParticipantController::class, 'index'])->name('participant.index');
Route::get('/peserta/perusahaan/{id}', [ParticipantController::class, 'showCompany'])->name('participant.company.show');
Route::post('/peserta/nik', [ParticipantController::class, 'setNik'])->name('participant.set-nik');
Route::post('/peserta/keluar', [ParticipantController::class, 'clearNik'])->name('participant.clear-nik');
Route::get('/peserta/apply/{position_id}', [ParticipantController::class, 'apply'])->name('participant.apply');
Route::get('/peserta/riwayat', [ParticipantController::class, 'history'])->name('participant.history');
Route::post('/peserta/notifikasi/{id}/baca', [ParticipantController::class, 'markNotificationRead'])->name('participant.notification.read');
// Application submit
Route::post('/apply', [ApplicationController::class, 'store'])->name('application.store');

// ─── Company Portal ──────────────────────────────────────────────
use App\Http\Controllers\Company\CompanyPortalController;

Route::get('/perusahaan/login', [CompanyPortalController::class, 'showLogin'])->name('company.login');
Route::post('/perusahaan/login', [CompanyPortalController::class, 'login'])->name('company.login.post');
Route::post('/perusahaan/logout', [CompanyPortalController::class, 'logout'])->name('company.logout');

Route::middleware('auth:company')->group(function () {
    Route::get('/perusahaan/dashboard', [CompanyPortalController::class, 'dashboard'])->name('company.dashboard');
    Route::get('/perusahaan/pelamar', [CompanyPortalController::class, 'applicants'])->name('company.applicants');
    Route::patch('/perusahaan/pelamar/{application}/status', [CompanyPortalController::class, 'updateStatus'])->name('company.applications.status');
});
