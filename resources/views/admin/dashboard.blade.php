@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
<style>
/* ── Stat Cards ─────────────────────────────── */
.dash-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}
.dash-stats-row2 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}
.dstat {
    border-radius: 16px;
    padding: 1.4rem 1.5rem;
    color: white;
    position: relative;
    overflow: hidden;
    min-height: 110px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.dstat::after {
    content: '';
    position: absolute;
    right: -18px; bottom: -18px;
    width: 100px; height: 100px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
}
.dstat::before {
    content: '';
    position: absolute;
    right: 20px; bottom: -30px;
    width: 70px; height: 70px;
    border-radius: 50%;
    background: rgba(255,255,255,0.08);
}
.dstat-label { font-size: 0.8rem; font-weight: 500; opacity: 0.9; margin-bottom: 0.3rem; }
.dstat-value { font-size: 2rem; font-weight: 800; line-height: 1; }
.dstat-sub   { font-size: 0.75rem; opacity: 0.8; margin-top: 0.4rem; }
.dstat-icon  { position: absolute; top: 1rem; right: 1.25rem; font-size: 1.4rem; opacity: 0.25; }
.dstat-badge {
    position: absolute; top: 1rem; right: 1.25rem;
    background: rgba(255,255,255,0.2);
    font-size: 0.72rem; font-weight: 700;
    padding: 0.15rem 0.5rem; border-radius: 20px;
    display: flex; align-items: center; gap: 0.25rem;
}

/* ── Charts Row ─────────────────────────────── */
.dash-charts {
    display: grid;
    grid-template-columns: 1fr 1.1fr 1.2fr;
    gap: 1.25rem;
    margin-bottom: 1.5rem;
}

/* ── Bottom Row ─────────────────────────────── */
.dash-bottom {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 1.25rem;
}

/* Donut center text */
.donut-wrap { position: relative; display: flex; align-items: center; justify-content: center; }
.donut-center {
    position: absolute;
    text-align: center;
    pointer-events: none;
}
.donut-center-pct  { font-size: 1.6rem; font-weight: 800; color: #1e293b; line-height: 1; }
.donut-center-label{ font-size: 0.7rem; color: #64748b; margin-top: 0.2rem; }

.legend-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
.legend-row { display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; color: #475569; }
.legend-count { font-weight: 700; color: #0f172a; margin-left: auto; }

/* activity */
.act-item { display: flex; gap: 0.75rem; padding: 0.9rem 0; border-bottom: 1px solid #f1f5f9; }
.act-item:last-child { border-bottom: none; }
.act-icon { width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.85rem; }
.act-name { font-size: 0.85rem; font-weight: 600; color: #0f172a; margin-bottom: 0.15rem; }
.act-desc { font-size: 0.78rem; color: #64748b; line-height: 1.4; }
.act-time { font-size: 0.72rem; color: #94a3b8; margin-top: 0.25rem; display: block; }

@media (max-width: 1100px) {
    .dash-stats { grid-template-columns: repeat(2, 1fr); }
    .dash-stats-row2 { grid-template-columns: repeat(2, 1fr); }
    .dash-charts { grid-template-columns: 1fr; }
    .dash-bottom { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="page-header" style="margin-bottom: 1.5rem;">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p style="color: #64748b; font-size: 0.82rem; margin-top: 0.2rem;">
            {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMM YYYY') }}
        </p>
    </div>
</div>

{{-- ── Row 1: 4 stat cards ─────────────────────────── --}}
<div class="dash-stats">
    <div class="dstat" style="background: var(--primary-blue);">
        <div class="dstat-badge"><i class="fa-solid fa-building"></i></div>
        <div>
            <div class="dstat-label">Total Perusahaan</div>
            <div class="dstat-value">{{ $totalCompanies }}</div>
        </div>
    </div>

    <div class="dstat" style="background: var(--primary-blue);">
        <div class="dstat-badge"><i class="fa-solid fa-users"></i></div>
        <div>
            <div class="dstat-label">Total Peserta</div>
            <div class="dstat-value">{{ $totalParticipants }}</div>
            <div class="dstat-sub">Kapasitas 250 kursi</div>
        </div>
    </div>

    <div class="dstat" style="background: var(--primary-blue);">
        <div class="dstat-badge"><i class="fa-solid fa-file-signature"></i></div>
        <div>
            <div class="dstat-label">Total Lamaran</div>
            <div class="dstat-value">{{ $totalApplications }}</div>
        </div>
    </div>

    <div class="dstat" style="background: var(--primary-blue);">
        <div class="dstat-badge"><i class="fa-solid fa-user-check"></i></div>
        <div>
            <div class="dstat-label">Peserta Hadir</div>
            <div class="dstat-value">{{ $totalAttended }}</div>
            <div class="dstat-sub">dari {{ $totalParticipants }} terdaftar</div>
        </div>
    </div>
</div>

{{-- ── Row 2: 4 stat cards ─────────────────────────── --}}
<div class="dash-stats">
    <div class="dstat" style="background: var(--primary-blue);">
        <div class="dstat-badge"><i class="fa-solid fa-user-graduate"></i></div>
        <div>
            <div class="dstat-label">Total Lulusan USH</div>
            <div class="dstat-value">{{ $totalParticipantsInternal }}</div>
            <div class="dstat-sub">Hadir: <strong>{{ $totalAttendedInternal }}</strong> orang</div>
        </div>
    </div>

    <div class="dstat" style="background: var(--primary-blue);">
        <div class="dstat-badge"><i class="fa-solid fa-percent"></i></div>
        <div>
            <div class="dstat-label">Tingkat Kehadiran</div>
            <div class="dstat-value">{{ $totalParticipants > 0 ? round(($totalAttended / $totalParticipants) * 100) : 0 }}%</div>
        </div>
    </div>

    <div class="dstat" style="background: var(--primary-blue);">
        <div class="dstat-badge"><i class="fa-solid fa-briefcase"></i></div>
        <div>
            <div class="dstat-label">Peserta Terserap</div>
            <div class="dstat-value">{{ $totalAbsorbed }}</div>
            <div class="dstat-sub">Internal: <strong>{{ $totalAbsorbedInternal }}</strong> | Umum: <strong>{{ $totalAbsorbedExternal }}</strong></div>
        </div>
    </div>

    <div class="dstat" style="background: var(--primary-blue);">
        <div class="dstat-badge"><i class="fa-solid fa-chart-pie"></i></div>
        <div>
            <div class="dstat-label">Tingkat Keteserapan Keseluruhan</div>
            <div class="dstat-value">{{ $totalAttended > 0 ? round(($totalAbsorbed / $totalAttended) * 100) : 0 }}%</div>
        </div>
    </div>
</div>

{{-- ── Charts Row: 3 columns ──────────────────────── --}}
<div class="dash-charts">

    {{-- Donut chart --}}
    <div class="card" style="border-radius:16px;">
        <div class="card-header">
            <div>
                <h2 class="card-title">Diagram Keteserapan Lulusan</h2>
                <p style="font-size:0.75rem;color:#64748b;margin:0;">Berdasarkan status peserta</p>
            </div>
        </div>
        <div class="card-body" style="display:flex;flex-direction:column;align-items:center;padding-top:0.5rem;">
            
            <div style="display: flex; gap: 1rem; width: 100%; justify-content: space-around; margin-bottom: 1rem;">
                <div style="display:flex;flex-direction:column;align-items:center;">
                    <div style="font-size:1.6rem;font-weight:800;color:#4f46e5;line-height:1;margin-bottom:0.1rem;">
                        {{ $totalAttendedInternal > 0 ? round(($totalAbsorbedInternal / $totalAttendedInternal) * 100) : 0 }}%
                    </div>
                    <div style="font-size:0.65rem;color:#64748b;margin-bottom:0.5rem;text-align:center;">Lulusan USH</div>
                    <canvas id="internalDonutChart" style="max-height:140px;max-width:140px;"></canvas>
                </div>
                
                <div style="display:flex;flex-direction:column;align-items:center;">
                    <div style="font-size:1.6rem;font-weight:800;color:#0ea5e9;line-height:1;margin-bottom:0.1rem;">
                        {{ $totalAttendedExternal > 0 ? round(($totalAbsorbedExternal / $totalAttendedExternal) * 100) : 0 }}%
                    </div>
                    <div style="font-size:0.65rem;color:#64748b;margin-bottom:0.5rem;text-align:center;">Umum</div>
                    <canvas id="externalDonutChart" style="max-height:140px;max-width:140px;"></canvas>
                </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:0.4rem;width:100%;font-size:0.75rem;">
                <div class="legend-row" style="margin-bottom: 0.2rem;">
                    <span class="legend-dot" style="background:#4f46e5;"></span>
                    <span style="font-weight: 600;">Lulusan USH Terserap</span>
                    <span class="legend-count">{{ $totalAbsorbedInternal }}</span>
                </div>
                <div class="legend-row" style="margin-bottom: 0.2rem;">
                    <span class="legend-dot" style="background:#0ea5e9;"></span>
                    <span style="font-weight: 600;">Umum Terserap</span>
                    <span class="legend-count">{{ $totalAbsorbedExternal }}</span>
                </div>
                <div class="legend-row">
                    <span class="legend-dot" style="background:#10b981;"></span>
                    Hadir, Belum Diterima
                    <span class="legend-count">{{ $totalAttended - $totalAbsorbed }}</span>
                </div>
                <div class="legend-row">
                    <span class="legend-dot" style="background:#e2e8f0;"></span>
                    Tidak Hadir (Total)
                    <span class="legend-count">{{ $totalParticipants - $totalAttended }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Bar chart --}}
    <div class="card" style="border-radius:16px;grid-column: span 2;">
        <div class="card-header">
            <div>
                <h2 class="card-title">Keteserapan Per Perusahaan</h2>
                <p style="font-size:0.75rem;color:#64748b;margin:0;">Perbandingan pelamar vs diterima</p>
            </div>
        </div>
        <div class="card-body" style="height: 400px;">
            <canvas id="absorptionBarChart"></canvas>
        </div>
    </div>

</div>

{{-- ── Bottom Row: table + activity ──────────────── --}}
<div class="dash-bottom">
    {{-- Companies table --}}
    <div class="card" style="border-radius:16px;">
        <div class="card-header">
            <div>
                <h2 class="card-title">Perusahaan Terdaftar Terbaru</h2>
                <p style="font-size:0.75rem;color:#64748b;margin:0;">{{ $recentCompanies->count() }} perusahaan terakhir bergabung</p>
            </div>
            <a href="{{ route('companies.index') }}" class="btn btn-primary" style="padding:0.4rem 0.9rem;font-size:0.8rem;display:flex;align-items:center;gap:0.4rem;">
                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        <div class="card-body table-responsive" style="padding:0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Perusahaan</th>
                        <th>Posisi</th>
                        <th>Lamaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentCompanies as $company)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.6rem;">
                                @if($company->logo_path)
                                    <img src="{{ $company->logo_path ? asset('storage/' . $company->logo_path) : asset('images/default-company-logo.png') }}" alt="{{ $company->name }}"
                                         style="width:32px;height:32px;border-radius:8px;object-fit:contain;border:1px solid #e2e8f0;flex-shrink:0;">
                                @else
                                    <div style="width:32px;height:32px;border-radius:8px;background:linear-gradient(135deg,#2563eb,#7c3aed);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.8rem;flex-shrink:0;">
                                        {{ strtoupper(substr($company->name,0,1)) }}
                                    </div>
                                @endif
                                <strong style="font-size:0.875rem;">{{ $company->name }}</strong>
                            </div>
                        </td>
                        <td style="font-size:0.8rem;">
                            @foreach($company->positions->take(2) as $pos)
                                <span style="background:#eff6ff;color:#1d4ed8;padding:0.15rem 0.5rem;border-radius:4px;font-size:0.75rem;margin-right:0.25rem;">{{ $pos->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.5rem;">
                                <div style="height:5px;border-radius:3px;background:#e2e8f0;flex:1;">
                                    <div style="height:5px;border-radius:3px;background:linear-gradient(90deg,#2563eb,#7c3aed);width:{{ min(100, ($company->applications_count / max(1, $totalApplications)) * 100 * 4) }}%;"></div>
                                </div>
                                <span style="font-weight:700;font-size:0.85rem;min-width:20px;">{{ $company->applications_count }}</span>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('companies.edit', $company->id) }}" style="color:#2563eb;margin-right:8px;"><i class="fa-solid fa-pen-to-square"></i></a>
                            <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus perusahaan ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" style="color:#e11d48;background:none;border:none;cursor:pointer;padding:0;"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;padding:2rem;color:#64748b;">Belum ada perusahaan terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Activity --}}
    <div class="card" style="border-radius:16px;">
        <div class="card-header">
            <div>
                <h2 class="card-title">Aktivitas Terbaru</h2>
                <p style="font-size:0.75rem;color:#64748b;margin:0;">Event hari ini</p>
            </div>
        </div>
        <div class="card-body" style="padding-top:0;">
            @forelse($recentActivities as $activity)
            <div class="act-item">
                <div class="act-icon" style="background:#eff6ff;color:#2563eb;">
                    <i class="fa-solid fa-file-arrow-up"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div class="act-name">Lamaran Masuk</div>
                    <div class="act-desc">
                        <strong>{{ $activity->participant->name ?? $activity->participant->nik }}</strong>
                        melamar ke <strong>{{ $activity->position->company->name ?? '-' }}</strong> — {{ $activity->position->name ?? '' }}
                    </div>
                    <span class="act-time">{{ \Carbon\Carbon::parse($activity->created_at)->locale('id')->diffForHumans() }}</span>
                </div>
            </div>
            @empty
            <div style="padding:2rem 0;text-align:center;color:#94a3b8;font-size:0.875rem;">
                <i class="fa-regular fa-clock" style="font-size:1.5rem;display:block;margin-bottom:0.5rem;"></i>
                Belum ada aktivitas lamaran.
            </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Donut Internal
    new Chart(document.getElementById('internalDonutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Terserap', 'Hadir ', 'Tidak Hadir'],
            datasets: [{
                data: [{{ $totalAbsorbedInternal }}, {{ $totalAttendedInternal - $totalAbsorbedInternal }}, {{ $totalParticipantsInternal - $totalAttendedInternal }}],
                backgroundColor: ['#4f46e5', '#10b981', '#e2e8f0'],
                borderColor: ['#4338ca', '#059669', '#cbd5e1'],
                borderWidth: 1,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => {
                            const total = {{ $totalParticipantsInternal }};
                            const pct = total > 0 ? Math.round((ctx.parsed / total) * 100) : 0;
                            return ` ${ctx.label}: ${ctx.parsed} (${pct}%)`;
                        }
                    }
                }
            }
        }
    });

    // Donut External
    new Chart(document.getElementById('externalDonutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Terserap', 'Hadir  ', 'Tidak Hadir'],
            datasets: [{
                data: [{{ $totalAbsorbedExternal }}, {{ $totalAttendedExternal - $totalAbsorbedExternal }}, {{ $totalParticipantsExternal - $totalAttendedExternal }}],
                backgroundColor: ['#0ea5e9', '#10b981', '#e2e8f0'],
                borderColor: ['#0284c7', '#059669', '#cbd5e1'],
                borderWidth: 1,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            cutout: '65%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => {
                            const total = {{ $totalParticipantsExternal }};
                            const pct = total > 0 ? Math.round((ctx.parsed / total) * 100) : 0;
                            return ` ${ctx.label}: ${ctx.parsed} (${pct}%)`;
                        }
                    }
                }
            }
        }
    });

    // Bar
    new Chart(document.getElementById('absorptionBarChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($companyLabels) !!},
            datasets: [
                {
                    label: 'Pelamar',
                    data: {!! json_encode($companyApplicationCounts) !!},
                    backgroundColor: 'rgba(99,102,241,0.15)',
                    borderColor: '#6366f1',
                    borderWidth: 1.5,
                    borderRadius: 6,
                },
                {
                    label: 'Diterima (Lulusan USH)',
                    data: {!! json_encode($companyAcceptedInternalCounts) !!},
                    backgroundColor: '#4f46e5',
                    borderColor: '#4338ca',
                    borderWidth: 1,
                    borderRadius: 6,
                },
                {
                    label: 'Diterima (Umum)',
                    data: {!! json_encode($companyAcceptedExternalCounts) !!},
                    backgroundColor: '#0ea5e9',
                    borderColor: '#0284c7',
                    borderWidth: 1,
                    borderRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'top', labels: { font: { size: 12 }, boxWidth: 12, usePointStyle: true } },
                tooltip: {
                    callbacks: {
                        afterLabel: ctx => {
                            if (ctx.datasetIndex === 1 || ctx.datasetIndex === 2) {
                                const lamar = ctx.chart.data.datasets[0].data[ctx.dataIndex];
                                const diterima = ctx.parsed.y;
                                return lamar > 0 ? `Keteserapan: ${Math.round((diterima/lamar)*100)}% dari total pelamar` : '';
                            }
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { maxRotation: 45, minRotation: 45, font: { size: 10 } } },
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f8fafc' } }
            }
        }
    });
</script>
@endpush
@endsection
