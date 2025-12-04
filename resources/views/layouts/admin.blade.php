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
                <div class="notification-wrapper" style="position: relative;">
                    <button class="btn-icon" id="notificationBtn">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge" id="notificationBadge" style="display: none;">0</span>
                    </button>
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-header">
                            <h6 style="margin: 0; font-weight: 600;">Notifikasi</h6>
                            <button type="button" class="btn-link" id="markAllReadBtn" style="font-size: 12px; color: var(--primary-color); background: none; border: none; cursor: pointer;">Tandai Semua Dibaca</button>
                        </div>
                        <div class="notification-list" id="notificationList">
                            <div class="notification-empty">
                                <i class="bi bi-bell-slash" style="font-size: 24px; color: var(--text-muted);"></i>
                                <p style="margin: 8px 0 0; color: var(--text-muted); font-size: 13px;">Tidak ada notifikasi</p>
                            </div>
                        </div>
                        <div class="notification-footer">
                            <a href="{{ route('admin.notifications.index') }}" style="color: var(--primary-color); text-decoration: none; font-size: 13px;">Lihat Semua Notifikasi</a>
                        </div>
                    </div>
                </div>
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
        
        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #ef4444;
            color: white;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 5px;
            border-radius: 10px;
            min-width: 16px;
            text-align: center;
        }
        
        .notification-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 360px;
            max-height: 480px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            z-index: 1000;
            display: none;
            overflow: hidden;
        }
        
        .notification-dropdown.show {
            display: block;
        }
        
        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .notification-list {
            max-height: 340px;
            overflow-y: auto;
        }
        
        .notification-item {
            display: flex;
            gap: 12px;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .notification-item:hover {
            background: var(--bg-body);
        }
        
        .notification-item.unread {
            background: rgba(79, 70, 229, 0.05);
        }
        
        .notification-item .icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        
        .notification-item .icon.mobile {
            background: #dbeafe;
            color: #2563eb;
        }
        
        .notification-item .icon.web {
            background: #dcfce7;
            color: #16a34a;
        }
        
        .notification-item .content {
            flex: 1;
            min-width: 0;
        }
        
        .notification-item .title {
            font-weight: 600;
            font-size: 13px;
            color: var(--text-main);
            margin-bottom: 2px;
        }
        
        .notification-item .message {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .notification-item .time {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 4px;
        }
        
        .notification-empty {
            padding: 40px 20px;
            text-align: center;
        }
        
        .notification-footer {
            padding: 12px 16px;
            text-align: center;
            border-top: 1px solid var(--border-color);
        }
        
        @media(max-width: 480px) {
            .notification-dropdown {
                width: 300px;
                right: -60px;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBtn = document.getElementById('notificationBtn');
            const notificationDropdown = document.getElementById('notificationDropdown');
            const notificationBadge = document.getElementById('notificationBadge');
            const notificationList = document.getElementById('notificationList');
            const markAllReadBtn = document.getElementById('markAllReadBtn');
            
            function formatTimeAgo(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diffMs = now - date;
                const diffMins = Math.floor(diffMs / 60000);
                const diffHours = Math.floor(diffMs / 3600000);
                const diffDays = Math.floor(diffMs / 86400000);
                
                if (diffMins < 1) return 'Baru saja';
                if (diffMins < 60) return diffMins + ' menit lalu';
                if (diffHours < 24) return diffHours + ' jam lalu';
                if (diffDays < 7) return diffDays + ' hari lalu';
                return date.toLocaleDateString('id-ID');
            }
            
            function loadNotifications() {
                fetch('{{ route("admin.notifications.unread") }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (data.unread_count > 0) {
                                notificationBadge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                                notificationBadge.style.display = 'block';
                            } else {
                                notificationBadge.style.display = 'none';
                            }
                            
                            if (data.notifications.length > 0) {
                                notificationList.innerHTML = data.notifications.map(n => `
                                    <div class="notification-item ${!n.is_read ? 'unread' : ''}" data-id="${n.id}" data-link="${n.link || ''}">
                                        <div class="icon ${n.source}">
                                            <i class="bi ${n.icon || 'bi-bell'}"></i>
                                        </div>
                                        <div class="content">
                                            <div class="title">${n.title}</div>
                                            <div class="message">${n.message}</div>
                                            <div class="time">
                                                <i class="bi ${n.source === 'mobile' ? 'bi-phone' : 'bi-globe'}"></i>
                                                ${formatTimeAgo(n.created_at)}
                                            </div>
                                        </div>
                                    </div>
                                `).join('');
                                
                                document.querySelectorAll('.notification-item').forEach(item => {
                                    item.addEventListener('click', function() {
                                        const id = this.dataset.id;
                                        const link = this.dataset.link;
                                        
                                        fetch(`{{ url('admin/notifications') }}/${id}/read`, {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                'Content-Type': 'application/json'
                                            }
                                        }).then(() => {
                                            if (link) {
                                                window.location.href = link;
                                            } else {
                                                loadNotifications();
                                            }
                                        });
                                    });
                                });
                            } else {
                                notificationList.innerHTML = `
                                    <div class="notification-empty">
                                        <i class="bi bi-bell-slash" style="font-size: 24px; color: var(--text-muted);"></i>
                                        <p style="margin: 8px 0 0; color: var(--text-muted); font-size: 13px;">Tidak ada notifikasi</p>
                                    </div>
                                `;
                            }
                        }
                    })
                    .catch(err => console.error('Error loading notifications:', err));
            }
            
            notificationBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                notificationDropdown.classList.toggle('show');
                if (notificationDropdown.classList.contains('show')) {
                    loadNotifications();
                }
            });
            
            document.addEventListener('click', function(e) {
                if (!notificationDropdown.contains(e.target) && e.target !== notificationBtn) {
                    notificationDropdown.classList.remove('show');
                }
            });
            
            markAllReadBtn.addEventListener('click', function() {
                fetch('{{ route("admin.notifications.mark-all-read") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(() => loadNotifications());
            });
            
            loadNotifications();
            setInterval(loadNotifications, 30000);
        });
    </script>
    @stack('scripts')
</body>
</html>
