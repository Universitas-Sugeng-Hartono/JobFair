<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Application;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function index()
    {
        $companies = Company::orderBy('name')->get();
        return view('admin.export.index', compact('companies'));
    }

    public function exportCompany(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id'
        ]);

        $company = Company::findOrFail($request->company_id);
        $filename = 'Export_Pelamar_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $company->name) . '_' . date('Ymd_His') . '.xlsx';

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\CompanyApplicationExport($company), $filename);
    }
}
