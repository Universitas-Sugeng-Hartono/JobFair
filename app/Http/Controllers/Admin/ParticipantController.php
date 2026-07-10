<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\ParticipantNotification;
use App\Models\Setting;

class ParticipantController extends Controller
{
    public function index(Request $request)
    {
        $companies = \App\Models\Company::with('positions')->orderBy('name')->get();

        $query = Participant::withCount([
            'applications',
            'applications as accepted_count' => function ($query) {
                $query->where('status', 'accepted');
            },
            'applications as rejected_count' => function ($query) {
                $query->where('status', 'rejected');
            },
            'applications as submitted_count' => function ($query) {
                $query->where('status', 'submitted');
            },
            'applications as reviewed_count' => function ($query) {
                $query->where('status', 'reviewed');
            }
        ])->latest();

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('nik', 'like', $searchTerm)
                  ->orWhere('name', 'like', $searchTerm);
            });
        }

        if ($request->filled('company_id')) {
            if ($request->filled('position_id')) {
                // Filter by specific position
                $positionId = $request->position_id;
                $query->whereHas('applications', function($q) use ($positionId) {
                    $q->where('position_id', $positionId);
                });
            } else {
                // Filter by any position in the company
                $companyId = $request->company_id;
                $query->whereHas('applications.position', function($q) use ($companyId) {
                    $q->where('company_id', $companyId);
                });
            }
        } elseif ($request->filled('position_id')) {
            // Just position filter without company (fallback)
            $positionId = $request->position_id;
            $query->whereHas('applications', function($q) use ($positionId) {
                $q->where('position_id', $positionId);
            });
        }

        if ($request->has('status') && $request->status !== '') {
            if ($request->status === 'hadir') {
                $query->whereNotNull('attended_at');
            } elseif ($request->status === 'tidak_hadir') {
                $query->whereNull('attended_at');
            } elseif ($request->status === 'diterima') {
                $query->whereHas('applications', function($q) {
                    $q->where('status', 'accepted');
                });
            } elseif ($request->status === 'ditolak') {
                $query->whereHas('applications', function($q) {
                    $q->where('status', 'rejected');
                });
            }
        }

        $participants = $query->paginate(10)->appends($request->query());
        return view('admin.participants.index', compact('participants', 'companies'));
    }

  
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    
    public function show(string $id)
    {
        $participant = Participant::with('applications.position.company')->findOrFail($id);
        return view('admin.participants.show', compact('participant'));
    }

 
    public function edit(string $id)
    {
        //
    }

   
    public function update(Request $request, string $id)
    {
        //
    }

 
    public function destroy(string $id)
    {
        $participant = Participant::findOrFail($id);
        $participant->delete();
        
        return redirect()->route('participants.index')->with('success', 'Peserta berhasil dihapus');
    }

    public function sendAttendanceReminder(Request $request)
    {
        $settings = Setting::pluck('value', 'key');
        $eventTime = $settings['event_time'] ?? '08.00 WIB - Selesai';
        $eventLocation = $settings['event_location'] ?? 'Lokasi JobFair';

        $title = 'Pengingat Kehadiran JobFair';
        $message = "Peringatan: Harap hadir pada sesi JobFair pada hari Jum'at, tanggal 10 Juli 2026.\n\nWaktu: {$eventTime}\nLokasi: {$eventLocation}";

        $participants = Participant::all();
        $count = 0;

        foreach ($participants as $participant) {
            ParticipantNotification::create([
                'participant_id' => $participant->id,
                'title' => $title,
                'message' => $message,
                'type' => 'attendance_reminder',
            ]);
            $count++;
        }

        return redirect()->route('participants.index')
            ->with('success', "Notifikasi kehadiran berhasil dikirim ke {$count} peserta.");
    }

    public function attendAll(Request $request)
    {
        $updatedCount = Participant::whereNull('attended_at')->update(['attended_at' => now()]);

        return redirect()->route('participants.index')
            ->with('success', "Semua peserta berhasil ditandai hadir ({$updatedCount} peserta). ");
    }
}
