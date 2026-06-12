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

<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <h2 class="card-title" style="margin: 0;">Daftar Peserta</h2>
        <form method="GET" action="{{ route('participants.index') }}" id="filterForm" style="display:flex; gap:0.5rem; align-items:center;">
            <select name="status" onchange="document.getElementById('filterForm').submit()"
                style="padding: 0.5rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; font-family: inherit; font-size: 0.875rem; color: #0f172a; background: white; cursor: pointer;">
                <option value="">— Semua Peserta —</option>
                <option value="hadir" {{ request('status') === 'hadir' ? 'selected' : '' }}>Hadir</option>
                <option value="tidak_hadir" {{ request('status') === 'tidak_hadir' ? 'selected' : '' }}>Belum Hadir</option>
                <option value="diterima" {{ request('status') === 'diterima' ? 'selected' : '' }}>Ada yang Diterima</option>
                <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ada yang Ditolak</option>
            </select>
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
                        @elseif($participant->rejected_count > 0 && $participant->submitted_count == 0)
                            <span style="color: #dc2626; font-weight: 600; font-size: 0.9rem;">Ditolak</span>
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
    <div style="padding: 1rem; border-top: 1px solid #e2e8f0;">
        {{ $participants->links() }}
    </div>
    @endif
</div>
@endsection
