@extends('layouts.admin')

@section('title', 'Edit Perusahaan')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #0f172a;">Edit Perusahaan</h1>
        <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.5rem;">Perbarui profil perusahaan.</p>
    </div>
    <a href="{{ route('companies.index') }}" class="btn" style="background: #f1f5f9; color: #475569; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 500;">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 max-w-3xl">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #0f172a;">Profil Perusahaan</h2>
        
        <div class="form-group mb-4">
            <label class="form-label" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Nama Perusahaan</label>
            @php $existingCompanies = \App\Models\Company::select('name')->distinct()->get(); @endphp
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $company->name) }}" list="existing_companies" autocomplete="off" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid #cbd5e1;" required>
            <datalist id="existing_companies">
                @foreach($existingCompanies as $ec)
                    <option value="{{ $ec->name }}">
                @endforeach
            </datalist>
        </div>

        <div class="form-group mb-4">
            <label for="logo" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Logo Perusahaan</label>
            @if($company->logo_path)
                <div style="margin-bottom: 10px;">
                    <img src="{{ asset('storage/' . $company->logo_path) }}" alt="Logo Saat Ini" style="max-height: 80px; border-radius: 8px; border: 1px solid #e2e8f0; padding: 4px;">
                </div>
            @endif
            <input type="file" name="logo" id="logo" class="form-control" accept="image/*" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid #cbd5e1;">
            <small style="color: #64748b; margin-top: 4px; display: block;">Biarkan kosong jika tidak ingin mengubah logo.</small>
        </div>

        <div class="form-group mb-4">
            <label for="description" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Deskripsi Perusahaan</label>
            <textarea name="description" id="description" rows="3" class="form-control" style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid #cbd5e1;">{{ old('description', $company->description) }}</textarea>
        </div>

        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 1.5rem 0;">
        <h2 style="font-size: 1rem; font-weight: 600; margin-bottom: 1rem; color: #0f172a;">
            <i class="fa-solid fa-key" style="color: #14b8a6; margin-right: 0.4rem;"></i>
            Akses Portal Perusahaan
        </h2>
        <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 1.25rem;">
            Set kode login agar perusahaan bisa mengakses portal seleksi pelamar di
            <a href="{{ url('/perusahaan/login') }}" target="_blank" style="color: #14b8a6;">/perusahaan/login</a>.
        </p>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
            <div class="form-group">
                <label for="login_code" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Kode Login</label>
                <input type="text" name="login_code" id="login_code" class="form-control"
                    value="{{ old('login_code', $company->login_code) }}"
                    placeholder="Contoh: COMP-001"
                    style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid #cbd5e1; font-family: monospace; font-size: 1rem; text-transform: uppercase;">
                <small style="color: #64748b; margin-top: 4px; display: block;">Kode unik untuk login. Biarkan kosong jika tidak diubah.</small>
            </div>
            <div class="form-group">
                <label for="pic_name" style="display: block; font-weight: 500; margin-bottom: 0.5rem;">Nama PIC Perusahaan</label>
                <input type="text" name="pic_name" id="pic_name" class="form-control"
                    value="{{ old('pic_name', $company->pic_name) }}"
                    placeholder="Nama penanggung jawab"
                    style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid #cbd5e1;">
            </div>
        </div>

        <div style="margin-top: 2rem;">
            <button type="submit" class="btn btn-primary" style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 500; border: none; cursor: pointer;">
                <i class="fa-solid fa-save"></i> Simpan Perubahan
            </button>
        </div>
    </div>
</form>
@endsection
