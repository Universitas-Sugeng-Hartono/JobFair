@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard </h1>
    
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-building"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalCompanies }}</h3>
            <p>Total Perusahaan</p>
        </div>
    </div>
    
    <div class="stat-card accent-stat">
        <div class="stat-icon">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalParticipants }}</h3>
            <p>Total Peserta (Maks 250)</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-file-signature"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalApplications }}</h3>
            <p>Total Lamaran Masuk</p>
        </div>
    </div>
    
</div>

<div class="content-grid">
    <!-- Recent Companies Table -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Perusahaan Terdaftar Terbaru</h2>
            <a href="#" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">Lihat Semua</a>
        </div>
        <div class="card-body table-responsive" style="padding: 0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Perusahaan</th>
                        <th>Posisi</th>
                        <th>Lamaran Masuk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentCompanies as $company)
                    <tr>
                        <td>
                            <strong>{{ $company->name }}</strong>
                        </td>
                        <td>{{ $company->positions->pluck('name')->join(', ') ?: '-' }}</td>
                        <td>{{ $company->applications_count }}</td>
                        <td>
                            <a href="{{ route('companies.edit', $company->id) }}" style="color: var(--secondary-blue); margin-right: 10px;"><i class="fa-solid fa-pen-to-square"></i></a>
                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus perusahaan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #E53E3E; background:none; border:none; cursor:pointer; padding:0;"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 2rem;">Belum ada perusahaan terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Aktivitas Terbaru</h2>
        </div>
        <div class="card-body">
            <ul class="activity-list">
                @forelse($recentActivities as $activity)
                <li class="activity-item">
                    <div class="activity-icon" style="background-color: rgba(236, 201, 75, 0.2); color: var(--accent-yellow-hover);">
                        <i class="fa-solid fa-file-arrow-up"></i>
                    </div>
                    <div class="activity-details">
                        <h4>Lamaran Masuk</h4>
                        <p><strong>{{ $activity->participant->name ?? 'Peserta (' . $activity->participant->nik . ')' }}</strong> mengirim lamaran ke <strong>{{ $activity->position->company->name }}</strong>.</p>
                        <span class="activity-time">{{ \Carbon\Carbon::parse($activity->created_at)->locale('id')->diffForHumans() }}</span>
                    </div>
                </li>
                @empty
                <li class="activity-item">
                    <div class="activity-details text-center">
                        <p style="color: #64748b;">Belum ada aktivitas lamaran.</p>
                    </div>
                </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
