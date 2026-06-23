<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Participant;
use App\Models\Application;
use App\Models\ApplicationAnswer;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $nik = session('participant_nik');

        if (!$nik) {
            return back()->withErrors(['nik' => 'Harap masukkan NIK Anda terlebih dahulu.']);
        }

        $request->validate([
            'position_id' => 'required|exists:positions,id',
        ], [
            'position_id.required' => 'Posisi tidak valid.',
            'position_id.exists'   => 'Posisi tidak ditemukan.',
        ]);

        $position = \App\Models\Position::findOrFail($request->position_id);
        $company = $position->company;

        // Ambil participant berdasarkan session NIK
        $participant = Participant::where('nik', $nik)->first();

        if (!$participant) {
            // Session ada tapi data DB hilang — paksa logout session
            session()->forget(['participant_nik', 'participant_name']);
            return redirect()->route('participant.index')
                ->withErrors(['nik' => 'Sesi Anda tidak valid. Silakan masukkan NIK kembali.']);
        }

        // Cek sudah apply ke perusahaan ini (maksimal 1 posisi per perusahaan)
        $alreadyAppliedToCompany = Application::where('participant_id', $participant->id)
            ->whereIn('position_id', $company->positions->pluck('id'))
            ->exists();

        if ($alreadyAppliedToCompany) {
            return back()->with('error', 'Anda hanya diperbolehkan melamar maksimal 1 posisi di setiap perusahaan. Anda sudah melamar di ' . $company->name . '.');
        }

        // Cek batas 12 lamaran per NIK
        $totalApplications = Application::where('participant_id', $participant->id)->count();
        if ($totalApplications >= 12) {
            return back()->with('error', 'Batas maksimal lamaran adalah 12 perusahaan. Anda sudah mencapai batas tersebut.');
        }

        // Cek kuota peserta unik (250 NIK berbeda)
        $uniqueParticipantCount = Participant::whereHas('applications')->count();
        $isNewApplicant = ($totalApplications === 0);
        if ($isNewApplicant && $uniqueParticipantCount >= 250) {
            return back()->with('error', 'Kuota peserta JobFair sudah penuh (250 peserta).');
        }

        // Buat lamaran
        $application = Application::create([
            'participant_id' => $participant->id,
            'position_id'    => $position->id,
            'status'         => 'submitted',
        ]);

        // Simpan jawaban form dinamis
        $formConfig = $position->form_config ?? [];
        foreach ($formConfig as $index => $field) {
            $fieldId = $field['id'] ?? $index;
            $fieldKey = 'field_' . $fieldId;
            $answer = new ApplicationAnswer();
            $answer->application_id = $application->id;
            $answer->field_label    = $field['label'];
            $answer->field_type     = $field['type'];

            if ($field['type'] === 'file') {
                if ($request->hasFile($fieldKey)) {
                    $files = $request->file($fieldKey);
                    if (!is_array($files)) {
                        $files = [$files];
                    }
                    foreach ($files as $file) {
                        $answer = new ApplicationAnswer();
                        $answer->application_id = $application->id;
                        $answer->field_label    = $field['label'];
                        $answer->field_type     = $field['type'];
                        $answer->file_path      = $file->store('applications/' . $application->id, 'public');
                        $answer->save();
                    }
                }
                continue; // Skip saving the initial empty $answer object
            } else {
                $answer->field_value = $request->input($fieldKey);
            }

            $answer->save();
        }

        return redirect()->route('participant.index')
            ->with('success', 'Lamaran Anda ke posisi ' . $position->name . ' di ' . $company->name . ' berhasil dikirim!')
            ->with('applied_position_id', $position->id);
    }
}
