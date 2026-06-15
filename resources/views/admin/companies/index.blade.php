@extends('layouts.admin')

@section('title', 'Kelola Perusahaan')

@section('content')
<div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 600; color: #1e293b;">Daftar Perusahaan</h1>
        <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.5rem;">Kelola perusahaan yang berpartisipasi dalam JobFair.</p>
    </div>
    <a href="{{ route('companies.create') }}" style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem;">
        <i class="fa-solid fa-plus"></i> Tambah Perusahaan
    </a>
</div>

@if(session('success'))
    <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #bbf7d0; display: flex; align-items: center; gap: 0.5rem;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table style="width: 100%; text-align: left; border-collapse: collapse;">
        <thead>
            <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                <th style="padding: 1rem 1.5rem; color: #475569; font-weight: 600; font-size: 0.875rem;">Perusahaan</th>
                <th style="padding: 1rem 1.5rem; color: #475569; font-weight: 600; font-size: 0.875rem;">Lowongan</th>
                <th style="padding: 1rem 1.5rem; color: #475569; font-weight: 600; font-size: 0.875rem;">Info Portal</th>
                <th style="padding: 1rem 1.5rem; color: #475569; font-weight: 600; font-size: 0.875rem;">Total Pelamar</th>
                <th style="padding: 1rem 1.5rem; color: #475569; font-weight: 600; font-size: 0.875rem; text-align: right;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($companies as $company)
            <tr style="border-bottom: 1px solid #e2e8f0;">
                <td style="padding: 1rem 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 40px; height: 40px; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; padding: 2px; flex-shrink: 0;">
                            <img src="{{ asset('storage/' . $company->logo_path) }}" alt="{{ $company->name }}" style="width: 100%; height: 100%; object-fit: contain;">
                        </div>
                        <div>
                            <div style="font-weight: 600; color: #0f172a;">{{ $company->name }}</div>
                            @if($company->description)
                                <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.15rem; max-width: 280px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $company->description }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td style="padding: 1rem 1.5rem;">
                    <a href="{{ route('positions.index', ['company_id' => $company->id]) }}" style="text-decoration: none;" title="Lihat lowongan perusahaan ini">
                        <span style="background: #e0f2fe; color: #0369a1; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.35rem;">
                            <i class="fa-solid fa-briefcase" style="font-size: 0.7rem;"></i>
                            {{ $company->positions->count() }} Posisi
                        </span>
                    </a>
                </td>
                <td style="padding: 1rem 1.5rem; color: #64748b; font-size: 0.875rem;">
                    @if($company->login_code)
                        <div style="font-family: monospace; color: #14b8a6; font-weight: 600; font-size: 0.95rem;">
                            <i class="fa-solid fa-key" style="font-size: 0.75rem;"></i> {{ $company->login_code }}
                        </div>
                        @if($company->pic_name)
                            <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.2rem;"><i class="fa-solid fa-user"></i> {{ $company->pic_name }}</div>
                        @endif
                    @else
                        <span style="color: #cbd5e1; font-style: italic;">Belum diset</span>
                    @endif
                </td>
                <td style="padding: 1rem 1.5rem;">
                    <span style="background: #f0fdf4; color: #166534; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; border: 1px solid #bbf7d0;">
                        {{ $company->applications()->count() }} Pelamar
                    </span>
                </td>
                <td style="padding: 1rem 1.5rem; text-align: right; white-space: nowrap;">
                    <a href="{{ route('companies.edit', $company->id) }}" style="color: #3b82f6; padding: 0.5rem 0.75rem; text-decoration: none; background: #eff6ff; border-radius: 6px; font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.4rem; margin-right: 0.25rem;">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus perusahaan ini? Semua lowongan & lamaran akan ikut terhapus.');">
                        @csrf @method('DELETE')
                        <button type="submit" style="background: #fef2f2; border: none; color: #ef4444; cursor: pointer; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.4rem;">
                            <i class="fa-solid fa-trash"></i> Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="padding: 3rem 1.5rem; text-align: center; color: #94a3b8;">
                    <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">🏢</div>
                    <p style="font-weight: 500;">Belum ada data perusahaan.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
        {{ $companies->links() }}
    </div>
</div>
@endsection
