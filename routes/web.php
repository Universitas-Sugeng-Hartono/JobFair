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

Route::get('/admin/login', function () {
    return view('admin.login');
});

Route::get('/admin', function () {
    $totalCompanies = \App\Models\Company::count();
    $totalParticipants = \App\Models\Participant::count();
    $totalApplications = \App\Models\Application::count();
    $pendingApplications = \App\Models\Application::where('status', 'submitted')->count();
    
    $recentCompanies = \App\Models\Company::with('positions')->withCount('applications')
        ->latest()
        ->take(4)
        ->get();

    $recentActivities = \App\Models\Application::with(['participant', 'position.company'])
        ->latest()
        ->take(5)
        ->get();

    return view('admin.dashboard', compact(
        'totalCompanies',
        'totalParticipants',
        'totalApplications',
        'pendingApplications',
        'recentCompanies',
        'recentActivities'
    ));
});

Route::resource('admin/companies', CompanyController::class);
Route::resource('admin/positions', \App\Http\Controllers\Admin\PositionController::class);
Route::resource('admin/participants', \App\Http\Controllers\Admin\ParticipantController::class);

// Admin Export
Route::get('admin/export', [\App\Http\Controllers\Admin\ExportController::class, 'index'])->name('export.index');
Route::post('admin/export/company', [\App\Http\Controllers\Admin\ExportController::class, 'exportCompany'])->name('export.company');

// Admin Profile & Settings
Route::get('admin/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('admin.profile');
Route::put('admin/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');
Route::get('admin/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
Route::put('admin/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

// Participant routes
Route::get('/peserta', [ParticipantController::class, 'index'])->name('participant.index');
Route::get('/peserta/perusahaan/{id}', [ParticipantController::class, 'showCompany'])->name('participant.company.show');
Route::post('/peserta/nik', [ParticipantController::class, 'setNik'])->name('participant.set-nik');
Route::post('/peserta/keluar', [ParticipantController::class, 'clearNik'])->name('participant.clear-nik');
Route::get('/peserta/apply/{position_id}', [ParticipantController::class, 'apply'])->name('participant.apply');
Route::get('/peserta/riwayat', [ParticipantController::class, 'history'])->name('participant.history');
// Application submit
Route::post('/apply', [ApplicationController::class, 'store'])->name('application.store');
