@extends('layouts.admin')

@section('title', 'Kelola Lowongan')

@section('content')
<div class="content-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 600; color: #1e293b;">Daftar Lowongan</h1>
        <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.5rem;">Pilih perusahaan untuk melihat dan mengelola lowongan.</p>
    </div>
    @if(request('company_id'))
        <a href="{{ route('positions.create', ['company_id' => request('company_id')]) }}" style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem;">
            <i class="fa-solid fa-plus"></i> Tambah Lowongan
        </a>
    @else
        <a href="{{ route('positions.create') }}" style="background: #cbd5e1; color: #64748b; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; cursor: default;" title="Pilih perusahaan dahulu">
            <i class="fa-solid fa-plus"></i> Tambah Lowongan
        </a>
    @endif
</div>

{{-- Alert --}}
@if(session('success'))
    <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #bbf7d0; display: flex; align-items: center; gap: 0.5rem;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

{{-- Filter Bar --}}
<div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 1.25rem 1.5rem; margin-bottom: 1.5rem;">
    <label style="display: block; font-size: 0.75rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.6rem;">
        <i class="fa-solid fa-building" style="margin-right: 0.35rem;"></i> Filter Perusahaan
    </label>
    <div style="display: flex; gap: 0.75rem; align-items: center;">
        <select id="companyFilter" onchange="filterByCompany(this.value)" style="flex: 1; max-width: 420px; padding: 0.65rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.875rem; color: #334155; background: white; cursor: pointer;">
            <option value="">— Pilih Perusahaan —</option>
            @foreach($companies as $c)
                <option value="{{ $c->id }}" {{ request('company_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
        @if(request('company_id'))
            <a href="{{ route('positions.index') }}" style="color: #94a3b8; font-size: 0.875rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.5rem 0.75rem; border: 1px solid #e2e8f0; border-radius: 8px; background: #f8fafc;">
                <i class="fa-solid fa-xmark"></i> Reset
            </a>
        @endif
    </div>
</div>

{{-- Konten berdasarkan filter --}}
@if(request('company_id'))
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table style="width: 100%; text-align: left; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 1rem 1.5rem; color: #475569; font-weight: 600; font-size: 0.875rem;">Posisi</th>
                    <th style="padding: 1rem 1.5rem; color: #475569; font-weight: 600; font-size: 0.875rem;">Tahapan Seleksi</th>
                    <th style="padding: 1rem 1.5rem; color: #475569; font-weight: 600; font-size: 0.875rem;">Waktu Proses</th>
                    <th style="padding: 1rem 1.5rem; color: #475569; font-weight: 600; font-size: 0.875rem;">Pelamar</th>
                    <th style="padding: 1rem 1.5rem; color: #475569; font-weight: 600; font-size: 0.875rem; text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($positions as $position)
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 1rem 1.5rem;">
                        <div style="font-weight: 600; color: #0f172a;">{{ $position->name }}</div>
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #64748b; font-size: 0.875rem;">
                        {{ $position->selection ?? '-' }}
                    </td>
                    <td style="padding: 1rem 1.5rem; color: #64748b; font-size: 0.875rem;">
                        @php
                            $eventDateSetting = \App\Models\Setting::where('key', 'event_date')->value('value') ?? date('Y-m-d');
                            $eventDateObj = \Carbon\Carbon::parse($eventDateSetting)->startOfDay();
                            $today = \Carbon\Carbon::now()->startOfDay();
                            
                            if ($today->lt($eventDateObj)) {
                                $diff = $today->diffInDays($eventDateObj);
                                $waktuProses = $diff . ' Hari';
                            } elseif ($today->gt($eventDateObj)) {
                                $waktuProses = 'Selesai';
                            } else {
                                $waktuProses = 'Hari ini';
                            }
                        @endphp
                        {{ $waktuProses }}
                    </td>
                    <td style="padding: 1rem 1.5rem;">
                        <span style="background: #f0fdf4; color: #166534; padding: 0.25rem 0.6rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 600; border: 1px solid #bbf7d0;">
                            {{ $position->applications()->count() }} Pelamar
                        </span>
                    </td>
                    <td style="padding: 1rem 1.5rem; text-align: right; white-space: nowrap;">
                        <a href="{{ route('positions.edit', $position->id) }}" style="color: #3b82f6; padding: 0.5rem 0.75rem; text-decoration: none; background: #eff6ff; border-radius: 6px; font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.4rem; margin-right: 0.25rem;">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                        <form action="{{ route('positions.destroy', $position->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin hapus lowongan ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" style="background: #fef2f2; border: none; color: #ef4444; cursor: pointer; padding: 0.5rem 0.75rem; border-radius: 6px; font-size: 0.8rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.4rem;">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 3rem 1.5rem; text-align: center; color: #94a3b8;">
                        <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">📋</div>
                        <p style="font-weight: 500; margin-bottom: 0.75rem;">Belum ada lowongan untuk perusahaan ini.</p>
                        <a href="{{ route('positions.create', ['company_id' => request('company_id')]) }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: #3b82f6; color: white; padding: 0.6rem 1.2rem; border-radius: 8px; text-decoration: none; font-size: 0.875rem; font-weight: 500;">
                            <i class="fa-solid fa-plus"></i> Tambah Lowongan Pertama
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0;">
            {{ $positions->appends(request()->query())->links() }}
        </div>
    </div>
@else
    {{-- Empty state - belum pilih perusahaan --}}
    <div style="background: white; border: 2px dashed #e2e8f0; border-radius: 16px; padding: 5rem 2rem; text-align: center;">
        <div style="font-size: 4rem; margin-bottom: 1rem;"></div>
        <h3 style="font-size: 1.125rem; font-weight: 600; color: #475569; margin-bottom: 0.5rem;">Pilih Perusahaan Terlebih Dahulu</h3>
        <p style="font-size: 0.875rem; color: #94a3b8; max-width: 340px; margin: 0 auto; line-height: 1.6;">Gunakan dropdown <strong>Filter Perusahaan</strong> di atas untuk memilih perusahaan dan melihat daftar lowongannya.</p>
    </div>
@endif

@endsection

@push('scripts')
<script>
    function filterByCompany(companyId) {
        if (companyId) {
            window.location.href = '{{ route('positions.index') }}?company_id=' + companyId;
        } else {
            window.location.href = '{{ route('positions.index') }}';
        }
    }
</script>
@endpush
