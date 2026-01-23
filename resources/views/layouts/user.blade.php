<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM Posyandu - @yield('title', 'Dashboard User')</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary: #06D6A0;
            --primary-dark: #048B69;
            --primary-light: #E8FFF8;
            --secondary: #118AB2;
            --accent: #FFD166;
            --danger: #EF476F;
            --dark: #073B4C;
            --gray: #8B9DA9;
            --gray-light: #F7F9FB;
            --white: #FFFFFF;
            --shadow-sm: 0 2px 8px rgba(7, 59, 76, 0.04);
            --shadow-md: 0 4px 16px rgba(7, 59, 76, 0.08);
            --radius-md: 16px;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f8f9fa;
            color: var(--dark);
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: var(--white);
            border-right: 1px solid #e9ecef;
            padding: 20px 0;
            z-index: 100;
            overflow-y: auto;
            transition: all 0.3s;
        }

        .sidebar-logo {
            padding: 0 20px 20px;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 20px;
        }

        .sidebar-logo h4 {
            color: var(--primary-dark);
            font-weight: 700;
            margin-bottom: 5px;
        }

        .sidebar-logo p {
            color: var(--gray);
            font-size: 12px;
            margin: 0;
        }

        .nav-link {
            padding: 12px 20px;
            color: var(--dark);
            font-weight: 500;
            border-left: 3px solid transparent;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link:hover {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            border-left-color: var(--primary);
        }

        .nav-link.active {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            border-left-color: var(--primary);
            font-weight: 600;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
        }

        .section-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gray);
            padding: 15px 20px 10px;
            font-weight: 600;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        .top-header {
            background: var(--white);
            border-bottom: 1px solid #e9ecef;
            padding: 15px 30px;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-light);
        }

        .welcome-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        .stat-card {
            background: var(--white);
            border-radius: var(--radius-md);
            border: none;
            box-shadow: var(--shadow-sm);
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .schedule-card {
            background: var(--white);
            border-left: 4px solid var(--primary);
            border-radius: var(--radius-md);
        }

        .chart-container {
            background: var(--white);
            border-radius: var(--radius-md);
            padding: 20px;
            box-shadow: var(--shadow-sm);
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: var(--dark);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-toggle {
                display: block;
            }

            .top-header {
                padding: 15px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <h4>SIM Posyandu</h4>
            <p>Dashboard User</p>
        </div>

        <div class="section-title">Menu Utama</div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" 
               href="{{ route('user.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            
            {{-- <a class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}" 
               href="{{ route('user.profile') }}">
                <i class="fas fa-user"></i>
                Profil Saya
            </a> --}}
        </nav>

        {{-- <div class="section-title">Data Keluarga</div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('user.balita') ? 'active' : '' }}" 
               href="{{ route('user.balita') }}">
                <i class="fas fa-baby"></i>
                Anak Balita
            </a>
            <a class="nav-link {{ request()->routeIs('user.remaja') ? 'active' : '' }}" 
               href="{{ route('user.remaja') }}">
                <i class="fas fa-child"></i>
                Remaja
            </a>
            <a class="nav-link {{ request()->routeIs('user.lansia') ? 'active' : '' }}" 
               href="{{ route('user.lansia') }}">
                <i class="fas fa-user-friends"></i>
                Lansia
            </a>
        </nav>

        <div class="section-title">Riwayat Kesehatan</div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('user.kunjungan') ? 'active' : '' }}" 
               href="{{ route('user.kunjungan') }}">
                <i class="fas fa-history"></i>
                Kunjungan
            </a>
            <a class="nav-link {{ request()->routeIs('user.pemeriksaan') ? 'active' : '' }}" 
               href="{{ route('user.pemeriksaan') }}">
                <i class="fas fa-file-medical"></i>
                Pemeriksaan
            </a>
            <a class="nav-link {{ request()->routeIs('user.imunisasi') ? 'active' : '' }}" 
               href="{{ route('user.imunisasi') }}">
                <i class="fas fa-syringe"></i>
                Imunisasi
            </a>
        </nav> --}}

        {{-- <div class="section-title">Jadwal</div>
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('user.jadwal') ? 'active' : '' }}" 
               href="{{ route('user.jadwal') }}">
                <i class="fas fa-calendar-alt"></i>
                Jadwal Posyandu
            </a>
            <a class="nav-link {{ request()->routeIs('user.notifikasi') ? 'active' : '' }}" 
               href="{{ route('user.notifikasi') }}">
                <i class="fas fa-bell"></i>
                Notifikasi
            </a>
        </nav> --}}

        <div class="mt-auto p-3">
            <div class="d-grid gap-2">
                <a href="{{ route('logout') }}" class="btn btn-outline-danger" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt me-2"></i>Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <header class="top-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="menu-toggle me-3" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0 fw-bold">@yield('page-title', 'Dashboard')</h5>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-link text-dark text-decoration-none d-flex align-items-center gap-2" 
                            type="button" data-bs-toggle="dropdown">
                        @if(auth()->user()->profile && auth()->user()->profile->foto)
                            <img src="{{ asset('storage/' . auth()->user()->profile->foto) }}" 
                                 alt="User" class="user-avatar">
                        @else
                            <div class="user-avatar bg-primary text-white d-flex align-items-center justify-content-center">
                                {{ substr(auth()->user()->username ?: auth()->user()->email, 0, 1) }}
                            </div>
                        @endif
                        <div class="text-start">
                            <div class="fw-bold">{{ auth()->user()->profile->full_name ?? auth()->user()->username ?? 'User' }}</div>
                            <small class="text-muted">{{ auth()->user()->role }}</small>
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    {{-- <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('user.profile') }}"><i class="fas fa-user me-2"></i>Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i>Keluar
                            </a>
                        </li>
                    </ul> --}}
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Mobile menu toggle
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
    </script>

    @stack('scripts')
</body>
</html>