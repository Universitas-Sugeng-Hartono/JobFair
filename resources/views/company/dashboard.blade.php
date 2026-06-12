@extends('layouts.company')

@section('title', 'Dashboard Perusahaan')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard — {{ $company->name }}</h1>
    <p style="color: #64748b; margin-top: 0.5rem; font-size: 0.9rem;">
        Selamat datang! Di sini Anda dapat melihat dan menentukan status penerimaan pelamar yang hadir.
    </p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="fa-solid fa-briefcase"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalPositions }}</h3>
            <p>Posisi Dibuka</p>
        </div>
    </div>

    <div class="stat-card accent-stat">
        <div class="stat-icon">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $totalApplicants }}</h3>
            <p>Total Pelamar</p>
        </div>
    </div>

    <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
        <div class="stat-icon" style="background: rgba(255,255,255,0.2); color: white;">
            <i class="fa-solid fa-user-check"></i>
        </div>
        <div class="stat-info">
            <h3 style="color: white;">{{ $attendedApplicants }}</h3>
            <p style="color: rgba(255,255,255,0.85);">Pelamar Hadir</p>
        </div>
    </div>

    <div class="stat-card" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white;">
        <div class="stat-icon" style="background: rgba(255,255,255,0.2); color: white;">
            <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="stat-info">
            <h3 style="color: white;">{{ $acceptedApplicants }}</h3>
            <p style="color: rgba(255,255,255,0.85);">Diterima</p>
        </div>
    </div>
</div>

<!-- Per Posisi Overview -->
<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h2 class="card-title">Ringkasan Per Posisi</h2>
        <a href="{{ route('company.applicants') }}" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">
            Lihat Semua Pelamar
        </a>
    </div>
    <div class="card-body table-responsive" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>Posisi</th>
                    <th>Total Pelamar</th>
                    <th>Hadir</th>
                    <th>Diterima</th>
                    <th>Ditolak</th>
                    <th>Menunggu</th>
                </tr>
            </thead>
            <tbody>
                @forelse($positions as $position)
                <tr>
                    <td><strong>{{ $position->name }}</strong></td>
                    <td>{{ $position->applications_count }}</td>
                    <td>
                        <span style="background:#dcfce7;color:#166534;padding:0.2rem 0.5rem;border-radius:4px;font-size:0.8rem;font-weight:600;">
                            {{ $position->attended_count }}
                        </span>
                    </td>
                    <td>
                        <span style="background:#ede9fe;color:#4f46e5;padding:0.2rem 0.5rem;border-radius:4px;font-size:0.8rem;font-weight:600;">
                            {{ $position->accepted_count }}
                        </span>
                    </td>
                    <td>
                        <span style="background:#fee2e2;color:#991b1b;padding:0.2rem 0.5rem;border-radius:4px;font-size:0.8rem;font-weight:600;">
                            {{ $position->rejected_count }}
                        </span>
                    </td>
                    <td>
                        <span style="background:#f1f5f9;color:#475569;padding:0.2rem 0.5rem;border-radius:4px;font-size:0.8rem;font-weight:600;">
                            {{ $position->attended_count - $position->accepted_count - $position->rejected_count }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:2rem;color:#64748b;">Belum ada posisi terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
