<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participant;

class ParticipantController extends Controller
{
   
    public function index()
    {
        $participants = Participant::withCount('applications')->latest()->paginate(10);
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
