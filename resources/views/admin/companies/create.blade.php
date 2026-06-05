@extends('layouts.admin')

@section('title', 'Tambah Perusahaan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #0f172a;">Tambah Perusahaan</h1>
        <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.5rem;">Masukkan profil perusahaan.</p>
    </div>
    <a href="{{ route('companies.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 500;">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 max-w-3xl">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #0f172a;">Profil Perusahaan</h2>
        
        <div class="form-group mb-4">
            <label class="form-label" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Nama Perusahaan</label>
            @php $existingCompanies = \App\Models\Company::select('name')->distinct()->get(); @endphp
            <input type="text" name="name" id="name" class="form-control" list="existing_companies" autocomplete="off" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid #cbd5e1;" required>
            <datalist id="existing_companies">
                @foreach($existingCompanies as $ec)
                    <option value="{{ $ec->name }}">
                @endforeach
            </datalist>
        </div>

        <div class="form-group mb-4">
            <label for="logo" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Logo Perusahaan</label>
            <input type="file" name="logo" id="logo" class="form-control" accept="image/*" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid #cbd5e1;">
            <small style="color: #64748b; margin-top: 4px; display: block;">Format PNG, JPG, JPEG maksimal 2MB.</small>
        </div>

        <div class="form-group mb-4">
            <label for="description" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Deskripsi Perusahaan</label>
            <textarea name="description" id="description" rows="3" class="form-control" placeholder="Tuliskan gambaran singkat tentang perusahaan..." style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid #cbd5e1;"></textarea>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary" style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500; border: none; cursor: pointer;">
                <i class="fa-solid fa-save"></i> Simpan Perusahaan
            </button>
        </div>
    </div>
</form>
@endsection
