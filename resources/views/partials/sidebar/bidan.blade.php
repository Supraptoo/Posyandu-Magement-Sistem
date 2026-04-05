@php
    $pendingCount = \App\Models\Pemeriksaan::where('status_verifikasi', 'pending')->count();
        
    $activeClass = 'bg-gradient-to-r from-cyan-500 to-blue-600 text-white shadow-[0_8px_16px_rgba(6,182,212,0.25)] transform scale-[1.02] transition-all';
    $inactiveClass = 'text-slate-500 hover:bg-slate-50 hover:text-cyan-700 transition-all border border-transparent hover:border-slate-100';
    
    $activeIconClass = 'text-white';
    $inactiveIconClass = 'text-slate-400 group-hover:text-cyan-500';
    
    // Ganti deteksi route ke Rekam Medis
    $isRekamMedisActive = request()->routeIs('bidan.rekam-medis.*');
    $typeParam = request()->get('type', 'balita');
@endphp

<div class="space-y-7">
    
    {{-- OVERVIEW --}}
    <div>
        <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 opacity-80 font-poppins">Overview</p>
        <a href="{{ route('bidan.dashboard') }}" class="smooth-route group flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-[13px] {{ request()->routeIs('bidan.dashboard') ? $activeClass : $inactiveClass }}">
            <i class="fas fa-th-large w-6 text-center text-[16px] transition-colors {{ request()->routeIs('bidan.dashboard') ? $activeIconClass : $inactiveIconClass }}"></i>
            <span class="font-poppins tracking-wide">Dashboard Utama</span>
        </a>
    </div>

    {{-- LAYANAN KLINIS --}}
    <div>
        <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 opacity-80 font-poppins">Layanan Klinis</p>
        <div class="space-y-2">
            <a href="{{ route('bidan.pemeriksaan.index') }}" class="smooth-route group flex items-center justify-between px-4 py-3 rounded-2xl font-bold text-[13px] {{ request()->routeIs('bidan.pemeriksaan.index') ? $activeClass : $inactiveClass }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-user-md w-6 text-center text-[16px] transition-colors {{ request()->routeIs('bidan.pemeriksaan.index') ? $activeIconClass : $inactiveIconClass }}"></i>
                    <span class="font-poppins tracking-wide">Validasi Medis</span>
                </div>
                @if($pendingCount > 0)
                    <span class="bg-rose-500 text-white text-[10px] font-black px-2.5 py-0.5 rounded-full animate-pulse shadow-[0_0_10px_rgba(244,63,94,0.5)]">{{ $pendingCount }}</span>
                @endif
            </a>

            <a href="{{ route('bidan.pemeriksaan.create') }}" class="smooth-route group flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-[13px] {{ request()->routeIs('bidan.pemeriksaan.create') ? $activeClass : $inactiveClass }}">
                <i class="fas fa-stethoscope w-6 text-center text-[16px] transition-colors {{ request()->routeIs('bidan.pemeriksaan.create') ? $activeIconClass : $inactiveIconClass }}"></i>
                <span class="font-poppins tracking-wide">Input Pemeriksaan</span>
            </a>
            
            <a href="{{ route('bidan.imunisasi.index') }}" class="smooth-route group flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-[13px] {{ request()->routeIs('bidan.imunisasi*') ? $activeClass : $inactiveClass }}">
                <i class="fas fa-shield-virus w-6 text-center text-[16px] transition-colors {{ request()->routeIs('bidan.imunisasi*') ? $activeIconClass : $inactiveIconClass }}"></i>
                <span class="font-poppins tracking-wide">Register Imunisasi</span>
            </a>

            <a href="{{ route('bidan.konseling.index') }}" class="smooth-route group flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-[13px] {{ request()->routeIs('bidan.konseling*') ? $activeClass : $inactiveClass }}">
                <i class="fas fa-comments w-6 text-center text-[16px] transition-colors {{ request()->routeIs('bidan.konseling*') ? $activeIconClass : $inactiveIconClass }}"></i>
                <span class="font-poppins tracking-wide">Konseling Kesehatan</span>
            </a>
        </div>
    </div>

    {{-- PEMANTAUAN PASIEN (Database Terpusat) --}}
    <div>
        <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 opacity-80 font-poppins">Pemantauan Pasien</p>
        <div class="space-y-2">
            <button onclick="toggleSubmenu('menuPasien', 'iconPasien')" class="w-full group flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-300 font-bold text-[13px] border border-transparent {{ $isRekamMedisActive ? 'bg-cyan-50 text-cyan-700 border-cyan-100' : 'text-slate-500 hover:bg-slate-50 hover:text-cyan-700 hover:border-slate-100' }}">
                <div class="flex items-center gap-3">
                    <i class="fas fa-folder-open w-6 text-center text-[16px] transition-colors {{ $isRekamMedisActive ? 'text-cyan-600' : 'text-slate-400 group-hover:text-cyan-500' }}"></i>
                    <span class="font-poppins tracking-wide">Buku Rekam Medis</span>
                </div>
                <i id="iconPasien" class="fas fa-chevron-down text-[10px] transition-transform duration-300 {{ $isRekamMedisActive ? 'rotate-180 text-cyan-600' : 'text-slate-400' }}"></i>
            </button>
            
            <div id="menuPasien" class="grid transition-all duration-300 ease-in-out {{ $isRekamMedisActive ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0' }}">
                <div class="overflow-hidden">
                    <div class="pl-12 pr-2 py-2 space-y-1.5 relative before:absolute before:left-7 before:top-4 before:bottom-4 before:w-px before:bg-slate-200">
                        @foreach([
                            ['type' => 'balita', 'label' => 'Anak & Balita'],
                            ['type' => 'ibu_hamil', 'label' => 'Ibu Hamil'],
                            ['type' => 'remaja', 'label' => 'Usia Remaja'],
                            ['type' => 'lansia', 'label' => 'Lansia (Manula)'],
                        ] as $item)
                            @php $isActive = $isRekamMedisActive && $typeParam == $item['type']; @endphp
                            <a href="{{ route('bidan.rekam-medis.index', ['type' => $item['type']]) }}" class="smooth-route block px-4 py-2.5 text-[12px] font-bold rounded-xl transition-all relative before:absolute before:left-[-22px] before:top-1/2 before:-translate-y-1/2 before:w-2 before:h-2 before:rounded-full {{ $isActive ? 'text-cyan-700 bg-white shadow-sm border border-cyan-100 before:bg-cyan-500 before:ring-4 before:ring-cyan-50' : 'text-slate-500 hover:text-cyan-700 hover:bg-slate-50 before:bg-slate-300' }}">
                                {{ $item['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MANAJEMEN DATA --}}
    <div>
        <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 opacity-80 font-poppins">Manajemen Data</p>
        <div class="space-y-2">
            <a href="{{ route('bidan.jadwal.index') }}" class="smooth-route group flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-[13px] {{ request()->routeIs('bidan.jadwal*') ? $activeClass : $inactiveClass }}">
                <i class="fas fa-calendar-check w-6 text-center text-[16px] transition-colors {{ request()->routeIs('bidan.jadwal*') ? $activeIconClass : $inactiveIconClass }}"></i>
                <span class="font-poppins tracking-wide">Jadwal Posyandu</span>
            </a>
            
            <a href="{{ route('bidan.laporan.index') }}" class="smooth-route group flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-[13px] {{ request()->routeIs('bidan.laporan*') ? $activeClass : $inactiveClass }}">
                <i class="fas fa-file-pdf w-6 text-center text-[16px] transition-colors {{ request()->routeIs('bidan.laporan*') ? $activeIconClass : $inactiveIconClass }}"></i>
                <span class="font-poppins tracking-wide">Cetak Laporan PDF</span>
            </a>
        </div>
    </div>
    
</div>