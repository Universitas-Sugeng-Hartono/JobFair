<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyPortalController extends Controller
{
    // ─── Auth ──────────────────────────────────────────────────────

    public function showLogin()
    {
        if (session('company_id')) {
            return redirect()->route('company.dashboard');
        }
        return view('company.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login_code' => 'required|string',
            'password'   => 'required|string',
        ]);

        $company = Company::where('login_code', strtoupper(trim($request->login_code)))->first();

        if (!$company || !Hash::check($request->password, $company->password)) {
            return redirect()->back()->with('error', 'Kode login atau password salah.');
        }

        session([
            'company_id'   => $company->id,
            'company_name' => $company->name,
        ]);

        return redirect()->route('company.dashboard');
    }

    public function logout()
    {
        session()->forget(['company_id', 'company_name']);
        return redirect()->route('company.login');
    }

    // ─── Dashboard ─────────────────────────────────────────────────

    public function dashboard()
    {
        $company = Company::with('positions')->findOrFail(session('company_id'));

        $positionIds = $company->positions->pluck('id');

        $totalPositions   = $company->positions->count();
        $totalApplicants  = Application::whereIn('position_id', $positionIds)->count();
        $attendedApplicants = Application::whereIn('position_id', $positionIds)
            ->whereHas('participant', fn($q) => $q->whereNotNull('attended_at'))
            ->count();
        $acceptedApplicants = Application::whereIn('position_id', $positionIds)
            ->where('status', 'accepted')
            ->count();

        // Per-position stats
        $positions = $company->positions->map(function ($pos) {
            $apps = $pos->applications()->with('participant')->get();
            $attended = $apps->filter(fn($a) => $a->participant?->attended_at !== null);
            $pos->applications_count = $apps->count();
            $pos->attended_count     = $attended->count();
            $pos->accepted_count     = $attended->where('status', 'accepted')->count();
            $pos->rejected_count     = $attended->where('status', 'rejected')->count();
            return $pos;
        });

        return view('company.dashboard', compact(
            'company', 'totalPositions', 'totalApplicants',
            'attendedApplicants', 'acceptedApplicants', 'positions'
        ));
    }

    // ─── Pelamar ───────────────────────────────────────────────────

    public function applicants(Request $request)
    {
        $company = Company::with('positions')->findOrFail(session('company_id'));

        $positionIds = $company->positions->pluck('id');

        $query = Application::with(['participant', 'position', 'answers'])
            ->whereIn('position_id', $positionIds)
            ->whereHas('participant', function($q) use ($request) {
                $q->whereNotNull('attended_at');
                if ($request->filled('search')) {
                    $searchTerm = '%' . $request->search . '%';
                    $q->where(function($subQ) use ($searchTerm) {
                        $subQ->where('nik', 'like', $searchTerm)
                             ->orWhere('name', 'like', $searchTerm);
                    });
                }
            });

        if ($request->filled('position_id')) {
            $query->where('position_id', $request->position_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $applications = $query->latest()->paginate(15);

        return view('company.applicants', compact('company', 'applications'));
    }
}
