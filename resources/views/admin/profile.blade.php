@extends('layouts.admin')

@section('title', 'Pengaturan Profil')

@push('styles')
<style>
    .profile-layout {
        display: flex;
        gap: 2rem;
        align-items: flex-start;
        max-width: 1000px;
    }
    
    .profile-sidebar {
        flex: 0 0 300px;
    }
    
    .profile-main {
        flex: 1;
    }

    .avatar-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 1.5rem auto;
        border-radius: 50%;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 4px solid white;
        background-color: var(--primary-blue);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 3rem;
        font-weight: 700;
        overflow: hidden;
    }

    .avatar-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-upload-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        text-align: center;
        padding: 0.25rem 0;
        font-size: 0.75rem;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .avatar-wrapper:hover .avatar-upload-overlay {
        opacity: 1;
    }

    .file-input-hidden {
        display: none;
    }

    .profile-info-text {
        text-align: center;
        margin-bottom: 2rem;
    }

    .profile-info-text h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.25rem;
    }

    .profile-info-text p {
        color: #64748b;
        font-size: 0.9rem;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 0.75rem;
    }

    .section-title i {
        color: var(--primary-blue);
    }

    .form-group label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .modern-input {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        color: #0f172a;
        width: 100%;
        transition: all 0.2s ease-in-out;
    }

    .modern-input:focus {
        background-color: #ffffff;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    .modern-input::placeholder {
        color: #94a3b8;
    }
    
    @media (max-width: 768px) {
        .profile-layout {
            flex-direction: column;
        }
        .profile-sidebar {
            flex: 1;
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="page-header" style="margin-bottom: 2rem;">
    <h1 class="page-title">Pengaturan Profil</h1>
    <p style="color: #64748b; margin-top: 0.5rem; font-size: 0.95rem;">Kelola informasi pribadi dan keamanan akun Anda di sini.</p>
</div>

@if(session('success'))
<div style="background-color: #f0fdf4; color: #166534; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 2rem; border: 1px solid #bbf7d0; display: flex; align-items: center; gap: 0.75rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
    <i class="fa-solid fa-circle-check" style="font-size: 1.25rem;"></i> 
    <span style="font-weight: 500;">{{ session('success') }}</span>
</div>
@endif

<form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="profile-layout">
        
        <!-- Sidebar Profil -->
        <div class="profile-sidebar">
            <div class="card">
                <div class="card-body" style="padding: 2rem 1.5rem;">
                    
                    <div class="avatar-wrapper" onclick="document.getElementById('avatar-upload').click()">
                        @if($admin->avatar)
                            <img src="{{ asset('storage/' . $admin->avatar) }}" alt="Avatar" id="avatar-preview">
                        @else
                            <span id="avatar-initials">{{ strtoupper(substr($admin->name, 0, 1)) }}</span>
                            <img src="" alt="Avatar" id="avatar-preview" style="display: none;">
                        @endif
                        <div class="avatar-upload-overlay">
                            <i class="fa-solid fa-camera"></i> Ubah
                        </div>
                    </div>
                    <input type="file" name="avatar" id="avatar-upload" class="file-input-hidden" accept="image/*" onchange="previewImage(this)">
                    
                    <div class="profile-info-text">
                        <h3>{{ $admin->name }}</h3>
                        <p>Administrator</p>
                    </div>

                    <div style="background: #f8fafc; border-radius: 8px; padding: 1rem; border: 1px solid #e2e8f0;">
                        <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 0.5rem; display: flex; justify-content: space-between;">
                            <span>Status Akun</span>
                            <span style="color: #10b981; font-weight: 600;"><i class="fa-solid fa-circle" style="font-size: 0.5rem; margin-right: 0.25rem;"></i> Aktif</span>
                        </p>
                        <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 0; display: flex; justify-content: space-between;">
                            <span>Tipe Akses</span>
                            <span style="font-weight: 600; color: #475569;">Full Admin</span>
                        </p>
                    </div>
                    
                    @error('avatar')
                        <div style="color: #ef4444; font-size: 0.85rem; margin-top: 1rem; text-align: center; background: #fef2f2; padding: 0.5rem; border-radius: 6px;">
                            <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                        </div>
                    @enderror

                </div>
            </div>
        </div>

        <!-- Form Edit -->
        <div class="profile-main">
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-body" style="padding: 2rem;">
                    
                    <h2 class="section-title">
                        <i class="fa-regular fa-id-badge"></i> Informasi Dasar
                    </h2>

                    <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                        <div class="form-group" style="margin: 0;">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="modern-input @error('name') is-invalid @enderror" value="{{ old('name', $admin->name) }}" placeholder="Contoh: Budi Santoso" required>
                            @error('name')
                                <small style="color: #ef4444; margin-top: 0.5rem; display: block;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group" style="margin: 0;">
                            <label for="email">Alamat Email</label>
                            <input type="email" name="email" id="email" class="modern-input @error('email') is-invalid @enderror" value="{{ old('email', $admin->email) }}" placeholder="contoh@jobfair.com" required>
                            @error('email')
                                <small style="color: #ef4444; margin-top: 0.5rem; display: block;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <h2 class="section-title">
                        <i class="fa-solid fa-shield-halved"></i> Keamanan & Kata Sandi
                    </h2>
                    
                    

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1rem;">
                        <div class="form-group" style="margin: 0;">
                            <label for="password">Kata Sandi Baru</label>
                            <input type="password" name="password" id="password" class="modern-input @error('password') is-invalid @enderror" placeholder="Minimal 8 karakter...">
                            @error('password')
                                <small style="color: #ef4444; margin-top: 0.5rem; display: block;"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group" style="margin: 0;">
                            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="modern-input" placeholder="Ulangi kata sandi baru...">
                        </div>
                    </div>

                </div>
                
                <div class="card-footer" style="padding: 1.5rem 2rem; background: #f8fafc; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; border-radius: 0 0 12px 12px;">
                    <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>

    </div>
</form>

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                const initials = document.getElementById('avatar-initials');
                
                preview.src = e.target.result;
                preview.style.display = 'block';
                
                if (initials) {
                    initials.style.display = 'none';
                }
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
