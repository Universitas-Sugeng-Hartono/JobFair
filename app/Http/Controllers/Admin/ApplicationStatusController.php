<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationStatusController extends Controller
{
    /**
     * Update the status of an application (accepted / rejected / submitted).
     */
    public function update(Request $request, Application $application)
    {
        $request->validate([
            'status' => 'required|in:submitted,accepted,rejected'
        ]);

        $application->status = $request->status;
        $application->accepted_at = $request->status === 'accepted' ? now() : null;
        $application->save();

        return redirect()->back()->with(
            'success',
            'Status lamaran ' . $application->participant->name . ' di ' . $application->position->company->name . ' berhasil diperbarui menjadi ' . ucfirst($request->status) . '.'
        );
    }
}
