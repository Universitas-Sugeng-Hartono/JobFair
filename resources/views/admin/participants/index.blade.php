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
    <div class="card-header">
        <h2 class="card-title">Daftar Peserta</h2>
    </div>
    <div class="card-body table-responsive" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>NIK</th>
                    <th>Total Lamaran</th>
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
                        <span class="badge" style="background: var(--primary-blue); color: white;">
                            {{ $participant->applications_count }} / 12
                        </span>
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
                    <td colspan="6" class="text-center" style="padding: 2rem; color: #64748b;">Belum ada peserta yang mendaftar.</td>
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
