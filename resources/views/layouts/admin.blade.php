<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Si Basumba</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                <i class="bi bi-grid-fill"></i>
                <span class="sidebar-brand">Si Basumba</span>
            </a>
        </div>

        <div class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="menu-label">Monitoring</div>
            <div class="nav-item">
                <a href="{{ route('admin.wajib-lapor.index') }}" class="nav-link {{ request()->routeIs('admin.wajib-lapor.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Wajib Lapor</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.litmas.index') }}" class="nav-link {{ request()->routeIs('admin.litmas.*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Permohonan LITMAS</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.abh.index') }}" class="nav-link {{ request()->routeIs('admin.abh.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i>
                    <span>Pendampingan ABH</span>
                </a>
            </div>

            <div class="menu-label">Manajemen</div>
            <div class="nav-item">
                <a href="{{ route('admin.klien.index') }}" class="nav-link {{ request()->routeIs('admin.klien.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>
                    <span>Data Klien</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.petugas.index') }}" class="nav-link {{ request()->routeIs('admin.petugas.*') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i>
                    <span>Data PK/APK</span>
                </a>
            </div>

            <div class="menu-label">Master Data</div>
            <div class="nav-item">
                <a href="{{ route('admin.asal-permintaan.index') }}" class="nav-link {{ request()->routeIs('admin.asal-permintaan.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i>
                    <span>Asal Permintaan</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.jenis-litmas.index') }}" class="nav-link {{ request()->routeIs('admin.jenis-litmas.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>
                    <span>Jenis LITMAS</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.instansi-kepolisian.index') }}" class="nav-link {{ request()->routeIs('admin.instansi-kepolisian.*') ? 'active' : '' }}">
                    <i class="bi bi-shield"></i>
                    <span>Instansi Kepolisian</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.alur-pelayanan.index') }}" class="nav-link {{ request()->routeIs('admin.alur-pelayanan.*') ? 'active' : '' }}">
                    <i class="bi bi-signpost-split"></i>
                    <span>Alur Pelayanan</span>
                </a>
            </div>

            @if(auth()->user()->isAdmin())
            <div class="menu-label">Pengaturan</div>
            <div class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Manajemen User</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i>
                    <span>Pengaturan Aplikasi</span>
                </a>
            </div>
            @endif

            <div class="nav-item">
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-left"></i>
                        <span>Logout</span>
                    </a>
                </form>
            </div>
        </div>

        <div class="sidebar-footer">
            <div class="user-profile">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=eef2ff&color=4f46e5" alt="User" class="user-avatar">
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar">
            <button class="btn-icon" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>

            <div class="search-box">
                <i class="bi bi-search" style="color: var(--text-muted)"></i>
                <input type="text" placeholder="Cari...">
            </div>

            <div class="navbar-actions">
                <button class="btn-icon" id="themeToggle">
                    <i class="bi bi-moon"></i>
                </button>
                <button class="btn-icon" id="notificationBtn">
                    <i class="bi bi-bell"></i>
                </button>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="page-content">
            @if(session('success'))
            <div class="alert alert-success" style="background: #d1fae5; border: 1px solid #10b981; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger" style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    <button class="btn-icon mobile-toggle" id="mobileToggle" style="position: fixed; bottom: 20px; right: 20px; background: var(--primary-color); color: white; width: 48px; height: 48px; border-radius: 50%; display: none; z-index: 100; box-shadow: 0 4px 12px rgba(79,70,229,0.3);">
        <i class="bi bi-list"></i>
    </button>

    <style>
        @media(max-width: 768px) { .mobile-toggle { display: flex !important; } }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>
