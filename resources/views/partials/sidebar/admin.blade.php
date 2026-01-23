<nav class="nav flex-column">
    <!-- Dashboard -->
    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
       href="{{ route('admin.dashboard') }}">
        <i class="fas fa-tachometer-alt"></i> Dashboard Admin
    </a>
    
    <div class="dropdown-divider my-2"></div>
    
    <!-- MANAJEMEN AKSES USER -->
    <h6 class="text-muted small px-3">Manajemen Akses</h6>
    
    <!-- User Warga (Login dengan NIK) -->
    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
       href="{{ route('admin.users.index') }}">
        <i class="fas fa-user-circle"></i> Warga
        <small class="badge bg-info ms-auto">NIK Login</small>
    </a>
    
    <!-- Kader Posyandu -->
    <a class="nav-link {{ request()->routeIs('admin.kaders.*') ? 'active' : '' }}" 
       href="{{ route('admin.kaders.index') }}">
        <i class="fas fa-user-nurse"></i> Kader
        <small class="badge bg-warning ms-auto">Email Login</small>
    </a>
    
    <!-- Bidan -->
    <a class="nav-link {{ request()->routeIs('admin.bidans.*') ? 'active' : '' }}" 
       href="{{ route('admin.bidans.index') }}">
        <i class="fas fa-user-md"></i> Bidan
        <small class="badge bg-success ms-auto">Email Login</small>
    </a>
    
    <div class="dropdown-divider my-2"></div>
    
    <!-- PENGATURAN SISTEM -->
    <h6 class="text-muted small px-3">Pengaturan</h6>
    
    <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" 
       href="{{ route('admin.settings.index') }}">
        <i class="fas fa-cog"></i> Pengaturan Sistem
    </a>
    
    <!-- Backup Database (opsional) -->
    <a class="nav-link" href="#" onclick="alert('Fitur backup akan segera tersedia')">
        <i class="fas fa-database"></i> Backup Data
    </a>
</nav>

<style>
    .text-muted.small {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
        color: rgba(255, 255, 255, 0.5) !important;
    }
    
    .dropdown-divider {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin: 0.75rem 1rem;
    }
    
    .nav-link .badge {
        font-size: 0.6rem;
        padding: 0.2rem 0.4rem;
    }
</style>
