<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyPortalController extends Controller
{
    // ─── Auth ──────────────────────────────────────────────────────

    public function showLogin()
    {
        if (Auth::guard('company')->check()) {
            return redirect()->route('company.dashboard');
        }
        return view('company.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login_code' => 'required|string',
            'password'   => 'required|string',
        ]);

        if (Auth::guard('company')->attempt([
            'login_code' => strtoupper(trim($request->login_code)),
            'password' => $request->password,
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('company.dashboard');
        }

        return redirect()->back()->with('error', 'Kode login atau password salah.');
    }

    public function logout(Request $request)
    {
        Auth::guard('company')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('company.login');
    }

    // ─── Dashboard ─────────────────────────────────────────────────

    public function dashboard()
    {
        $companyId = Auth::guard('company')->id();
        $company = Company::with('positions')->findOrFail($companyId);

        $positionIds = $company->positions->pluck('id');

        $totalPositions   = $company->positions->count();
        $totalApplicants  = Application::whereIn('position_id', $positionIds)->count();
        // Pelamar yang sudah masuk ke Booth (Sedang Interview / Diterima / Ditolak)
        $attendedApplicants = Application::whereIn('position_id', $positionIds)
            ->whereIn('status', ['reviewed', 'accepted', 'rejected'])
            ->count();
        $acceptedApplicants = Application::whereIn('position_id', $positionIds)
            ->where('status', 'accepted')
            ->count();

        // Per-position stats
        $positions = $company->positions->map(function ($pos) {
            $apps = $pos->applications;
            // Attended = Sudah ditandai hadir di booth (reviewed, accepted, rejected)
            $attended = $apps->filter(fn($a) => in_array($a->status, ['reviewed', 'accepted', 'rejected']));
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
        $companyId = Auth::guard('company')->id();
        $company = Company::with('positions')->findOrFail($companyId);

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

    public function updateStatus(Request $request, Application $application)
    {
        $company = Auth::guard('company')->user();

        // Validasi kepemilikan pelamar
        if ($application->position->company_id != $company->id) {
            return back()->with('error', 'Anda tidak memiliki akses untuk mengubah status pelamar ini.');
        }

        $request->validate([
            'status' => 'required|in:submitted,reviewed,accepted,rejected'
        ]);

        $application->status = $request->status;
        $application->save();

        $message = 'Status pelamar berhasil diperbarui.';
        if ($request->status === 'reviewed') {
            $message = 'Pelamar ditandai hadir di booth (Sedang Interview).';
        } elseif ($request->status === 'accepted') {
            $message = 'Pelamar diterima.';
        } elseif ($request->status === 'rejected') {
            $message = 'Pelamar ditolak.';
        }

        return back()->with('success', $message);
    }
}
