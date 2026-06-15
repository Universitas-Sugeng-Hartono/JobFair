<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
  
    public function index()
    {
        $companies = \App\Models\Company::with('positions')->latest()->paginate(10);
        return view('admin.companies.index', compact('companies'));
    }

 
    public function create()
    {
        return view('admin.companies.create');
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string',
            'login_code' => 'nullable|string|max:50|unique:companies,login_code',
            'pic_name' => 'nullable|string|max:255',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('companies', 'public');
        }

        $data = [
            'name' => $request->name,
            'logo_path' => $logoPath,
            'description' => $request->description,
            'pic_name' => $request->pic_name,
        ];

        if ($request->filled('login_code')) {
            $data['login_code'] = strtoupper(trim($request->login_code));
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['login_code']);
        }

        \App\Models\Company::create($data);

        return redirect()->route('companies.index')->with('success', 'Perusahaan berhasil ditambahkan');
    }

   
    public function show(string $id)
    {
        $company = \App\Models\Company::findOrFail($id);
        return view('admin.companies.show', compact('company'));
    }

  
    public function edit(string $id)
    {
        $company = \App\Models\Company::findOrFail($id);
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, string $id)
    {
        $company = \App\Models\Company::findOrFail($id);

        $request->validate([
            'name'           => 'required|string|max:255',
            'logo'           => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description'    => 'nullable|string',
            'login_code'     => 'nullable|string|max:50|unique:companies,login_code,' . $company->id,
            'pic_name'       => 'nullable|string|max:255',
        ]);

        $data = [
            'name'        => $request->name,
            'description' => $request->description,
            'pic_name'    => $request->pic_name,
        ];

        if ($request->filled('login_code')) {
            $data['login_code'] = strtoupper(trim($request->login_code));
            // Password otomatis disamakan dengan login_code
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['login_code']);
        }

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('companies', 'public');
        }

        $company->update($data);

        return redirect()->route('companies.index')->with('success', 'Data perusahaan berhasil diperbarui');
    }

  
    public function destroy(string $id)
    {
        $company = \App\Models\Company::findOrFail($id);
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Perusahaan berhasil dihapus');
    }
}
