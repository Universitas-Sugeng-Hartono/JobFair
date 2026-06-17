<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Perusahaan') - JobFair</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .dropdown { position: relative; display: inline-block; }
        .dropdown-menu {
            display: none; position: absolute; right: 0; top: 100%; background: white; min-width: 220px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border-radius: 8px; border: 1px solid #e2e8f0;
            z-index: 100; margin-top: 0.5rem; overflow: hidden;
        }
        .dropdown.active .dropdown-menu { display: block; }
        .profile-menu-item { padding: 0.75rem 1rem; display: flex; align-items: center; gap: 0.75rem; color: #475569; text-decoration: none; transition: background 0.2s; }
        .profile-menu-item:hover { background: #f1f5f9; color: #0f172a; }
        .profile-menu-item.danger { color: #e11d48; }
        .profile-menu-item.danger:hover { background: #ffe4e6; }
        nav[role="navigation"] svg { width: 1.25rem; height: 1.25rem; }
        nav[role="navigation"] p { margin-top: 1rem; margin-bottom: 1rem; }

        /* Company sidebar accent color - teal */
        .sidebar { background: linear-gradient(180deg, #0f2847 0%, #1e3a5f 100%); }
        .sidebar-brand { border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-link.active { background: rgba(20, 184, 166, 0.15); color: #14b8a6; border-left-color: #14b8a6; }
        .sidebar-link:hover:not(.active) { background: rgba(255,255,255,0.07); }
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
            <div class="sidebar-menu-title">Menu Perusahaan</div>
            <a href="{{ route('company.dashboard') }}" class="sidebar-link {{ request()->is('perusahaan/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a href="{{ route('company.applicants') }}" class="sidebar-link {{ request()->is('perusahaan/pelamar*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Daftar Pelamar
            </a>
        </div>
    </aside>

    <!-- Sidebar Overlay (mobile) -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Main Content -->
    <div class="main-wrapper">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button class="mobile-toggle" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <span style="font-weight: 700; color: var(--text-primary); font-size: 0.95rem; display: block;">
                        Portal Perusahaan
                    </span>
                    <span style="font-size: 0.75rem; color: var(--text-muted);">
                        {{ session('company_name', 'Perusahaan') }}
                    </span>
                </div>
            </div>

            <div class="top-navbar-right">
                <div class="dropdown" id="profileDropdown">
                    <div class="user-profile" style="cursor: pointer; display: flex; align-items: center; gap: 0.75rem;" onclick="toggleDropdown('profileDropdown')">
                        <div class="user-info" style="text-align: right;">
                            <div class="user-name">{{ session('company_name', '-') }}</div>
                            <div class="user-role">Perusahaan Mitra</div>
                        </div>
                        <div class="user-avatar" style="background: linear-gradient(135deg, #14b8a6, #0f766e); font-size: 1.1rem; color: white; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 0;">
                            @if(session('company_logo'))
                                <img src="{{ asset('storage/' . session('company_logo')) }}" alt="Logo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            @else
                                <i class="fa-solid fa-building"></i>
                            @endif
                        </div>
                        <i class="fa-solid fa-chevron-down" style="font-size: 0.7rem; color: #64748b;"></i>
                    </div>
                    <div class="dropdown-menu" style="min-width: 200px;">
                        <div style="padding: 1rem; border-bottom: 1px solid #f1f5f9;">
                            <div style="font-weight: 600; color: #0f172a; font-size: 0.9rem;">{{ session('company_name', '-') }}</div>
                            <div style="font-size: 0.8rem; color: #64748b;">Perusahaan Mitra JobFair</div>
                        </div>
                        <form action="{{ route('company.logout') }}" method="POST">
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
            @if(session('success'))
            <div style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid #a7f3d0;">
                <i class="fa-solid fa-circle-check" style="margin-right: 0.5rem;"></i> {{ session('success') }}
            </div>
            @endif
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.sidebar-overlay').classList.toggle('active');
        }
        function toggleDropdown(id) {
            document.querySelectorAll('.dropdown').forEach(d => {
                if(d.id !== id) d.classList.remove('active');
            });
            document.getElementById(id).classList.toggle('active');
        }
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown').forEach(d => d.classList.remove('active'));
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
