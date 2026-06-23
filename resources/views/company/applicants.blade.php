@extends('layouts.company')

@section('title', 'Daftar Pelamar')

@push('styles')
<style>
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-accepted {
        background: #dcfce7;
        color: #16a34a;
    }

    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-reviewed {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-submitted {
        background: #f1f5f9;
        color: #475569;
    }
</style>
@endpush

@section('content')
<div class="page-header">
    <h1 class="page-title">Daftar Pelamar — {{ $company->name }}</h1>
    <p style="color:#64748b;margin-top:0.5rem;font-size:0.9rem;">
        Hanya menampilkan pelamar yang telah hadir dan diverifikasi oleh panitia.
    </p>
</div>

<!-- Flash messages -->
@if(session('success'))
<div style="background:#dcfce7; color:#16a34a; padding:1rem; border-radius:8px; margin-bottom:1.5rem; font-weight:500;">
    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
</div>
@endif
@if(session('error'))
<div style="background:#fee2e2; color:#991b1b; padding:1rem; border-radius:8px; margin-bottom:1.5rem; font-weight:500;">
    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
</div>
@endif

<!-- Filter -->
<div class="card" style="margin-bottom:1.5rem;">
    <div class="card-body" style="display:flex;gap:0.75rem;flex-wrap:wrap;align-items:center;padding:1rem;">

        <!-- Dropdown filter posisi -->
        <form method="GET" action="{{ route('company.applicants') }}" id="filterForm" style="display:flex;gap:0.75rem;align-items:center;flex-wrap:wrap;flex:1;">
            <input type="hidden" name="status" value="{{ request('status') }}">

            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIK atau Nama..."
                    style="width: 100%; padding: 0.6rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 0.875rem; color: #0f172a; outline: none;">
            </div>
            <select name="position_id" onchange="document.getElementById('filterForm').submit()"
                style="padding:0.6rem 1rem;border:1px solid #cbd5e1;border-radius:8px;font-family:inherit;font-size:0.875rem;color:#0f172a;background:white;cursor:pointer;min-width:200px;">
                <option value="">— Semua Posisi —</option>
                @foreach($company->positions as $pos)
                <option value="{{ $pos->id }}" {{ request('position_id') == $pos->id ? 'selected' : '' }}>
                    {{ $pos->name }}
                </option>
                @endforeach
            </select>
            <button type="submit" style="padding: 0.6rem 1rem; background: #3b82f6; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 500; font-size: 0.875rem;">
                <i class="fa-solid fa-search"></i> Cari
            </button>
            @if(request()->anyFilled(['search', 'position_id']))
            <a href="{{ route('company.applicants') }}" style="padding: 0.6rem 1rem; background: #f1f5f9; color: #475569; border-radius: 8px; text-decoration: none; font-weight: 500; font-size: 0.875rem;">
                Reset
            </a>
            @endif
        </form>

        <!-- Filter status (dropdown) -->
        <select name="status" form="filterForm" onchange="document.getElementById('filterForm').submit()"
            style="padding:0.6rem 1rem;border:1px solid #cbd5e1;border-radius:8px;font-family:inherit;font-size:0.875rem;color:#0f172a;background:white;cursor:pointer;min-width:160px;">
            <option value="">— Semua Status —</option>
            <option value="submitted" {{ request('status') === 'submitted' ? 'selected' : '' }}>Menunggu</option>
            <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>Sedang Interview</option>
            <option value="accepted" {{ request('status') === 'accepted'  ? 'selected' : '' }}>Diterima</option>
            <option value="rejected" {{ request('status') === 'rejected'  ? 'selected' : '' }}>Ditolak</option>
        </select>
    </div>
</div>

<div class="card">
    <div class="card-body table-responsive" style="padding:0;">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pelamar</th>
                    <th>NIK</th>
                    <th>Posisi Dilamar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($applications as $index => $application)
                <tr>
                    <td>{{ $applications->firstItem() + $index }}</td>
                    <td>
                        <strong>{{ $application->participant->name ?? '-' }}</strong>
                        <div style="font-size:0.75rem;color:#94a3b8;font-family:monospace;">{{ $application->participant->nik }}</div>
                    </td>
                    <td style="font-family:monospace;font-size:0.875rem;">{{ $application->participant->nik }}</td>
                    <td>{{ $application->position->name ?? '-' }}</td>
                    <td>
                        @if($application->status === 'accepted')
                        <span class="status-badge status-accepted"><i class="fa-solid fa-circle-check"></i> Diterima</span>
                        @elseif($application->status === 'rejected')
                        <span class="status-badge status-rejected"><i class="fa-solid fa-circle-xmark"></i> Ditolak</span>
                        @elseif($application->status === 'reviewed')
                        <span class="status-badge status-reviewed"><i class="fa-solid fa-users-viewfinder"></i> Sedang Interview</span>
                        @else
                        <span class="status-badge status-submitted"><i class="fa-regular fa-clock"></i> Menunggu</span>
                        @endif
                    </td>
                    <td style="display:flex;gap:0.4rem;flex-wrap:wrap;align-items:center;">
                        <!-- Lihat detail form -->
                        <button type="button"
                            style="background:#f1f5f9;color:#475569;border:1px solid #cbd5e1;padding:0.3rem 0.6rem;border-radius:6px;font-size:0.8rem;cursor:pointer;"
                            onclick="document.getElementById('modal-{{ $application->id }}').style.display='flex'">
                            <i class="fa-solid fa-list-check"></i> Detail
                        </button>

                        @if($application->status === 'submitted')
                        <form action="{{ route('company.applications.status', $application->id) }}" method="POST" style="display:inline;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="reviewed">
                            <button type="submit"
                                style="background:#3b82f6;color:white;border:none;padding:0.3rem 0.6rem;border-radius:6px;font-size:0.8rem;cursor:pointer;"
                                onclick="return confirm('Tandai peserta ini hadir di Booth dan mulai interview?')">
                                <i class="fa-solid fa-check"></i> Hadir di Booth
                            </button>
                        </form>
                        @elseif($application->status === 'reviewed')
                        <form action="{{ route('company.applications.status', $application->id) }}" method="POST" style="display:inline;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="accepted">
                            <button type="submit"
                                style="background:#16a34a;color:white;border:none;padding:0.3rem 0.6rem;border-radius:6px;font-size:0.8rem;cursor:pointer;"
                                onclick="return confirm('Tandai pelamar ini DITERIMA?')">
                                <i class="fa-solid fa-check"></i> Terima
                            </button>
                        </form>
                        <form action="{{ route('company.applications.status', $application->id) }}" method="POST" style="display:inline;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit"
                                style="background:#ef4444;color:white;border:none;padding:0.3rem 0.6rem;border-radius:6px;font-size:0.8rem;cursor:pointer;"
                                onclick="return confirm('Tandai pelamar ini DITOLAK?')">
                                <i class="fa-solid fa-xmark"></i> Tolak
                            </button>
                        </form>
                        @else
                        <form action="{{ route('company.applications.status', $application->id) }}" method="POST" style="display:inline;">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="reviewed">
                            <button type="submit"
                                style="background:#f59e0b;color:white;border:none;padding:0.3rem 0.6rem;border-radius:6px;font-size:0.8rem;cursor:pointer;"
                                onclick="return confirm('Reset status ke Sedang Interview?')">
                                <i class="fa-solid fa-rotate-left"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>

                <!-- Modal Detail Lamaran -->
                <div id="modal-{{ $application->id }}" style="display:none;position:fixed;inset:0;background:rgba(15,23,42,0.6);z-index:1000;align-items:center;justify-content:center;backdrop-filter:blur(4px);">
                    <div style="background:white;border-radius:12px;width:100%;max-width:620px;max-height:90vh;display:flex;flex-direction:column;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
                        <div style="padding:1.5rem;border-bottom:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center;">
                            <div>
                                <h3 style="font-size:1.1rem;font-weight:700;color:#0f172a;margin:0;">{{ $application->participant->name ?? '-' }}</h3>
                                <p style="font-size:0.8rem;color:#64748b;margin:0.25rem 0 0;">{{ $application->position->name ?? '-' }}</p>
                            </div>
                            <button type="button" onclick="document.getElementById('modal-{{ $application->id }}').style.display='none'" style="background:none;border:none;font-size:1.2rem;cursor:pointer;color:#64748b;"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <div style="padding:1.5rem;overflow-y:auto;">
                            @if($application->answers->count() > 0)
                            <div style="display:flex;flex-direction:column;gap:1.25rem;">
                                @foreach($application->answers as $answer)
                                <div style="background:#f8fafc;padding:1rem;border-radius:8px;border:1px solid #f1f5f9;">
                                    <div style="font-size:0.8rem;font-weight:600;color:#64748b;margin-bottom:0.25rem;">{{ $answer->field_label }}</div>
                                    <div style="font-size:0.95rem;color:#0f172a;font-weight:500;">
                                        @if($answer->field_type === 'file')
                                        @if($answer->file_path)
                                        <a href="{{ asset('storage/' . $answer->file_path) }}" target="_blank" class="btn btn-primary" style="padding:0.4rem 0.8rem;font-size:0.8rem;">
                                            <i class="fa-solid fa-eye"></i> Lihat File
                                        </a>
                                        @else
                                        <span style="color:#94a3b8;font-style:italic;">Tidak ada file</span>
                                        @endif
                                        @else
                                        {{ $answer->field_value ?? '-' }}
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p style="color:#64748b;font-style:italic;text-align:center;padding:2rem 0;">Tidak ada data form tambahan.</p>
                            @endif
                        </div>
                        <div style="padding:1rem 1.5rem;border-top:1px solid #e2e8f0;display:flex;justify-content:space-between;align-items:center;">
                            <div>
                                @if($application->status !== 'accepted')
                                <form action="{{ route('company.applications.status', $application->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="accepted">
                                    <button type="submit" style="background:#6366f1;color:white;border:none;padding:0.5rem 1rem;border-radius:6px;font-size:0.875rem;cursor:pointer;margin-right:0.5rem;" onclick="return confirm('Terima pelamar ini?')">
                                        <i class="fa-solid fa-check"></i> Terima
                                    </button>
                                </form>
                                @endif
                                @if($application->status !== 'rejected')
                                <form action="{{ route('company.applications.status', $application->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" style="background:#ef4444;color:white;border:none;padding:0.5rem 1rem;border-radius:6px;font-size:0.875rem;cursor:pointer;" onclick="return confirm('Tolak pelamar ini?')">
                                        <i class="fa-solid fa-xmark"></i> Tolak
                                    </button>
                                </form>
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline" onclick="document.getElementById('modal-{{ $application->id }}').style.display='none'">Tutup</button>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:#64748b;">Belum ada pelamar yang hadir.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($applications->hasPages())
    <div style="padding:1rem;border-top:1px solid #e2e8f0;">
        {{ $applications->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection