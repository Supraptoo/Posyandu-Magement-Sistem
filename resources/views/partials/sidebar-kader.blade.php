<div class="nav-section-title">Menu Utama</div>
<ul class="list-unstyled">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kader.dashboard') ? 'active' : '' }}" 
           href="{{ route('kader.dashboard') }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
</ul>

<div class="nav-section-title">Kelola Data</div>
<ul class="list-unstyled">
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#collapseBalita">
            <i class="fas fa-baby"></i>
            <span>Data Balita</span>
            <i class="fas fa-angle-down"></i>
        </a>
        <div class="collapse" id="collapseBalita">
            <ul class="list-unstyled">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kader.data.balita.index') ? 'active' : '' }}" 
                       href="{{ route('kader.data.balita.index') }}">
                        <i class="fas fa-list"></i>
                        <span>Daftar Balita</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kader.data.balita.create') ? 'active' : '' }}" 
                       href="{{ route('kader.data.balita.create') }}">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Balita</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#collapseRemaja">
            <i class="fas fa-child"></i>
            <span>Data Remaja</span>
            <i class="fas fa-angle-down"></i>
        </a>
        <div class="collapse" id="collapseRemaja">
            <ul class="list-unstyled">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kader.data.remaja.index') ? 'active' : '' }}" 
                       href="{{ route('kader.data.remaja.index') }}">
                        <i class="fas fa-list"></i>
                        <span>Daftar Remaja</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kader.data.remaja.create') ? 'active' : '' }}" 
                       href="{{ route('kader.data.remaja.create') }}">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Remaja</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#collapseLansia">
            <i class="fas fa-user-friends"></i>
            <span>Data Lansia</span>
            <i class="fas fa-angle-down"></i>
        </a>
        <div class="collapse" id="collapseLansia">
            <ul class="list-unstyled">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kader.data.lansia.index') ? 'active' : '' }}" 
                       href="{{ route('kader.data.lansia.index') }}">
                        <i class="fas fa-list"></i>
                        <span>Daftar Lansia</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kader.data.lansia.create') ? 'active' : '' }}" 
                       href="{{ route('kader.data.lansia.create') }}">
                        <i class="fas fa-plus"></i>
                        <span>Tambah Lansia</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
</ul>

<div class="nav-section-title">Pemeriksaan</div>
<ul class="list-unstyled">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kader.pemeriksaan.index') ? 'active' : '' }}" 
           href="{{ route('kader.pemeriksaan.index') }}">
            <i class="fas fa-stethoscope"></i>
            <span>Daftar Pemeriksaan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kader.pemeriksaan.create') ? 'active' : '' }}" 
           href="{{ route('kader.pemeriksaan.create') }}">
            <i class="fas fa-notes-medical"></i>
            <span>Tambah Pemeriksaan</span>
        </a>
    </li>
</ul>

<div class="nav-section-title">Laporan</div>
<ul class="list-unstyled">
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#collapseLaporan">
            <i class="fas fa-file-alt"></i>
            <span>Generate Laporan</span>
            <i class="fas fa-angle-down"></i>
        </a>
        <div class="collapse" id="collapseLaporan">
            <ul class="list-unstyled">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kader/laporan/balita') ? 'active' : '' }}" 
                       href="{{ route('kader.laporan.balita') }}">
                        <i class="fas fa-baby"></i>
                        <span>Laporan Balita</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kader/laporan/remaja') ? 'active' : '' }}" 
                       href="{{ route('kader.laporan.remaja') }}">
                        <i class="fas fa-child"></i>
                        <span>Laporan Remaja</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kader/laporan/lansia') ? 'active' : '' }}" 
                       href="{{ route('kader.laporan.lansia') }}">
                        <i class="fas fa-user-friends"></i>
                        <span>Laporan Lansia</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kader/laporan/imunisasi') ? 'active' : '' }}" 
                       href="{{ route('kader.laporan.imunisasi') }}">
                        <i class="fas fa-syringe"></i>
                        <span>Laporan Imunisasi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('kader/laporan/kunjungan') ? 'active' : '' }}" 
                       href="{{ route('kader.laporan.kunjungan') }}">
                        <i class="fas fa-calendar-check"></i>
                        <span>Laporan Kunjungan</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
</ul>

<div class="nav-section-title">Aktivitas</div>
<ul class="list-unstyled">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kader.jadwal.*') ? 'active' : '' }}" 
           href="{{ route('kader.jadwal.index') }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Jadwal Posyandu</span>
        </a>
    </li>
</ul>

<div class="nav-section-title">Import Data</div>
<ul class="list-unstyled">
    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#collapseImport">
            <i class="fas fa-file-import"></i>
            <span>Import Data</span>
            <i class="fas fa-angle-down"></i>
        </a>
        <div class="collapse" id="collapseImport">
            <ul class="list-unstyled">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kader.import.index') ? 'active' : '' }}" 
                       href="{{ route('kader.import.index') }}">
                        <i class="fas fa-upload"></i>
                        <span>Upload Data</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kader.import.history') ? 'active' : '' }}" 
                       href="{{ route('kader.import.history') }}">
                        <i class="fas fa-history"></i>
                        <span>Riwayat Import</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
</ul>

<div class="nav-section-title">Akun</div>
<ul class="list-unstyled">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('kader.profile.index') ? 'active' : '' }}" 
           href="{{ route('kader.profile.index') }}">
            <i class="fas fa-user"></i>
            <span>Profil Saya</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <span>Keluar</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</ul>