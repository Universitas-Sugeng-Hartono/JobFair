<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - JobFair</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .dropdown { position: relative; display: inline-block; }
        .dropdown-menu {
            display: none; position: absolute; right: 0; top: 100%; background: white; min-width: 280px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border-radius: 8px; border: 1px solid #e2e8f0;
            z-index: 100; margin-top: 0.5rem; overflow: hidden;
        }
        .dropdown.active .dropdown-menu { display: block; }
        
        /* Notif item */
        .notif-item { padding: 1rem; border-bottom: 1px solid #f1f5f9; display: flex; gap: 0.75rem; transition: background 0.2s; text-decoration: none; color: inherit; }
        .notif-item:hover { background: #f8fafc; }
        .notif-item:last-child { border-bottom: none; }
        .notif-icon { width: 32px; height: 32px; background: #eff6ff; color: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        
        /* Profile Menu item */
        .profile-menu-item { padding: 0.75rem 1rem; display: flex; align-items: center; gap: 0.75rem; color: #475569; text-decoration: none; transition: background 0.2s; }
        .profile-menu-item:hover { background: #f1f5f9; color: #0f172a; }
        .profile-menu-item.danger { color: #e11d48; }
        .profile-menu-item.danger:hover { background: #ffe4e6; }
        
        /* Fix for giant pagination SVGs when Tailwind is not loaded */
        nav[role="navigation"] svg { width: 1.25rem; height: 1.25rem; }
        nav[role="navigation"] p { margin-top: 1rem; margin-bottom: 1rem; }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand" style="justify-content: center; padding: 1.5rem 1rem;">
            <img src="{{ asset('template/LOGO USH NEW.png') }}" alt="Logo USH" style="max-height: 50px; width: auto;">
        </div>
        
        <div class="sidebar-menu">
            <div class="sidebar-menu-title">Menu Utama</div>
            <a href="/admin" class="sidebar-link {{ request()->is('admin') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a href="{{ route('companies.index') }}" class="sidebar-link {{ request()->is('admin/companies*') ? 'active' : '' }}">
                <i class="fa-solid fa-building"></i> Perusahaan
            </a>
            <a href="{{ route('positions.index') }}" class="sidebar-link {{ request()->is('admin/positions*') ? 'active' : '' }}">
                <i class="fa-solid fa-briefcase"></i> Lowongan
            </a>
            <a href="{{ route('participants.index') }}" class="sidebar-link {{ request()->is('admin/participants*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Peserta
            </a>
            <a href="{{ route('attendance.index') }}" class="sidebar-link {{ request()->is('admin/attendance*') ? 'active' : '' }}">
                <i class="fa-solid fa-qrcode"></i> Manajemen Presensi
            </a>
            
            <div class="sidebar-menu-title" style="margin-top: 1.5rem;">Laporan</div>
            
            <a href="{{ route('export.index') }}" class="sidebar-link {{ request()->is('admin/export*') ? 'active' : '' }}">
                <i class="fa-solid fa-file-export"></i> Ekspor Data
            </a>
            
            <div class="sidebar-menu-title" style="margin-top: 1.5rem;">Pengaturan</div>
            <a href="{{ route('settings.index') }}" class="sidebar-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i> Settings
            </a>
            
        </div>
    </aside>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div style="display: flex; align-items: center;">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="search-bar">
                    <i class="fa-solid fa-magnifying-glass" style="color: var(--text-muted);"></i>
                    <input type="text" placeholder="Cari perusahaan atau peserta...">
                </div>
            </div>
            
            <div class="top-navbar-right">
                
                @php
                    $latestNotifs = \App\Models\Application::with(['participant', 'position.company'])->latest()->take(3)->get();
                    $adminUser = \App\Models\User::first();
                    $adminName = $adminUser ? $adminUser->name : 'Admin Utama';
                    $adminEmail = $adminUser ? $adminUser->email : 'admin@jobfair.com';
                    $adminInitials = strtoupper(substr($adminName, 0, 1));
                    $adminAvatar = $adminUser && $adminUser->avatar ? asset('storage/' . $adminUser->avatar) : null;
                @endphp

                <!-- Notifications Dropdown -->
                <div class="dropdown" id="notifDropdown">
                    <button class="notification-btn" onclick="toggleDropdown('notifDropdown')">
                        <i class="fa-regular fa-bell"></i>
                        @if($latestNotifs->count() > 0)
                            <span class="notification-badge">{{ $latestNotifs->count() }}</span>
                        @endif
                    </button>
                    <div class="dropdown-menu">
                        <div style="padding: 1rem; font-weight: 600; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                            <span>Notifikasi</span>
                        </div>
                        <div style="max-height: 300px; overflow-y: auto;">
                            @forelse($latestNotifs as $notif)
                            <a href="{{ route('participants.show', $notif->participant_id) }}" class="notif-item">
                                <div class="notif-icon"><i class="fa-solid fa-file-arrow-up"></i></div>
                                <div>
                                    <p style="font-size: 0.85rem; font-weight: 600; margin-bottom: 0.2rem; color: #0f172a;">Lamaran Baru</p>
                                    <p style="font-size: 0.8rem; color: #64748b; line-height: 1.4;">{{ $notif->participant->name ?? 'Peserta' }} melamar ke {{ $notif->position->company->name ?? '-' }}.</p>
                                    <small style="font-size: 0.7rem; color: #94a3b8; display: block; margin-top: 0.25rem;">{{ \Carbon\Carbon::parse($notif->created_at)->locale('id')->diffForHumans() }}</small>
                                </div>
                            </a>
                            @empty
                            <div style="padding: 2rem 1rem; text-align: center; color: #64748b; font-size: 0.85rem;">Tidak ada notifikasi baru.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- Profile Dropdown -->
                <div class="dropdown" id="profileDropdown">
                    <div class="user-profile" style="cursor: pointer;" onclick="toggleDropdown('profileDropdown')">
                        <div class="user-info" style="text-align: right;">
                            <div class="user-name">{{ $adminName }}</div>
                            <div class="user-role">Administrator</div>
                        </div>
                        <div class="user-avatar" style="overflow: hidden; padding: 0;">
                            @if($adminAvatar)
                                <img src="{{ $adminAvatar }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ $adminInitials }}
                            @endif
                        </div>
                        <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; color: #64748b; margin-left: 0.25rem;"></i>
                    </div>
                    <div class="dropdown-menu" style="min-width: 200px;">
                        <div style="padding: 1rem; border-bottom: 1px solid #f1f5f9;">
                            <div style="font-weight: 600; color: #0f172a; font-size: 0.9rem;">{{ $adminName }}</div>
                            <div style="font-size: 0.8rem; color: #64748b;">{{ $adminEmail }}</div>
                        </div>
                        <a href="{{ route('admin.profile') }}" class="profile-menu-item">
                            <i class="fa-solid fa-user" style="width: 20px;"></i> Profil Saya
                        </a>
                        <a href="{{ route('settings.index') }}" class="profile-menu-item">
                            <i class="fa-solid fa-gear" style="width: 20px;"></i> Pengaturan
                        </a>
                        <div style="border-top: 1px solid #f1f5f9; margin: 0.25rem 0;"></div>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="profile-menu-item danger" style="width: 100%; border: none; background: none; cursor: pointer; text-align: left; font-family: inherit;">
                                <i class="fa-solid fa-right-from-bracket" style="width: 20px;"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.sidebar-overlay').classList.toggle('active');
        }

        function toggleDropdown(id) {
            // Close all dropdowns first
            document.querySelectorAll('.dropdown').forEach(d => {
                if(d.id !== id) d.classList.remove('active');
            });
            // Toggle clicked dropdown
            document.getElementById(id).classList.toggle('active');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('active'));
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
