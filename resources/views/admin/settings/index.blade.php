@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="content-header" style="margin-bottom: 2rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #1e293b;">Pengaturan Halaman Utama</h1>
    <p style="color: #64748b; font-size: 0.875rem; margin-top: 0.5rem;">Atur teks, logo, dan statistik yang akan ditampilkan di halaman landing (Welcome Page).</p>
</div>

@if(session('success'))
    <div style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 500;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

<form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem;">
        
        <!-- Section: Hero Content -->
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                <h2 style="font-size: 1.125rem; font-weight: 600; color: #0f172a;"><i class="fa-solid fa-heading" style="color:#64748b; margin-right:8px;"></i> Konten Hero (Bagian Atas)</h2>
            </div>
            <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem;">
                
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Label / Topik</label>
                    <input type="text" name="hero_label" value="{{ $settings['hero_label'] ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Judul Utama (Title)</label>
                    <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Sub Judul (Subtitle)</label>
                    <input type="text" name="hero_subtitle" value="{{ $settings['hero_subtitle'] ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                </div>
                
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Deskripsi Paragraf</label>
                    <textarea name="hero_description" rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">{{ $settings['hero_description'] ?? '' }}</textarea>
                </div>
                
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Gambar Hero</label>
                    <input type="file" name="hero_image_file" accept="image/*" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                    <small style="color: #64748b; margin-top: 4px; display: block;">Biarkan kosong jika ingin menggunakan gambar default.</small>
                    
                    @if(!empty($settings['hero_image']))
                        <div style="margin-top: 1rem; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1rem; display:inline-block;">
                            <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 8px; text-transform: uppercase; font-weight: 600;">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $settings['hero_image']) }}" alt="Hero Image" style="max-height: 100px; display: block;">
                        </div>
                        <input type="hidden" name="hero_image" value="{{ $settings['hero_image'] }}">
                    @endif
                </div>
                
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Section: Navbar Logo -->
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                    <h2 style="font-size: 1.125rem; font-weight: 600; color: #0f172a;"><i class="fa-solid fa-image" style="color:#64748b; margin-right:8px;"></i> Logo Navbar</h2>
                </div>
                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 1.25rem;">
                    
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Teks Logo</label>
                        <input type="text" name="logo_text" value="{{ $settings['logo_text'] ?? 'JobFair 2026' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Upload Logo (Ikon Gambar)</label>
                        <input type="file" name="logo_image_file" accept="image/*" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                        <small style="color: #64748b; margin-top: 4px; display: block;">Biarkan kosong jika ingin menggunakan ikon default (koper).</small>
                        
                        @if(!empty($settings['logo_image']))
                            <div style="margin-top: 1rem; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1rem; display:inline-block;">
                                <p style="font-size: 0.75rem; color: #64748b; margin-bottom: 8px; text-transform: uppercase; font-weight: 600;">Logo Saat Ini:</p>
                                <img src="{{ asset('storage/' . $settings['logo_image']) }}" alt="Logo" style="max-height: 40px; display: block;">
                            </div>
                            <input type="hidden" name="logo_image" value="{{ $settings['logo_image'] }}">
                        @endif
                    </div>
                </div>
            </div>

            <!-- Section: Statistik Angka -->
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                    <h2 style="font-size: 1.125rem; font-weight: 600; color: #0f172a;"><i class="fa-solid fa-chart-simple" style="color:#64748b; margin-right:8px;"></i> Statistik / Highlights</h2>
                </div>
                <div style="padding: 1.5rem;">
                    
                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem;">
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Angka 1</label>
                            <input type="text" name="stat_1_value" value="{{ $settings['stat_1_value'] ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Label 1</label>
                            <input type="text" name="stat_1_label" value="{{ $settings['stat_1_label'] ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem;">
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Angka 2</label>
                            <input type="text" name="stat_2_value" value="{{ $settings['stat_2_value'] ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Label 2</label>
                            <input type="text" name="stat_2_label" value="{{ $settings['stat_2_label'] ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Angka 3</label>
                            <input type="text" name="stat_3_value" value="{{ $settings['stat_3_value'] ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Label 3</label>
                            <input type="text" name="stat_3_label" value="{{ $settings['stat_3_label'] ?? '' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Section: Detail Informasi Event -->
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                <h2 style="font-size: 1.125rem; font-weight: 600; color: #0f172a;"><i class="fa-solid fa-calendar-days" style="color:#64748b; margin-right:8px;"></i> Detail Informasi Event</h2>
            </div>
            <div style="padding: 1.5rem;">

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Judul Bagian Informasi Event</label>
                    <input type="text" name="event_info_title" value="{{ $settings['event_info_title'] ?? 'Informasi Event' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Tanggal Event</label>
                        <input type="text" name="event_date" value="{{ $settings['event_date'] ?? '3 - 10 Juni 2026' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Keterangan Tanggal</label>
                        <input type="text" name="event_date_desc" value="{{ $settings['event_date_desc'] ?? 'Pendaftaran dibuka selama 1 minggu' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Lokasi Event</label>
                        <input type="text" name="event_location" value="{{ $settings['event_location'] ?? 'Online Platform' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Keterangan Lokasi</label>
                        <input type="text" name="event_location_desc" value="{{ $settings['event_location_desc'] ?? 'Akses dari mana saja, kapan saja' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Waktu Event</label>
                        <input type="text" name="event_time" value="{{ $settings['event_time'] ?? '08.00 WIB - Selesai' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">URL Google Maps (Embed src)</label>
                        <input type="text" name="event_maps_url" value="{{ $settings['event_maps_url'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.9126607212456!2d110.803875!3d-7.5844883!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a15ec7abf2ad3%3A0x6b8dd829dd868cd7!2sUniversitas%20Sugeng%20Hartono!5e0!3m2!1sen!2sid!4v1717462000000!5m2!1sen!2sid' }}" placeholder="Contoh: https://www.google.com/maps/embed?pb=..." style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Info Kuota</label>
                        <input type="text" name="event_quota_title" value="{{ $settings['event_quota_title'] ?? 'Kuota Terbatas' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Keterangan Kuota</label>
                        <input type="text" name="event_quota_desc" value="{{ $settings['event_quota_desc'] ?? 'Hanya 250 peserta yang akan diterima' }}" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">Deskripsi Acara Lengkap</label>
                    <textarea id="summernote" name="event_description" rows="10" placeholder="Ketik deskripsi acara di sini..." style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">{{ $settings['event_description'] ?? '
<p class="mb-4">
    <strong>JobFair Universitas Sugeng Hartono</strong> adalah wadah pertemuan strategis antara para pencari kerja (alumni, mahasiswa tingkat akhir, dan masyarakat umum) dengan perusahaan-perusahaan terkemuka yang sedang mencari talenta terbaik.
</p>
<p class="mb-4">
    Acara ini bertujuan untuk memfasilitasi penyerapan tenaga kerja secara efektif dan efisien. Para peserta dapat berinteraksi langsung dengan perwakilan HR dari berbagai perusahaan, mendapatkan wawasan mengenai dunia kerja, serta melamar posisi yang sesuai dengan minat dan kompetensi mereka.
</p>
<h4 class="text-lg font-semibold text-slate-800 mt-6 mb-3">Mengapa Anda Harus Hadir?</h4>
<ul class="space-y-2 list-disc list-inside">
    <li>Kesempatan emas bertemu langsung dengan HRD.</li>
    <li>Tersedia berbagai pilihan posisi dari perusahaan ternama.</li>
    <li>Proses pendaftaran dan pelamaran yang terintegrasi secara digital.</li>
    <li>Memperluas relasi dan jaringan profesional Anda.</li>
</ul>' }}</textarea>
                </div>

            </div>
        </div>

        <!-- Section: Pengaturan URL Export -->
        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.05); grid-column: 1 / -1;">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                <h2 style="font-size: 1.125rem; font-weight: 600; color: #0f172a;"><i class="fa-solid fa-link" style="color:#64748b; margin-right:8px;"></i> Pengaturan URL Ekspor (Excel)</h2>
            </div>
            <div style="padding: 1.5rem;">
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #334155; margin-bottom: 0.5rem;">URL Production (Akses Online)</label>
                    <input type="url" name="production_url" value="{{ $settings['production_url'] ?? '' }}" placeholder="Contoh: https://jobfair2026.com" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; font-size: 0.875rem;">
                    <small style="color: #64748b; margin-top: 6px; display: block; line-height: 1.5;">
                        <i class="fa-solid fa-circle-info text-blue-500"></i> 
                    </small>
                </div>
            </div>
        </div>

    </div>

    <div style="margin-top: 2rem; display: flex; justify-content: flex-end;">
        <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 600; font-size: 0.875rem; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.5);">
            <i class="fa-solid fa-save"></i> Simpan Pengaturan
        </button>
    </div>

</form>

@endsection

@stack('styles')
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor .note-editing-area { font-family: 'Inter', sans-serif; }
    .note-editor.note-frame { border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden; }
    .note-toolbar { background-color: #f8fafc; border-bottom: 1px solid #cbd5e1; }
</style>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Ketik deskripsi acara di sini...',
            tabsize: 2,
            height: 200,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
@endpush
