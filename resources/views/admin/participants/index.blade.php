@extends('layouts.admin')

@section('title', 'Manajemen Peserta')

@section('content')
<div class="page-header">
    <h1 class="page-title">Manajemen Peserta</h1>
    <p style="color: #64748b; margin-top: 0.5rem; font-size: 0.9rem;">Daftar semua peserta JobFair dan jumlah lamaran mereka.</p>
</div>

@if(session('success'))
<div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #a7f3d0;">
    <i class="fa-solid fa-circle-check" style="margin-right: 0.5rem;"></i> {{ session('success') }}
</div>
@endif

<style>
    /* Custom Pagination Styling */
    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        margin: 0;
        gap: 0.35rem;
        justify-content: flex-end;
    }
    .page-item .page-link {
        padding: 0.4rem 0.8rem;
        border: 1px solid #cbd5e1;
        background: white;
        color: #475569;
        text-decoration: none;
        border-radius: 6px;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    .page-item .page-link:hover {
        background: #f1f5f9;
        color: #0f172a;
    }
    .page-item.active .page-link {
        background: #1e40af;
        color: white;
        border-color: #1e40af;
    }
    .page-item.disabled .page-link {
        color: #94a3b8;
        background: #f8fafc;
        cursor: not-allowed;
    }
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }
    .pagination-info {
        font-size: 0.875rem;
        color: #64748b;
    }
    #btnBroadcastNotif:hover {
        background: #d97706;
    }
</style>

<form action="{{ route('participants.broadcast-attendance') }}" method="POST" id="broadcastForm" style="display: none;">
    @csrf
</form>

<div class="card">
    <div class="card-header" style="display: flex; flex-direction: column; gap: 1rem;">
        <h2 class="card-title" style="margin: 0;">Daftar Peserta</h2>
        <form method="GET" action="{{ route('participants.index') }}" id="filterForm" style="display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center; width: 100%;">
            
            <div style="flex: 1; min-width: 200px;">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIK atau Nama..." 
                    style="width: 100%; padding: 0.5rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 0.875rem; color: #0f172a; outline: none;">
            </div>

            <div style="min-width: 200px;">
                <select name="company_id" id="companyFilter" onchange="updatePositions(); document.getElementById('filterForm').submit()"
                    style="width: 100%; padding: 0.5rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 0.875rem; color: #0f172a; background: white; cursor: pointer;">
                    <option value="">— Semua Perusahaan —</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="min-width: 200px;">
                <select name="position_id" id="positionFilter" onchange="document.getElementById('filterForm').submit()"
                    style="width: 100%; padding: 0.5rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 0.875rem; color: #0f172a; background: white; cursor: pointer;">
                    <option value="">— Semua Posisi —</option>
                </select>
            </div>

            <div style="min-width: 160px;">
                <select name="status" onchange="document.getElementById('filterForm').submit()"
                    style="width: 100%; padding: 0.5rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 0.875rem; color: #0f172a; background: white; cursor: pointer;">
                    <option value="">— Status Peserta —</option>
                    <option value="hadir" {{ request('status') === 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="tidak_hadir" {{ request('status') === 'tidak_hadir' ? 'selected' : '' }}>Belum Hadir</option>
                    <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Ada yang Diterima</option>
                    <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ada yang Ditolak</option>
                </select>
            </div>

            <button type="button" id="btnBroadcastNotif" title="Kirim notifikasi kehadiran ke semua peserta" style="padding: 0.5rem 1rem; background: #f59e0b; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 500; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.4rem; transition: background 0.2s;">
                <i class="fa-solid fa-bell"></i>
            </button>

            <button type="submit" style="padding: 0.5rem 1rem; background: #3b82f6; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 500; font-size: 0.875rem;">
                <i class="fa-solid fa-search"></i> Cari
            </button>

            @if(request()->anyFilled(['search', 'company_id', 'position_id', 'status']))
            <a href="{{ route('participants.index') }}" style="padding: 0.5rem 1rem; background: #f1f5f9; color: #475569; border-radius: 8px; text-decoration: none; font-weight: 500; font-size: 0.875rem;">
                Reset
            </a>
            @endif
        </form>
    </div>
    <div class="card-body table-responsive" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>NIK</th>
                    <th>Status Hadir</th>
                    <th>Status Lamaran</th>
                    <th>Waktu Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($participants as $index => $participant)
                <tr>
                    <td>{{ $participants->firstItem() + $index }}</td>
                    <td>
                        <strong>{{ $participant->name ?? '-' }}</strong>
                    </td>
                    <td>
                        {{ $participant->nik }}
                    </td>
                    <td>
                        @if($participant->attended_at)
                            <span style="background: #dcfce7; color: #166534; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">
                                <i class="fa-solid fa-check-circle"></i> Hadir
                            </span>
                        @else
                            <span style="background: #fee2e2; color: #991b1b; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">
                                <i class="fa-solid fa-xmark-circle"></i> Belum
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($participant->accepted_count > 0)
                            <span style="color: #16a34a; font-weight: 600; font-size: 0.9rem;">Diterima</span>
                        @elseif($participant->rejected_count > 0 && $participant->submitted_count == 0 && $participant->reviewed_count == 0)
                            <span style="color: #dc2626; font-weight: 600; font-size: 0.9rem;">Ditolak</span>
                        @elseif($participant->reviewed_count > 0)
                            <span style="color: #1d4ed8; font-weight: 600; font-size: 0.9rem;">Sedang Interview</span>
                        @elseif($participant->submitted_count > 0)
                            <span style="color: #64748b; font-weight: 600; font-size: 0.9rem;">Menunggu</span>
                        @else
                            <span style="color: #94a3b8; font-size: 0.9rem;">-</span>
                        @endif
                    </td>
                    <td>{{ $participant->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <a href="{{ route('participants.show', $participant->id) }}" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; margin-right: 0.5rem;">
                            <i class="fa-solid fa-eye"></i> Detail
                        </a>
                        <form action="{{ route('participants.destroy', $participant->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus peserta ini beserta semua lamarannya?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: #E53E3E; background:none; border:none; cursor:pointer; padding:0; font-size: 1.1rem;"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 2rem; color: #64748b;">Belum ada peserta yang mendaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($participants->hasPages())
    <div class="pagination-container">
        <div class="pagination-info">
            Menampilkan <strong>{{ $participants->firstItem() }}</strong> - <strong>{{ $participants->lastItem() }}</strong> dari <strong>{{ $participants->total() }}</strong> peserta
        </div>
        <div>
            {{ $participants->links('pagination::bootstrap-4') }}
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    const companiesData = @json($companies);
    const positionFilter = document.getElementById('positionFilter');
    const companyFilter = document.getElementById('companyFilter');
    const selectedPositionId = "{{ request('position_id') }}";

    function updatePositions() {
        const companyId = companyFilter.value;
        
        // Clear current options
        positionFilter.innerHTML = '<option value="">— Semua Posisi —</option>';
        
        if (!companyId) {
            return;
        }

        const company = companiesData.find(c => c.id == companyId);
        if (company && company.positions) {
            company.positions.forEach(pos => {
                const option = document.createElement('option');
                option.value = pos.id;
                option.textContent = pos.name;
                if (pos.id == selectedPositionId) {
                    option.selected = true;
                }
                positionFilter.appendChild(option);
            });
        }
    }

    // Initialize on page load
    updatePositions();

    document.getElementById('btnBroadcastNotif').addEventListener('click', function () {
        const confirmed = confirm('Kirim notifikasi kehadiran JobFair (Jum\'at, 10 Juli 2026) ke semua peserta yang terdaftar?');
        if (confirmed) {
            document.getElementById('broadcastForm').submit();
        }
    });
</script>
@endpush
