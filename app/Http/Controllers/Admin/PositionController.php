<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\Company;

class PositionController extends Controller
{
    public function index()
    {
        $companies = Company::orderBy('name')->get();

        $positionsQuery = Position::with('company')->latest();

        if (request('company_id')) {
            $positionsQuery->where('company_id', request('company_id'));
        } else {
            // Jika tidak ada filter, kembalikan empty collection (bukan query semua)
            $positions = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 15);
            return view('admin.positions.index', compact('positions', 'companies'));
        }

        $positions = $positionsQuery->paginate(15);
        return view('admin.positions.index', compact('positions', 'companies'));
    }

    public function create(Request $request)
    {
        $company_id = $request->query('company_id');
        $company = $company_id ? Company::findOrFail($company_id) : null;
        $companies = Company::orderBy('name')->get();
        return view('admin.positions.create', compact('company', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
        ]);
        
        $data = $request->all();
        $data['form_config'] = $request->form_config ? json_decode($request->form_config, true) : null;
        
        Position::create($data);
        
        return redirect()->route('positions.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }

    public function edit(Position $position)
    {
        $company = $position->company;
        $companies = Company::orderBy('name')->get();
        return view('admin.positions.edit', compact('position', 'company', 'companies'));
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $data = $request->all();
        $data['form_config'] = $request->form_config ? json_decode($request->form_config, true) : null;
        
        $position->update($data);
        
        return redirect()->route('positions.index')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroy(Position $position)
    {
        $position->delete();
        return back()->with('success', 'Lowongan berhasil dihapus.');
    }
}
