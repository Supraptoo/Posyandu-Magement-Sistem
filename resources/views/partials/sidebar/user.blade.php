<nav class="nav flex-column">
    <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" 
       href="{{ route('user.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    
    <div class="dropdown-divider my-2"></div>
    
    <h6 class="text-muted small">Data Keluarga</h6>
    <a class="nav-link" href="#">
        <i class="fas fa-baby"></i> Anak Balita
    </a>
    <a class="nav-link" href="#">
        <i class="fas fa-child"></i> Remaja
    </a>
    <a class="nav-link" href="#">
        <i class="fas fa-user-friends"></i> Lansia
    </a>
    
    <div class="dropdown-divider my-2"></div>
    
    <h6 class="text-muted small">Riwayat</h6>
    <a class="nav-link" href="#">
        <i class="fas fa-history"></i> Kunjungan
    </a>
    <a class="nav-link" href="#">
        <i class="fas fa-file-medical"></i> Pemeriksaan
    </a>
    
    <div class="dropdown-divider my-2"></div>
    
    <h6 class="text-muted small">Akun</h6>
    {{-- <a class="nav-link" href="{{ route('profile.index') }}">
        <i class="fas fa-user"></i> Profil
    </a> --}}
</nav>