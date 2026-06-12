<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participant;

class ParticipantController extends Controller
{
   
    public function index(Request $request)
    {
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
            }
        ])->latest();

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
        return view('admin.participants.index', compact('participants'));
    }

  
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
    }

    
    public function show(string $id)
    {
        $participant = Participant::with('applications.position.company', 'applications.answers')->findOrFail($id);
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
}
