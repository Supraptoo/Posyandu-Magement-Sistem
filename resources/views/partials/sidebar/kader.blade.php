@php 
    // Helper function untuk Menu Tunggal
    function activeMenu($routePattern) {
        return request()->routeIs($routePattern) 
            ? 'bg-indigo-600 text-white shadow-[0_4px_12px_rgba(79,70,229,0.25)] ring-1 ring-indigo-500/50' 
            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900';
    }
    
    function activeIcon($routePattern) {
        return request()->routeIs($routePattern) 
            ? 'text-white' 
            : 'text-slate-400 group-hover:text-indigo-500';
    }

    // Helper untuk Menu Induk (Dropdown)
    $isDataWargaActive = request()->routeIs('kader.data.*');
    $isLaporanActive = request()->routeIs('kader.laporan.*');
@endphp

<div class="space-y-6">

    <div>
        <p class="px-3 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 opacity-80">Overview</p>
        <a href="{{ route('kader.dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 font-semibold text-sm {{ activeMenu('kader.dashboard') }}">
            <i class="fas fa-chart-pie w-6 text-center text-[18px] transition-colors {{ activeIcon('kader.dashboard') }}"></i>
            <span>Dashboard</span>
        </a>
    </div>

    <div>
        <p class="px-3 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 opacity-80">Data Warga</p>
        
        <div class="space-y-1">
            <button onclick="toggleSubmenu('menuPasien', 'iconPasien')" class="w-full group flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-300 font-semibold text-sm {{ $isDataWargaActive ? 'text-indigo-600 bg-indigo-50/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-users w-6 text-center text-[18px] transition-colors {{ $isDataWargaActive ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-500' }}"></i>
                    <span>Database Pasien</span>
                </div>
                <i id="iconPasien" class="fas fa-chevron-down text-[10px] transition-transform duration-300 {{ $isDataWargaActive ? 'rotate-180 text-indigo-500' : 'text-slate-400' }}"></i>
            </button>
            
            <div id="menuPasien" class="grid transition-all duration-300 ease-in-out {{ $isDataWargaActive ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0' }}">
                <div class="overflow-hidden">
                    <div class="pl-11 pr-2 py-1 space-y-1">
                        <a href="{{ route('kader.data.balita.index') }}" class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors relative before:content-[''] before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-1.5 before:h-1.5 before:rounded-full {{ request()->routeIs('kader.data.balita*') ? 'text-indigo-700 bg-indigo-50/80 before:bg-indigo-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50 before:bg-slate-300' }}">Balita</a>
                        <a href="{{ route('kader.data.remaja.index') }}" class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors relative before:content-[''] before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-1.5 before:h-1.5 before:rounded-full {{ request()->routeIs('kader.data.remaja*') ? 'text-indigo-700 bg-indigo-50/80 before:bg-indigo-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50 before:bg-slate-300' }}">Remaja</a>
                        <a href="{{ route('kader.data.lansia.index') }}" class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors relative before:content-[''] before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-1.5 before:h-1.5 before:rounded-full {{ request()->routeIs('kader.data.lansia*') ? 'text-indigo-700 bg-indigo-50/80 before:bg-indigo-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50 before:bg-slate-300' }}">Lansia</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <p class="px-3 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 opacity-80">Layanan Medis</p>
        <div class="space-y-1">
            <a href="{{ route('kader.pemeriksaan.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 font-semibold text-sm {{ activeMenu('kader.pemeriksaan*') }}">
                <i class="fas fa-stethoscope w-6 text-center text-[18px] transition-colors {{ activeIcon('kader.pemeriksaan*') }}"></i>
                <span>Pemeriksaan</span>
            </a>
            
            <a href="{{ route('kader.imunisasi.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 font-semibold text-sm {{ activeMenu('kader.imunisasi*') }}">
                <i class="fas fa-syringe w-6 text-center text-[18px] transition-colors {{ activeIcon('kader.imunisasi*') }}"></i>
                <span>Imunisasi</span>
            </a>
            
            <a href="{{ route('kader.kunjungan.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 font-semibold text-sm {{ activeMenu('kader.kunjungan*') }}">
                <i class="fas fa-clipboard-list w-6 text-center text-[18px] transition-colors {{ activeIcon('kader.kunjungan*') }}"></i>
                <span>Buku Tamu</span>
            </a>
        </div>
    </div>

    <div>
        <p class="px-3 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 opacity-80">Manajemen</p>
        <div class="space-y-1">
            <a href="{{ route('kader.jadwal.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-300 font-semibold text-sm {{ activeMenu('kader.jadwal*') }}">
                <i class="fas fa-calendar-alt w-6 text-center text-[18px] transition-colors {{ activeIcon('kader.jadwal*') }}"></i>
                <span>Jadwal Posyandu</span>
            </a>

            <button onclick="toggleSubmenu('menuLaporan', 'iconLaporan')" class="w-full group flex items-center justify-between px-3 py-2.5 rounded-xl transition-all duration-300 font-semibold text-sm {{ $isLaporanActive ? 'text-indigo-600 bg-indigo-50/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-file-contract w-6 text-center text-[18px] transition-colors {{ $isLaporanActive ? 'text-indigo-600' : 'text-slate-400 group-hover:text-indigo-500' }}"></i>
                    <span>Laporan Data</span>
                </div>
                <i id="iconLaporan" class="fas fa-chevron-down text-[10px] transition-transform duration-300 {{ $isLaporanActive ? 'rotate-180 text-indigo-500' : 'text-slate-400' }}"></i>
            </button>
            
            <div id="menuLaporan" class="grid transition-all duration-300 ease-in-out {{ $isLaporanActive ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0' }}">
                <div class="overflow-hidden">
                    <div class="pl-11 pr-2 py-1 space-y-1">
                        <a href="{{ route('kader.laporan.index') }}" class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors relative before:content-[''] before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-1.5 before:h-1.5 before:rounded-full {{ request()->routeIs('kader.laporan.index') ? 'text-indigo-700 bg-indigo-50/80 before:bg-indigo-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50 before:bg-slate-300' }}">Rekap Laporan</a>
                        <a href="{{ route('kader.laporan.balita') }}" class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors relative before:content-[''] before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-1.5 before:h-1.5 before:rounded-full {{ request()->routeIs('kader.laporan.balita') ? 'text-indigo-700 bg-indigo-50/80 before:bg-indigo-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50 before:bg-slate-300' }}">Balita</a>
                        <a href="{{ route('kader.laporan.remaja') }}" class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors relative before:content-[''] before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-1.5 before:h-1.5 before:rounded-full {{ request()->routeIs('kader.laporan.remaja') ? 'text-indigo-700 bg-indigo-50/80 before:bg-indigo-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50 before:bg-slate-300' }}">Remaja</a>
                        <a href="{{ route('kader.laporan.lansia') }}" class="block px-3 py-2 text-sm font-medium rounded-lg transition-colors relative before:content-[''] before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-1.5 before:h-1.5 before:rounded-full {{ request()->routeIs('kader.laporan.lansia') ? 'text-indigo-700 bg-indigo-50/80 before:bg-indigo-600' : 'text-slate-500 hover:text-slate-800 hover:bg-slate-50 before:bg-slate-300' }}">Lansia</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="lg:hidden mt-8 pt-6 border-t border-slate-100 mb-6 px-3">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-rose-50 text-rose-600 rounded-xl font-bold text-sm hover:bg-rose-100 transition-colors">
            <i class="fas fa-sign-out-alt"></i> Keluar Aplikasi
        </button>
    </form>
</div>

<script>
    function toggleSubmenu(menuId, iconId) {
        const menu = document.getElementById(menuId);
        const icon = document.getElementById(iconId);
        
        // Cek apakan grid-rows-[0fr] ada (artinya sedang tertutup)
        if (menu.classList.contains('grid-rows-[0fr]')) {
            menu.classList.remove('grid-rows-[0fr]', 'opacity-0');
            menu.classList.add('grid-rows-[1fr]', 'opacity-100');
            icon.classList.add('rotate-180', 'text-indigo-500');
            icon.classList.remove('text-slate-400');
        } else {
            menu.classList.add('grid-rows-[0fr]', 'opacity-0');
            menu.classList.remove('grid-rows-[1fr]', 'opacity-100');
            icon.classList.remove('rotate-180', 'text-indigo-500');
            icon.classList.add('text-slate-400');
        }
    }
</script>