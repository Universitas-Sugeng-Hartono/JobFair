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
        return view('admin.attendance.index');
    }

    /**
     * Return JSON data of all attendees for realtime table updates.
     */
    public function data()
    {
        $attendees = Participant::whereNotNull('attended_at')
                        ->orderBy('attended_at', 'desc')
                        ->get();
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
