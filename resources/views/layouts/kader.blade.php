<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Posyandu Kader</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>
    
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Inter', sans-serif;
        }
        body {
            font-family: var(--font-sans);
            background-color: #f8fafc;
        }
        
        /* Custom Premium Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }

        /* Glassmorphism Header */
        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        /* Animasi Dropdown Super Mulus */
        @keyframes menuPop {
            0% { opacity: 0; transform: scale(0.95) translateY(-10px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }
        .animate-pop {
            animation: menuPop 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            transform-origin: top right;
        }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    @stack('styles')
</head>
<body class="text-slate-800 antialiased selection:bg-indigo-100 selection:text-indigo-900">

    <div id="mobileOverlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden transition-opacity duration-300 opacity-0"></div>

    <aside id="sidebar" class="fixed top-0 left-0 h-full w-[280px] bg-white border-r border-slate-200 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
        
        <div class="h-20 flex items-center px-6 border-b border-slate-100/80 shrink-0">
            <div class="flex items-center gap-3 w-full">
                <div class="w-10 h-10 rounded-[12px] bg-gradient-to-br from-indigo-500 to-indigo-600 text-white flex items-center justify-center shadow-[0_4px_12px_rgba(79,70,229,0.3)] shrink-0">
                    <i class="fas fa-heart-pulse text-lg"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl font-black text-slate-900 tracking-tight truncate">Posyandu<span class="text-indigo-600">Ku</span></h1>
                </div>
                <button id="closeSidebar" class="lg:hidden w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="p-5 pb-2 shrink-0">
            <div class="p-3.5 bg-slate-50 border border-slate-100 rounded-2xl flex items-center gap-3 hover:border-indigo-100 hover:bg-indigo-50/30 transition-colors cursor-pointer" onclick="document.getElementById('userDropdownBtn').click()">
                <div class="w-10 h-10 bg-indigo-100 text-indigo-700 rounded-xl flex items-center justify-center font-bold shrink-0">
                    {{ strtoupper(substr(Auth::user()->profile->full_name ?? Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->profile->full_name ?? Auth::user()->name }}</p>
                    <p class="text-[11px] text-slate-500 font-semibold flex items-center gap-1.5 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_0_2px_rgba(16,185,129,0.2)] animate-pulse"></span>
                        Kader Aktif
                    </p>
                </div>
            </div>
        </div>
        
        <nav class="flex-1 overflow-y-auto px-4 py-4 scroll-smooth">
            @include('partials.sidebar.kader')
        </nav>
    </aside>

    <div class="lg:ml-[280px] min-h-screen flex flex-col transition-all duration-300 relative">
        
        <header class="h-20 glass-header border-b border-slate-200/80 sticky top-0 z-30 flex items-center justify-between px-4 sm:px-6 lg:px-8">
            
            <div class="flex items-center gap-4">
                <button id="menuToggle" class="lg:hidden w-10 h-10 flex items-center justify-center text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-colors">
                    <i class="fas fa-bars-staggered"></i>
                </button>
                
                <nav class="hidden sm:flex items-center gap-2 text-sm font-semibold">
                    <a href="{{ route('kader.dashboard') }}" class="text-slate-400 hover:text-indigo-600 transition-colors">
                        <i class="fas fa-home"></i>
                    </a>
                    <i class="fas fa-chevron-right text-slate-300 text-[10px]"></i>
                    <span class="text-slate-700">@yield('page-name', 'Dashboard')</span>
                </nav>
            </div>
            
            <div class="flex items-center gap-1 sm:gap-3 relative">
                
                <div class="hidden md:flex items-center bg-slate-100/80 hover:bg-white transition-colors rounded-full px-4 py-2.5 w-64 border border-slate-200/60 focus-within:bg-white focus-within:border-indigo-300 focus-within:ring-4 focus-within:ring-indigo-50 shadow-inner mr-2">
                    <i class="fas fa-search text-slate-400 text-sm"></i>
                    <input type="text" placeholder="Cari warga posyandu..." class="bg-transparent border-none outline-none text-sm w-full ml-3 placeholder:text-slate-400 font-semibold text-slate-700">
                </div>
                
                <a href="{{ route('kader.import.index') }}" class="hidden sm:flex w-10 h-10 items-center justify-center text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition-all" title="Import Data Excel">
                    <i class="fas fa-file-import text-lg"></i>
                </a>

                <div class="static sm:relative">
                    <button id="notifDropdownBtn" class="relative w-10 h-10 flex items-center justify-center text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition-all">
                        <i class="fas fa-bell text-[19px]"></i>
                        <span id="notifBadge" class="absolute top-2 right-2 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white animate-pulse"></span>
                    </button>
                    
                    <div id="notifDropdown" class="hidden absolute top-20 right-4 w-[calc(100vw-2rem)] sm:top-auto sm:right-0 sm:mt-3 sm:w-80 bg-white rounded-2xl shadow-[0_12px_40px_-10px_rgba(0,0,0,0.15)] border border-slate-100 z-50 animate-pop">
                        <div class="px-5 py-4 border-b border-slate-50 flex justify-between items-center bg-slate-50/50 rounded-t-2xl">
                            <h3 class="text-sm font-bold text-slate-800">Notifikasi Terbaru</h3>
                            <span id="notifCount" class="text-[10px] font-extrabold bg-rose-100 text-rose-600 px-2 py-0.5 rounded-full uppercase tracking-wider transition-colors">2 Baru</span>
                        </div>
                        
                        <div id="notifList" class="max-h-72 overflow-y-auto custom-scrollbar">
                            <a href="{{ route('kader.import.history') }}" class="flex gap-3 px-5 py-4 hover:bg-slate-50 transition-colors border-b border-slate-50/50 group">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-file-excel text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[13px] font-bold text-slate-800 leading-tight">Data Excel Berhasil Diimpor</p>
                                    <p class="text-[12px] text-slate-500 mt-1 leading-snug">Data lansia bulan ini berhasil masuk ke dalam sistem utama.</p>
                                    <p class="text-[10px] font-bold text-indigo-500 mt-2"><i class="fas fa-clock mr-1"></i> Baru saja</p>
                                </div>
                            </a>
                            <a href="{{ route('kader.jadwal.index') }}" class="flex gap-3 px-5 py-4 hover:bg-slate-50 transition-colors border-b border-slate-50/50 group">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                    <i class="fas fa-calendar-check text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[13px] font-bold text-slate-800 leading-tight">Jadwal Posyandu Mendekat</p>
                                    <p class="text-[12px] text-slate-500 mt-1 leading-snug">Persiapkan layanan posyandu balita untuk esok hari jam 08:00.</p>
                                    <p class="text-[10px] font-bold text-slate-400 mt-2"><i class="fas fa-clock mr-1"></i> 2 jam yang lalu</p>
                                </div>
                            </a>
                        </div>
                        
                        <div class="px-5 py-3 text-center bg-white rounded-b-2xl border-t border-slate-50">
                            <button type="button" id="markAllReadBtn" class="w-full text-[11px] font-bold text-slate-500 hover:text-indigo-600 transition-colors uppercase tracking-wider">Tandai semua dibaca</button>
                        </div>
                    </div>
                </div>
                
                <div class="static sm:relative ml-1">
                    <button id="userDropdownBtn" class="w-10 h-10 rounded-full ring-2 ring-slate-200 overflow-hidden hover:ring-indigo-300 transition-all flex items-center justify-center bg-indigo-50 text-indigo-700 font-bold shadow-sm">
                        {{ strtoupper(substr(Auth::user()->profile->full_name ?? Auth::user()->name, 0, 1)) }}
                    </button>
                    
                    <div id="userDropdown" class="hidden absolute top-20 right-4 w-[calc(100vw-2rem)] sm:top-auto sm:right-0 sm:mt-3 sm:w-64 bg-white rounded-2xl shadow-[0_12px_40px_-10px_rgba(0,0,0,0.15)] border border-slate-100 z-50 animate-pop">
                        <div class="px-5 py-4 border-b border-slate-50 bg-slate-50/50 rounded-t-2xl">
                            <p class="text-[14px] font-bold text-slate-800 truncate">{{ Auth::user()->profile->full_name ?? Auth::user()->name }}</p>
                            <p class="text-[11px] text-slate-500 font-semibold truncate mt-0.5">{{ Auth::user()->email ?? 'Kader Posyandu' }}</p>
                        </div>
                        
                        <div class="p-2 space-y-1">
                            <a href="{{ route('kader.profile.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/50 rounded-xl transition-colors">
                                <i class="fas fa-user-circle w-5 text-center text-slate-400"></i> Profil & Kontak
                            </a>
                            <a href="{{ route('kader.profile.password') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-slate-600 hover:text-indigo-600 hover:bg-indigo-50/50 rounded-xl transition-colors">
                                <i class="fas fa-shield-alt w-5 text-center text-slate-400"></i> Ganti Password
                            </a>
                        </div>
                        
                        <div class="p-2 border-t border-slate-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-sm font-bold text-rose-600 hover:bg-rose-50 rounded-xl transition-colors">
                                    <i class="fas fa-sign-out-alt w-5 text-center"></i> Keluar Sistem
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </header>

        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full relative z-0">
            
            @foreach (['success' => ['bg-emerald-50', 'text-emerald-800', 'text-emerald-500', 'fa-check-circle', 'border-emerald-200'], 
                       'error' => ['bg-rose-50', 'text-rose-800', 'text-rose-500', 'fa-circle-exclamation', 'border-rose-200']] as $msg => $classes)
                @if(session($msg))
                    <div class="mb-6 px-5 py-4 {{ $classes[0] }} border {{ $classes[4] }} rounded-2xl flex items-center justify-between shadow-sm animate-[slideDown_0.4s_ease-out]">
                        <div class="flex items-center gap-3">
                            <i class="fas {{ $classes[3] }} {{ $classes[2] }} text-xl"></i>
                            <span class="{{ $classes[1] }} text-[13px] sm:text-sm font-bold">{{ session($msg) }}</span>
                        </div>
                        <button onclick="this.parentElement.style.display='none'" class="{{ $classes[2] }} hover:opacity-70 transition-opacity p-2">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
            @endforeach

            @yield('content')
            
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            const menuToggle = document.getElementById('menuToggle');
            const closeSidebar = document.getElementById('closeSidebar');
            
            // 1. Sidebar Logic (Mobile)
            const toggleSidebar = () => {
                const isOpen = !sidebar.classList.contains('-translate-x-full');
                if (isOpen) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.remove('opacity-100');
                    setTimeout(() => overlay.classList.add('hidden'), 300);
                    document.body.classList.remove('overflow-hidden');
                } else {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    setTimeout(() => overlay.classList.add('opacity-100'), 10);
                    document.body.classList.add('overflow-hidden');
                }
            };

            if (menuToggle) menuToggle.addEventListener('click', toggleSidebar);
            if (closeSidebar) closeSidebar.addEventListener('click', toggleSidebar);
            if (overlay) overlay.addEventListener('click', toggleSidebar);

            // 2. Dropdown Logic (Profil & Notifikasi)
            const userBtn = document.getElementById('userDropdownBtn');
            const userMenu = document.getElementById('userDropdown');
            const notifBtn = document.getElementById('notifDropdownBtn');
            const notifMenu = document.getElementById('notifDropdown');
            
            if (userBtn && userMenu) {
                userBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userMenu.classList.toggle('hidden');
                    if(notifMenu) notifMenu.classList.add('hidden'); 
                });
            }

            if (notifBtn && notifMenu) {
                notifBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    notifMenu.classList.toggle('hidden');
                    if(userMenu) userMenu.classList.add('hidden'); 
                });
            }

            // Tutup dropdown bila klik di luar
            document.addEventListener('click', (e) => {
                if (userMenu && !userMenu.contains(e.target) && !userBtn.contains(e.target)) {
                    userMenu.classList.add('hidden');
                }
                if (notifMenu && !notifMenu.contains(e.target) && !notifBtn.contains(e.target)) {
                    notifMenu.classList.add('hidden');
                }
            });
            
            if(notifMenu) notifMenu.addEventListener('click', (e) => e.stopPropagation());
            if(userMenu) userMenu.addEventListener('click', (e) => e.stopPropagation());

            // ==========================================
            // 3. LOGIKA INTERAKTIF "TANDAI SEMUA DIBACA"
            // ==========================================
            const markAllReadBtn = document.getElementById('markAllReadBtn');
            const notifList = document.getElementById('notifList');
            const notifBadge = document.getElementById('notifBadge');
            const notifCount = document.getElementById('notifCount');

            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function(e) {
                    e.preventDefault(); // Mencegah reload
                    
                    // A. Hilangkan titik merah kedip-kedip di lonceng
                    if(notifBadge) notifBadge.style.display = 'none';
                    
                    // B. Ubah tulisan merah '2 Baru' menjadi tulisan abu-abu '0 Baru'
                    if(notifCount) {
                        notifCount.textContent = '0 Baru';
                        notifCount.className = 'text-[10px] font-extrabold bg-slate-100 text-slate-400 px-2 py-0.5 rounded-full uppercase tracking-wider transition-colors';
                    }
                    
                    // C. Hapus daftar notifikasi dan tampilkan status kosong dengan efek fade-in
                    if(notifList) {
                        notifList.innerHTML = `
                            <div class="flex flex-col items-center justify-center py-10 text-slate-400 animate-pop">
                                <i class="fas fa-bell-slash text-4xl mb-3 opacity-30"></i>
                                <p class="text-xs font-semibold">Tidak ada notifikasi baru</p>
                            </div>
                        `;
                    }
                    
                    // D. Ubah teks tombol bawah agar tidak bisa dipencet lagi
                    this.textContent = 'Semua telah dibaca';
                    this.classList.remove('hover:text-indigo-600', 'text-slate-500');
                    this.classList.add('text-slate-300', 'cursor-not-allowed');
                    this.disabled = true;
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>