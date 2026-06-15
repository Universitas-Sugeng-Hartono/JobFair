<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Participant;

class AttendanceController extends Controller
{
    /**
     * Display the attendance scanner view.
     */
    public function index()
    {
        $companies = \App\Models\Company::with('positions')->orderBy('name')->get();
        return view('admin.attendance.index', compact('companies'));
    }

    /**
     * Return JSON data of all attendees for realtime table updates.
     */
    public function data(Request $request)
    {
        $query = Participant::whereNotNull('attended_at');

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

        $attendees = $query->orderBy('attended_at', 'desc')->get();
        return response()->json($attendees);
    }

    /**
     * Process a scanned NIK and mark the participant as present.
     */
    public function scan(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16'
        ]);

        $participant = Participant::where('nik', $request->nik)->first();

        if (!$participant) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta dengan NIK ' . $request->nik . ' tidak terdaftar.'
            ], 404);
        }

        if ($participant->applications()->count() === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta ' . $participant->name . ' belum melamar ke lowongan manapun. Wajib melamar minimal 1 posisi sebelum presensi.'
            ], 400);
        }

        if ($participant->attended_at) {
            return response()->json([
                'success' => false,
                'message' => 'Peserta ' . $participant->name . ' sudah ditandai hadir sebelumnya pada ' . $participant->attended_at->format('d/m/Y H:i:s') . '.'
            ], 400);
        }

        $participant->attended_at = now();
        $participant->save();

        return response()->json([
            'success' => true,
            'message' => 'Peserta ' . $participant->name . ' berhasil ditandai hadir!'
        ]);
    }
}
