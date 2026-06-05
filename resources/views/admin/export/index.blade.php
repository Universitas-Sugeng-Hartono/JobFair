@extends('layouts.admin')

@section('title', 'Ekspor Data Lamaran')

@section('content')
<div class="page-header">
    <h1 class="page-title">Ekspor Data</h1>
    <p style="color: #64748b; margin-top: 0.5rem; font-size: 0.9rem;">Pilih perusahaan untuk mendownload laporan lamaran dalam format CSV/Excel.</p>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto; margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title"><i class="fa-solid fa-file-export" style="margin-right: 0.5rem; color: var(--primary-blue);"></i> Unduh Laporan Per Perusahaan</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('export.company') }}" method="POST">
            @csrf
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label for="company_id" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Pilih Perusahaan</label>
                <select name="company_id" id="company_id" class="form-control" required style="width: 100%; padding: 0.75rem; border-radius: 8px; border: 1px solid #cbd5e1;">
                    <option value="" disabled selected>-- Pilih Perusahaan --</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }} ({{ $company->applications()->count() }} Lamaran)</option>
                    @endforeach
                </select>
                @error('company_id')
                    <small style="color: red; margin-top: 0.25rem; display: block;">{{ $message }}</small>
                @enderror
                
                <small style="display: block; margin-top: 0.75rem; color: #64748b; line-height: 1.5;">
                    <i class="fa-solid fa-circle-info" style="color: var(--secondary-blue);"></i>
                    File yang diunduh berbentuk <strong>.xlsx </strong>
                </small>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.8rem; font-size: 1rem; display: flex; justify-content: center; align-items: center; gap: 0.5rem;">
                <i class="fa-solid fa-download"></i> Ekspor Sekarang
            </button>
        </form>
    </div>
</div>
@endsection
