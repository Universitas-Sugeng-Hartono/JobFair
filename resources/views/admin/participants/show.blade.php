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
                    <td>{{ $application->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        <button type="button" class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;" onclick="document.getElementById('modal-{{ $application->id }}').style.display='flex'">
                            <i class="fa-solid fa-list-check"></i> Lihat Form
                        </button>
                    </td>
                </tr>

                <!-- Modal for this application -->
                <div id="modal-{{ $application->id }}" style="display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.6); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
                    <div style="background: white; border-radius: 12px; width: 100%; max-width: 600px; max-height: 90vh; display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                        <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0;">Data Lamaran: {{ $application->position->company->name }}</h3>
                            <button type="button" onclick="document.getElementById('modal-{{ $application->id }}').style.display='none'" style="background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #64748b;"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <div style="padding: 1.5rem; overflow-y: auto;">
                            @if($application->answers->count() > 0)
                                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                                    @foreach($application->answers as $answer)
                                        <div style="background: #f8fafc; padding: 1rem; border-radius: 8px; border: 1px solid #f1f5f9;">
                                            <div style="font-size: 0.8rem; font-weight: 600; color: #64748b; margin-bottom: 0.25rem;">
                                                {{ $answer->field_label }}
                                            </div>
                                            <div style="font-size: 0.95rem; color: #0f172a; font-weight: 500;">
                                                @if($answer->field_type === 'file')
                                                    @if($answer->file_path)
                                                        <div style="display: flex; gap: 1rem; margin-top: 0.5rem;">
                                                            <a href="{{ asset('storage/' . $answer->file_path) }}" target="_blank" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">
                                                                <i class="fa-solid fa-eye"></i> Lihat File
                                                            </a>
                                                            <a href="{{ asset('storage/' . $answer->file_path) }}" download class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.8rem;">
                                                                <i class="fa-solid fa-download"></i> Unduh
                                                            </a>
                                                        </div>
                                                    @else
                                                        <span style="color: #94a3b8; font-style: italic;">Tidak ada file dilampirkan</span>
                                                    @endif
                                                @else
                                                    {{ $answer->field_value ?? '-' }}
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p style="color: #64748b; font-style: italic; font-size: 0.9rem; text-align: center; padding: 2rem 0;">Peserta ini tidak mengisi form tambahan apapun.</p>
                            @endif
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
