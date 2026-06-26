@extends('layouts.admin')

@section('title', 'Detail Peserta')

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 class="page-title">Detail Peserta: {{ $participant->name ?? $participant->nik }}</h1>
        <p style="color: #64748b; margin-top: 0.5rem; font-size: 0.9rem;">Daftar lamaran yang dikirim oleh peserta ini.</p>
    </div>
    <a href="{{ route('participants.index') }}" class="btn btn-outline">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<div style="display: flex; gap: 2rem; margin-bottom: 2rem;">
    <!-- Info Peserta -->
    <div class="card" style="flex: 1;">
        <div class="card-header">
            <h2 class="card-title">Informasi Peserta</h2>
        </div>
        <div class="card-body">
            <table class="table" style="border:none;">
                <tr>
                    <td style="width: 150px; font-weight: 600; border-bottom: 1px solid #f1f5f9;">Nama Lengkap</td>
                    <td style="border-bottom: 1px solid #f1f5f9;">{{ $participant->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 600; border-bottom: 1px solid #f1f5f9;">NIK</td>
                    <td style="border-bottom: 1px solid #f1f5f9;">{{ $participant->nik }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 600; border-bottom: 1px solid #f1f5f9;">Waktu Daftar</td>
                    <td style="border-bottom: 1px solid #f1f5f9;">{{ $participant->created_at->format('d F Y, H:i') }}</td>
                </tr>
                <tr>
                    <td style="font-weight: 600; border-bottom: 1px solid #f1f5f9;">Total Lamaran</td>
                    <td style="border-bottom: 1px solid #f1f5f9;">
                        <strong>{{ $participant->applications->count() }}</strong> / 12 (Maksimal)
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- Daftar Lamaran -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Riwayat Lamaran</h2>
    </div>
    <div class="card-body table-responsive" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Perusahaan</th>
                    <th>Posisi yang Dilamar</th>
                    <th>Status</th>
                    <th>Waktu Melamar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($participant->applications as $index => $application)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $application->position->company->name }}</strong>
                    </td>
                    <td>{{ $application->position->name ?? '-' }}</td>
                    <td>
                        @if($application->status === 'accepted')
                            <span style="background:#dcfce7;color:#166534;padding:0.25rem 0.6rem;border-radius:6px;font-size:0.8rem;font-weight:600;">
                                <i class="fa-solid fa-circle-check"></i> Diterima
                            </span>
                        @elseif($application->status === 'rejected')
                            <span style="background:#fee2e2;color:#991b1b;padding:0.25rem 0.6rem;border-radius:6px;font-size:0.8rem;font-weight:600;">
                                <i class="fa-solid fa-circle-xmark"></i> Ditolak
                            </span>
                        @elseif($application->status === 'reviewed')
                            <span style="background:#dbeafe;color:#1d4ed8;padding:0.25rem 0.6rem;border-radius:6px;font-size:0.8rem;font-weight:600;">
                                <i class="fa-solid fa-users-viewfinder"></i> Sedang Interview
                            </span>
                        @else
                            <span style="background:#f1f5f9;color:#475569;padding:0.25rem 0.6rem;border-radius:6px;font-size:0.8rem;font-weight:600;">
                                <i class="fa-regular fa-clock"></i> Menunggu
                            </span>
                        @endif
                    </td>
                    <td>{{ $application->created_at->format('d M Y, H:i') }}</td>
                    <td style="display:flex;gap:0.4rem;flex-wrap:wrap;">
                        <button type="button" class="btn btn-outline" style="padding: 0.35rem 0.7rem; font-size: 0.8rem;" onclick="document.getElementById('modal-{{ $application->id }}').style.display='flex'">
                            <i class="fa-solid fa-list-check"></i> Lihat Form
                        </button>

                    </td>
                </tr>

                <!-- Modal for this application -->
                <div id="modal-{{ $application->id }}" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
                    <div style="background: white; border-radius: 12px; width: 100%; max-width: 700px; max-height: 90vh; display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                        <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0;">Data Lamaran: {{ $application->position->company->name }}</h3>
                            <button type="button" onclick="document.getElementById('modal-{{ $application->id }}').style.display='none'" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #64748b;"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <div style="padding: 1.5rem; overflow-y: auto;">
                            <div style="background:#f8fafc; padding:1.5rem; margin-top:1.5rem; border-radius:8px;">
                                <h5 style="margin-top:0; color:#334155; font-size:0.9rem; margin-bottom:1rem; border-bottom:1px solid #e2e8f0; padding-bottom:0.5rem;">Data Tambahan (Form Builder)</h5>
                                @php
                                    $payload = $application->answers_payload ?? [];
                                @endphp
                                @if(count($payload) > 0)
                                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                                        @foreach($payload as $answer)
                                            @if(isset($answer['type']) && $answer['type'] === 'step')
                                                <div style="grid-column: 1 / -1; margin-top: 0.5rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem;">
                                                    <h6 style="font-size: 0.95rem; font-weight: 700; color: #0f172a; margin: 0;">{{ $answer['label'] }}</h6>
                                                </div>
                                            @else
                                                <div>
                                                    <div style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 0.25rem;">{{ $answer['label'] }}</div>
                                                    @if(isset($answer['type']) && $answer['type'] === 'file' && !empty($answer['path']))
                                                        @php
                                                            $paths = explode(',', $answer['path']);
                                                        @endphp
                                                        @foreach($paths as $path)
                                                            <a href="{{ asset('storage/' . trim($path)) }}" target="_blank" class="btn btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.75rem; display:inline-flex; align-items:center; gap:0.25rem; margin-right: 0.25rem; margin-bottom: 0.25rem;">
                                                                <i class="fa-solid fa-download"></i> Lihat File
                                                            </a>
                                                        @endforeach
                                                    @else
                                                        <div style="font-size: 0.875rem; color: #0f172a;">{{ $answer['value'] ?? '-' }}</div>
                                                    @endif
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p style="font-size: 0.875rem; color: #94a3b8; margin: 0;">Tidak ada data tambahan.</p>
                                @endif
                            </div>
                        </div>
                        <div style="padding: 1rem 1.5rem; border-top: 1px solid #e2e8f0; text-align: right;">
                            <button type="button" class="btn btn-outline" onclick="document.getElementById('modal-{{ $application->id }}').style.display='none'">Tutup</button>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="4" class="text-center" style="padding: 2rem; color: #64748b;">Peserta ini belum melamar ke perusahaan mana pun.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
