<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Participant;
use App\Models\Application;
use App\Models\Setting;

class ParticipantController extends Controller
{
    private function isEventClosed(): bool
    {
        return Setting::where('key', 'event_status')->value('value') === 'closed';
    }
    public function index(Request $request)
    {
        $companies = Company::with('positions')->get();

        // Cek NIK dari session
        $nik = session('participant_nik');
        $participant = null;
        $appliedPositionIds = [];

        if ($nik) {
            $participant = Participant::where('nik', $nik)->first();
            if ($participant) {
                $appliedPositionIds = $participant->applications()->pluck('position_id')->toArray();
            }
        }

        $settings = Setting::pluck('value', 'key')->toArray();

        return view('participant.index', compact('companies', 'participant', 'appliedPositionIds', 'nik', 'settings'));
    }

    public function showCompany($id)
    {
        $company = Company::findOrFail($id);
        $companyPositions = $company->positions;
        
        $nik = session('participant_nik');
        $participant = null;
        $appliedPositionIds = [];
        $alreadyAppliedToThisCompany = false;

        if ($nik) {
            $participant = Participant::where('nik', $nik)->first();
            if ($participant) {
                $appliedPositionIds = Application::where('participant_id', $participant->id)
                                                ->pluck('position_id')->toArray();

                // Cek apakah peserta sudah melamar SALAH SATU posisi di perusahaan ini
                $alreadyAppliedToThisCompany = Application::where('participant_id', $participant->id)
                    ->whereIn('position_id', $company->positions->pluck('id'))
                    ->exists();
            }
        }

        $settings = Setting::pluck('value', 'key')->toArray();

        return view('participant.company', compact(
            'company', 'companyPositions', 'participant',
            'appliedPositionIds', 'alreadyAppliedToThisCompany', 'nik', 'settings'
        ));
    }

    public function apply($position_id)
    {
        if ($this->isEventClosed()) {
            return redirect()->route('participant.index')
                ->with('error', 'Mohon Maaf Job Fair 2026 telah selesai, Sampai Jumpa di Job Fair Selanjutnya');
        }

        $position = \App\Models\Position::with('company')->findOrFail($position_id);
        
        $nik = session('participant_nik');
        if (!$nik) {
            return redirect()->route('participant.company.show', $position->company_id)->with('error', 'Anda harus login dengan NIK terlebih dahulu.');
        }

        $participant = Participant::where('nik', $nik)->first();
        if (!$participant) {
            session()->forget(['participant_nik', 'participant_name']);
            return redirect()->route('participant.index')->withErrors(['nik' => 'Sesi tidak valid.']);
        }

        $isApplied = Application::where('participant_id', $participant->id)
            ->where('position_id', $position->id)
            ->exists();

        if ($isApplied) {
            return redirect()->route('participant.company.show', $position->company_id)
                ->with('error', 'Anda sudah pernah melamar posisi ini.');
        }

        $settings = Setting::pluck('value', 'key')->toArray();

        return view('participant.apply', compact('position', 'participant', 'nik', 'settings'));
    }

    public function setNik(Request $request)
    {
        if ($this->isEventClosed()) {
            return back()->withErrors(['nik' => 'Mohon Maaf Job Fair 2026 telah selesai, Sampai Jumpa di Job Fair Selanjutnya']);
        }

        // Validasi format dasar
        $request->validate([
            'nik'  => 'required|digits:16',
            'name' => 'required|string|min:3|max:255',
            'participant_type' => 'required|in:Mahasiswa/Alumni USH,Umum',
        ], [
            'nik.required'  => 'NIK wajib diisi.',
            'nik.digits'    => 'NIK harus tepat 16 digit angka.',
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min'      => 'Nama minimal 3 karakter.',
            'participant_type.required' => 'Kategori peserta wajib dipilih.',
            'participant_type.in' => 'Kategori peserta tidak valid.',
        ]);

        $nik  = $request->nik;
        $name = trim($request->name);
        $participantType = $request->participant_type;

        // Cek apakah NIK sudah terdaftar
        $existingByNik = Participant::where('nik', $nik)->first();

        if ($existingByNik) {
            // NIK sudah ada — pastikan nama cocok (case-insensitive)
            if (strtolower($existingByNik->name) !== strtolower($name)) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'nik' => 'NIK ini sudah terdaftar dengan nama yang berbeda. Pastikan nama Anda sesuai dengan pendaftaran awal.',
                    ]);
            }

            // NIK & nama cocok → lanjutkan login
            session([
                'participant_nik'  => $nik,
                'participant_name' => $existingByNik->name,
            ]);

            return redirect()->route('participant.index')
                ->with('success', 'Selamat datang kembali, ' . $existingByNik->name . '!');
        }

        // NIK belum ada — cek apakah NAMA sudah dipakai NIK lain
        $existingByName = Participant::whereRaw('LOWER(name) = ?', [strtolower($name)])->first();

        if ($existingByName) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'Nama ini sudah terdaftar dengan NIK yang berbeda. Gunakan nama sesuai KTP Anda.',
                ]);
        }

        // Cek kuota maksimal 250 peserta sebelum membuat peserta baru
        $totalParticipants = Participant::count();
        if ($totalParticipants >= 250) {
            return back()
                ->withInput()
                ->withErrors([
                    'nik' => 'Mohon maaf, kuota peserta JobFair sudah penuh (Maksimal 250 peserta). Pendaftaran telah ditutup.',
                ]);
        }

        // Buat peserta baru
        $participant = Participant::create([
            'nik'  => $nik,
            'name' => $name,
            'participant_type' => $participantType,
        ]);

        session([
            'participant_nik'  => $nik,
            'participant_name' => $name,
        ]);

        return redirect()->route('participant.index')
            ->with('success', 'Pendaftaran berhasil! Selamat datang, ' . $name . '!')
            ->with('show_register_popup', true);
    }

    public function clearNik()
    {
        session()->forget(['participant_nik', 'participant_name']);
        return redirect()->route('participant.index');
    }

    public function history()
    {
        $nik = session('participant_nik');
        $participant = null;
        $applications = [];

        if ($nik) {
            $participant = Participant::where('nik', $nik)->first();
            if ($participant) {
                $applications = Application::with('position.company')
                                ->where('participant_id', $participant->id)
                                ->latest()
                                ->get();
            }
        }

        return view('participant.history', compact('participant', 'applications', 'nik'));
    }

    public function markNotificationRead($id)
    {
        $nik = session('participant_nik');
        if (!$nik) {
            return response()->json(['success' => false], 403);
        }

        $participant = Participant::where('nik', $nik)->first();
        if (!$participant) {
            return response()->json(['success' => false], 403);
        }

        $notification = \App\Models\ParticipantNotification::where('id', $id)
            ->where('participant_id', $participant->id)
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
