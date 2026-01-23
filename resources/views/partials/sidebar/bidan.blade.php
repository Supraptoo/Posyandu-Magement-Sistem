<nav class="nav flex-column">
    <a class="nav-link {{ request()->routeIs('bidan.dashboard') ? 'active' : '' }}" 
       href="{{ route('bidan.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard
    </a>
    
    <div class="dropdown-divider my-2"></div>
    
    <h6 class="text-muted small">Pemeriksaan</h6>
    <a class="nav-link {{ request()->routeIs('bidan.pemeriksaan.*') ? 'active' : '' }}" 
       href="{{ route('bidan.pemeriksaan.index') }}">
        <i class="fas fa-stethoscope"></i> Pemeriksaan
    </a>
    
    <div class="dropdown-divider my-2"></div>
    
    <h6 class="text-muted small">Konsultasi</h6>
    <a class="nav-link {{ request()->routeIs('bidan.konsultasi.*') ? 'active' : '' }}" 
       href="{{ route('bidan.konsultasi.index') }}">
        <i class="fas fa-comments"></i> Konsultasi
    </a>
    
    <div class="dropdown-divider my-2"></div>
    
    <h6 class="text-muted small">Data</h6>
    <a class="nav-link" href="#">
        <i class="fas fa-history"></i> Riwayat
    </a>
</nav>