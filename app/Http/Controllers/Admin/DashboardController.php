<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCompanies = \App\Models\Company::count();
        $totalParticipants = \App\Models\Participant::count();
        $totalParticipantsInternal = \App\Models\Participant::where('participant_type', 'Mahasiswa/Alumni USH')->count();
        $totalParticipantsExternal = \App\Models\Participant::where('participant_type', '!=', 'Mahasiswa/Alumni USH')->count();
        
        $totalApplications = \App\Models\Application::whereNotNull('answers_payload')
            ->where('answers_payload', 'like', '%"type":"file"%')
            ->where('answers_payload', 'not like', '%"path":"-"%')
            ->where('answers_payload', 'like', '%"path":"%')
            ->count();
        
        $totalAttended = \App\Models\Participant::whereNotNull('attended_at')->count();
        $totalAttendedInternal = \App\Models\Participant::whereNotNull('attended_at')
            ->where('participant_type', 'Mahasiswa/Alumni USH')->count();
        $totalAttendedExternal = \App\Models\Participant::whereNotNull('attended_at')
            ->where('participant_type', '!=', 'Mahasiswa/Alumni USH')->count();
            
        $pendingApplications = \App\Models\Application::where('status', 'submitted')->count();
        
        $recentCompanies = \App\Models\Company::with('positions')->withCount('applications')
            ->latest()
            ->take(4)
            ->get();

        $recentActivities = \App\Models\Application::with(['participant', 'position.company'])
            ->latest()
            ->take(5)
            ->get();

        // Chart data: applications per company (only attended participants)
        $companiesChart = \App\Models\Company::withCount([
            'applications as attended_applications_count' => function ($q) {
                $q->whereIn('status', ['reviewed', 'accepted', 'rejected']);
            },
            'applications as accepted_internal_count' => function ($q) {
                $q->where('status', 'accepted')
                  ->whereHas('participant', fn($p) => $p->whereNotNull('attended_at')->where('participant_type', 'Mahasiswa/Alumni USH'));
            },
            'applications as accepted_external_count' => function ($q) {
                $q->where('status', 'accepted')
                  ->whereHas('participant', fn($p) => $p->whereNotNull('attended_at')->where('participant_type', '!=', 'Mahasiswa/Alumni USH'));
            }
        ])->get();
        $companyLabels = $companiesChart->pluck('name')->toArray();
        $companyApplicationCounts = $companiesChart->pluck('attended_applications_count')->toArray();

        // Absorption rate: peserta hadir yang min 1 lamarannya diterima
        $totalAbsorbedInternal = \App\Models\Participant::whereNotNull('attended_at')
            ->where('participant_type', 'Mahasiswa/Alumni USH')
            ->whereHas('applications', fn($q) => $q->where('status', 'accepted'))
            ->count();
            
        $totalAbsorbedExternal = \App\Models\Participant::whereNotNull('attended_at')
            ->where('participant_type', '!=', 'Mahasiswa/Alumni USH')
            ->whereHas('applications', fn($q) => $q->where('status', 'accepted'))
            ->count();
            
        $totalAbsorbed = $totalAbsorbedInternal + $totalAbsorbedExternal;
        $companyAcceptedInternalCounts = $companiesChart->pluck('accepted_internal_count')->toArray();
        $companyAcceptedExternalCounts = $companiesChart->pluck('accepted_external_count')->toArray();

        $eventStatus = Setting::where('key', 'event_status')->value('value') ?? 'open';

        return view('admin.dashboard', compact(
            'totalCompanies',
            'totalParticipants',
            'totalParticipantsInternal',
            'totalParticipantsExternal',
            'totalApplications',
            'totalAttended',
            'totalAttendedInternal',
            'totalAttendedExternal',
            'totalAbsorbed',
            'totalAbsorbedInternal',
            'totalAbsorbedExternal',
            'pendingApplications',
            'recentCompanies',
            'recentActivities',
            'companyLabels',
            'companyApplicationCounts',
            'companyAcceptedInternalCounts',
            'companyAcceptedExternalCounts',
            'eventStatus'
        ));
    }

    public function updateEventStatus(Request $request)
    {
        $request->validate([
            'status' => 'required|in:open,closed',
        ]);

        Setting::updateOrCreate(
            ['key' => 'event_status'],
            ['value' => $request->status]
        );

        $message = $request->status === 'closed'
            ? 'Job Fair 2026 telah ditandai selesai. Login partisipan dan aktivitas lamaran akan ditolak.'
            : 'Job Fair 2026 telah dimulai kembali. Login partisipan dan lamaran sekarang dibuka.';

        return redirect()->route('admin.dashboard')->with('success', $message);
    }
}
