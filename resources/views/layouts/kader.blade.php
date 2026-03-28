<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kader Workspace') — PosyanduCare</title>
    
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22><rect width=%2224%22 height=%2224%22 rx=%226%22 fill=%22%234f46e5%22/><path d=%22M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z%22 fill=%22white%22/></svg>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>
    
    <style type="text/tailwindcss">
        @theme { 
            --font-sans: 'Inter', sans-serif; 
            --font-poppins: 'Poppins', sans-serif; 
        }
        body { 
            font-family: var(--font-sans); 
            background-color: #f8fafc; 
            background-image: radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.08) 0px, transparent 40%),
                              radial-gradient(at 100% 100%, rgba(139, 92, 246, 0.05) 0px, transparent 40%);
            background-attachment: fixed;
        }
        h1, h2, h3, h4, h5, h6 { font-family: var(--font-poppins); }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        
        .glass-header { 
            background: rgba(255, 255, 255, 0.85); 
            backdrop-filter: blur(20px); 
            -webkit-backdrop-filter: blur(20px);
        }
        .glass-sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        @keyframes menuPop { 0% { opacity: 0; transform: scale(0.95) translateY(-10px); } 100% { opacity: 1; transform: scale(1) translateY(0); } }
        .animate-pop { animation: menuPop 0.2s cubic-bezier(0.16, 1, 0.3, 1) forwards; transform-origin: top right; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    @stack('styles')
</head>
<body class="text-slate-800 antialiased selection:bg-indigo-100 selection:text-indigo-900 flex">

    <div id="globalLoader" class="fixed inset-0 bg-white/90 backdrop-blur-md z-[9999] flex flex-col items-center justify-center transition-all duration-200 opacity-0 pointer-events-none">
        <div class="relative w-20 h-20 flex items-center justify-center mb-5">
            <div class="absolute inset-0 border-4 border-indigo-100 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-indigo-600 rounded-full border-t-transparent animate-spin"></div>
            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm">
                <i class="fas fa-heart-pulse text-indigo-600 text-2xl animate-pulse"></i>
            </div>
        </div>
        <p class="text-indigo-800 font-poppins font-black tracking-[0.25em] text-[10px] uppercase" id="loaderText">MEMUAT RUANG KERJA...</p>
    </div>

    <div id="mobileOverlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden transition-opacity duration-300 opacity-0"></div>

    <aside id="sidebar" class="fixed top-0 left-0 h-screen w-[280px] glass-sidebar border-r border-slate-200/80 z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-out flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.03)] overflow-hidden">
        
        <div class="h-20 flex items-center px-6 border-b border-slate-100/80 shrink-0 relative z-10">
            <div class="flex items-center gap-3 w-full">
                <div class="w-10 h-10 rounded-[12px] bg-gradient-to-br from-indigo-500 to-violet-600 text-white flex items-center justify-center shadow-[0_4px_12px_rgba(79,70,229,0.3)] shrink-0 group-hover:scale-105 transition-transform">
                    <i class="fas fa-heart-pulse text-lg"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl font-black text-slate-800 tracking-tight truncate font-poppins">Kader<span class="text-indigo-600">Care</span></h1>
                </div>
                <button id="closeSidebar" class="lg:hidden w-8 h-8 flex items-center justify-center text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-colors">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="p-5 pb-2 shrink-0 relative z-10">
            <div class="p-3.5 bg-white border border-slate-200 rounded-[20px] flex items-center gap-3 hover:border-indigo-300 hover:shadow-sm transition-all cursor-pointer group" onclick="document.getElementById('userDropdownBtn').click()">
                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-black border border-indigo-100 shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    {{ strtoupper(substr(Auth::user()->profile->full_name ?? Auth::user()->name ?? 'K', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[13px] font-bold text-slate-800 truncate font-poppins leading-tight">{{ Auth::user()->profile->full_name ?? Auth::user()->name ?? 'Kader Posyandu' }}</p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider flex items-center gap-1.5 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_0_2px_rgba(16,185,129,0.2)] animate-pulse"></span>
                        Kader Aktif
                    </p>
                </div>
            </div>
        </div>
        
        <nav class="flex-1 overflow-y-auto px-4 py-4 relative z-10 custom-scrollbar">
            @include('partials.sidebar.kader')
        </nav>
    </aside>

    <div class="flex-1 lg:ml-[280px] min-h-screen flex flex-col w-full relative">
        
        <header class="h-20 glass-header border-b border-white/50 sticky top-0 z-40 flex items-center justify-between px-4 sm:px-6 lg:px-8 shadow-[0_4px_20px_rgba(0,0,0,0.01)]">
            <div class="flex items-center gap-4">
                <button id="menuToggle" class="lg:hidden w-10 h-10 flex items-center justify-center text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-colors shadow-sm bg-white border border-slate-200"><i class="fas fa-bars-staggered"></i></button>
                <nav class="hidden sm:flex items-center gap-2 text-[11px] font-black text-slate-400 uppercase tracking-widest">
                    <a href="{{ route('kader.dashboard') }}" class="hover:text-indigo-600 transition-colors"><i class="fas fa-home text-sm"></i></a>
                    <i class="fas fa-chevron-right text-[8px] text-slate-300 mx-1"></i>
                    <span class="text-indigo-600">@yield('page-name', 'Dashboard')</span>
                </nav>
            </div>
            
            <div class="flex items-center gap-2 sm:gap-4 relative">
                <div class="hidden md:flex items-center bg-white hover:bg-slate-50 transition-colors rounded-2xl px-5 py-2.5 w-64 border border-slate-200 focus-within:bg-white focus-within:border-indigo-300 focus-within:ring-4 focus-within:ring-indigo-50 shadow-sm mr-2">
                    <i class="fas fa-search text-slate-400 text-sm"></i>
                    <input type="text" placeholder="Cari warga posyandu..." class="bg-transparent border-none outline-none text-[13px] w-full ml-3 placeholder:text-slate-400 font-medium text-slate-700">
                </div>
                
                @php
                    $unreadNotifCount = \App\Models\Notifikasi::where('user_id', Auth::id())->where('is_read', false)->count();
                    $latestNotifs = \App\Models\Notifikasi::where('user_id', Auth::id())->latest()->take(5)->get();
                @endphp

                <div class="static sm:relative">
                    <button id="notifDropdownBtn" class="relative w-10 h-10 flex items-center justify-center bg-white text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-full transition-all border border-slate-200 shadow-sm hover:shadow">
                        <i class="fas fa-bell text-[18px]"></i>
                        <span id="notifBadge" class="absolute top-0 right-0 w-3 h-3 bg-rose-500 rounded-full ring-2 ring-white animate-pulse {{ $unreadNotifCount > 0 ? '' : 'hidden' }}"></span>
                    </button>
                    
                    <div id="notifDropdown" class="hidden absolute top-16 right-0 w-[calc(100vw-2rem)] sm:top-auto sm:right-0 sm:mt-3 sm:w-80 bg-white rounded-[24px] shadow-[0_15px_50px_-10px_rgba(0,0,0,0.15)] border border-slate-100 z-50 animate-pop overflow-hidden flex flex-col">
                        <div class="px-5 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50 shrink-0">
                            <h3 class="text-sm font-black text-slate-800 font-poppins">Pusat Notifikasi</h3>
                            <span id="notifCount" class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $unreadNotifCount > 0 ? 'bg-rose-100 text-rose-600' : 'bg-slate-100 text-slate-400' }}">{{ $unreadNotifCount }} Baru</span>
                        </div>
                        
                        <div id="notifList" class="max-h-72 overflow-y-auto custom-scrollbar flex-1">
                            @forelse($latestNotifs as $n)
                                <a href="{{ route('kader.notifikasi.index') }}" class="notif-item {{ $n->is_read ? '' : 'unread' }} flex gap-4 px-5 py-4 hover:bg-slate-50 transition-colors border-b border-slate-100 {{ $n->is_read ? 'bg-white border-l-4 border-l-transparent' : 'bg-indigo-50/40 border-l-4 border-l-indigo-500' }}">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 border {{ $n->is_read ? 'bg-slate-50 text-slate-400 border-slate-200' : 'bg-indigo-100 text-indigo-600 border-indigo-200' }}">
                                        <i class="fas fa-{{ str_contains(strtolower($n->judul), 'jadwal') ? 'calendar-alt' : (str_contains(strtolower($n->judul), 'import') ? 'file-excel' : 'bell') }} text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-[13px] font-bold {{ $n->is_read ? 'text-slate-600' : 'text-slate-800' }} leading-tight font-poppins">{{ $n->judul }}</p>
                                        <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 leading-relaxed">{{ $n->pesan }}</p>
                                    </div>
                                </a>
                            @empty
                                <div class="flex flex-col items-center justify-center py-10 text-slate-400">
                                    <div class="w-14 h-14 bg-slate-50 text-slate-300 rounded-full flex items-center justify-center text-2xl mb-3 border border-slate-100"><i class="fas fa-bell-slash"></i></div>
                                    <p class="text-[11px] font-bold uppercase tracking-widest">Belum ada notifikasi</p>
                                </div>
                            @endforelse
                        </div>
                        
                        <div class="p-3 bg-white border-t border-slate-100 flex flex-col gap-1.5 shrink-0">
                            <div id="markAllContainer" class="{{ $unreadNotifCount > 0 ? 'block' : 'hidden' }}">
                                <form action="{{ route('kader.notifikasi.markAllRead') }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" id="markAllReadBtn" class="w-full py-2.5 text-[12px] font-bold text-slate-500 hover:text-indigo-600 hover:bg-slate-50 rounded-xl transition-colors flex items-center justify-center gap-1.5">
                                        <i class="fas fa-check-double"></i> Tandai Semua Dibaca
                                    </button>
                                </form>
                            </div>
                            <a href="{{ route('kader.notifikasi.index') }}" class="w-full py-2.5 text-[12px] font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 text-center rounded-xl transition-colors">
                                Lihat Semua Notifikasi &rarr;
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="static sm:relative ml-1">
                    <button id="userDropdownBtn" class="flex items-center gap-2 p-1 pr-3 rounded-full bg-white hover:bg-slate-50 transition-colors border border-slate-200 shadow-sm group">
                        <div class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center bg-indigo-100 text-indigo-600 font-bold group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            {{ strtoupper(substr(Auth::user()->profile->full_name ?? Auth::user()->name ?? 'K', 0, 1)) }}
                        </div>
                        <i class="fas fa-chevron-down text-[10px] text-slate-400 group-hover:text-slate-600"></i>
                    </button>

                    <div id="userDropdown" class="hidden absolute top-16 right-0 w-[calc(100vw-2rem)] sm:top-auto sm:right-0 sm:mt-3 sm:w-64 bg-white rounded-[24px] shadow-[0_15px_50px_-10px_rgba(0,0,0,0.1)] border border-slate-100 z-50 animate-pop overflow-hidden">
                        <div class="px-5 py-5 border-b border-slate-50 bg-gradient-to-r from-indigo-50 to-violet-50">
                            <p class="text-[15px] font-black text-slate-800 truncate font-poppins">{{ Auth::user()->profile->full_name ?? Auth::user()->name ?? 'Kader' }}</p>
                            <p class="text-[10px] text-indigo-600 font-bold uppercase tracking-widest mt-1">{{ Auth::user()->email ?? 'kader@posyandu.com' }}</p>
                        </div>
                        <div class="p-2 border-t border-slate-50">
                            <a href="{{ route('kader.profile.index') }}" class="w-full flex items-center gap-3 px-4 py-3 text-[13px] font-bold text-slate-600 hover:bg-slate-50 hover:text-indigo-600 rounded-xl transition-all"><i class="fas fa-user-circle w-4 text-center"></i> Profil Saya</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" onclick="showGlobalLoader('MENGAKHIRI SESI...')" class="w-full flex items-center gap-3 px-4 py-3 text-[13px] font-bold text-rose-500 bg-rose-50 border border-rose-100 hover:bg-rose-500 hover:text-white rounded-xl mt-1 transition-all"><i class="fas fa-power-off w-4 text-center"></i> Keluar Sistem</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 p-4 sm:p-6 lg:p-8 max-w-[1400px] mx-auto w-full relative z-0">
            @foreach (['success' => ['bg-emerald-50', 'text-emerald-800', 'text-emerald-500', 'fa-check-circle', 'border-emerald-200'], 'error' => ['bg-rose-50', 'text-rose-800', 'text-rose-500', 'fa-circle-exclamation', 'border-rose-200']] as $msg => $classes)
                @if(session($msg))
                    <div class="mb-6 px-5 py-4 {{ $classes[0] }} border {{ $classes[4] }} rounded-2xl flex items-center justify-between shadow-sm animate-[slideDown_0.4s_ease-out]">
                        <div class="flex items-center gap-3"><i class="fas {{ $classes[3] }} {{ $classes[2] }} text-xl"></i><span class="{{ $classes[1] }} text-[13px] sm:text-sm font-bold">{{ session($msg) }}</span></div>
                        <button onclick="this.parentElement.style.display='none'" class="{{ $classes[2] }} hover:opacity-70 p-2 transition-opacity"><i class="fas fa-times"></i></button>
                    </div>
                @endif
            @endforeach
            @yield('content')
        </main>
    </div>

    <script>
        const showGlobalLoader = (t = 'MEMUAT DATA...') => { const l = document.getElementById('globalLoader'); if(l) { l.querySelector('p').innerText = t; l.style.display = 'flex'; l.classList.remove('opacity-0', 'pointer-events-none'); l.classList.add('opacity-100'); } };
        const hideGlobalLoader = () => { const l = document.getElementById('globalLoader'); if(l) { l.classList.remove('opacity-100'); l.classList.add('opacity-0', 'pointer-events-none'); setTimeout(() => l.style.display = 'none', 200); } };
        window.addEventListener('pageshow', hideGlobalLoader);

        document.addEventListener('DOMContentLoaded', () => {
            hideGlobalLoader();
            document.querySelectorAll('.smooth-route').forEach(el => el.addEventListener('click', e => { if(!el.classList.contains('target-blank') && el.target !== '_blank' && !e.ctrlKey) showGlobalLoader('MEMUAT HALAMAN...'); }));

            const sidebar = document.getElementById('sidebar'), overlay = document.getElementById('mobileOverlay'), toggleBtn = document.getElementById('menuToggle'), closeBtn = document.getElementById('closeSidebar');
            const toggleSidebar = () => {
                if (sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('hidden'); setTimeout(() => overlay.classList.add('opacity-100'), 10); document.body.classList.add('overflow-hidden');
                } else {
                    sidebar.classList.add('-translate-x-full'); overlay.classList.remove('opacity-100'); setTimeout(() => overlay.classList.add('hidden'), 300); document.body.classList.remove('overflow-hidden');
                }
            };
            if(toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
            if(closeBtn) closeBtn.addEventListener('click', toggleSidebar);
            if(overlay) overlay.addEventListener('click', toggleSidebar);

            const uBtn = document.getElementById('userDropdownBtn'), uMenu = document.getElementById('userDropdown'), nBtn = document.getElementById('notifDropdownBtn'), nMenu = document.getElementById('notifDropdown');
            if (uBtn && uMenu) uBtn.addEventListener('click', e => { e.stopPropagation(); uMenu.classList.toggle('hidden'); if(nMenu) nMenu.classList.add('hidden'); });
            if (nBtn && nMenu) nBtn.addEventListener('click', e => { e.stopPropagation(); nMenu.classList.toggle('hidden'); if(uMenu) uMenu.classList.add('hidden'); });
            document.addEventListener('click', e => {
                if (uMenu && !uMenu.contains(e.target) && !uBtn.contains(e.target)) uMenu.classList.add('hidden');
                if (nMenu && !nMenu.contains(e.target) && !nBtn.contains(e.target)) nMenu.classList.add('hidden');
            });

            // AJAX REAL-TIME POLLING PINTAR (Setiap 10 Detik)
            let currentUnreadNotif = {{ \App\Models\Notifikasi::where('user_id', Auth::id())->where('is_read', false)->count() }};

            function checkNewNotifications() {
                fetch("{{ route('kader.notifikasi.fetch') }}", {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notifBadge');
                    const countText = document.getElementById('notifCount');
                    const list = document.getElementById('notifList');
                    const markAll = document.getElementById('markAllContainer');

                    if (badge) {
                        if (data.unreadCount > 0) badge.classList.remove('hidden');
                        else badge.classList.add('hidden');
                    }
                    if (countText) {
                        countText.textContent = data.unreadCount + ' Baru';
                        countText.className = data.unreadCount > 0 
                            ? 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-rose-100 text-rose-600'
                            : 'text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 text-slate-400';
                    }
                    if (list) list.innerHTML = data.html;
                    if (markAll) {
                        if (data.unreadCount > 0) markAll.classList.remove('hidden');
                        else markAll.classList.add('hidden');
                    }

                    if (data.unreadCount !== currentUnreadNotif) {
                        currentUnreadNotif = data.unreadCount;
                        const mainWrapper = document.getElementById('main-notif-wrapper');
                        if (mainWrapper) {
                            fetch(window.location.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                            .then(res => res.text())
                            .then(html => {
                                const doc = new DOMParser().parseFromString(html, 'text/html');
                                const newList = doc.getElementById('main-notif-wrapper');
                                if (newList) mainWrapper.innerHTML = newList.innerHTML;
                                const headerCount = document.getElementById('header-unread-count');
                                const newHeaderCount = doc.getElementById('header-unread-count');
                                if (headerCount && newHeaderCount) {
                                    headerCount.innerHTML = newHeaderCount.innerHTML;
                                }
                            });
                        }
                    }
                })
                .catch(error => console.error("Error fetching notifications:", error));
            }

            setInterval(checkNewNotifications, 10000);

            const markAllReadBtn = document.getElementById('markAllReadBtn');
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function(e) {
                    const nBadge = document.getElementById('notifBadge');
                    const nCount = document.getElementById('notifCount');
                    if(nBadge) nBadge.style.display = 'none';
                    if(nCount) {
                        nCount.textContent = '0 Baru';
                        nCount.className = 'text-[10px] font-bold bg-slate-100 text-slate-400 px-2 py-0.5 rounded-full';
                    }
                    document.querySelectorAll('.notif-item.unread').forEach(item => {
                        item.classList.remove('bg-indigo-50/40', 'border-l-indigo-500', 'unread');
                        item.classList.add('bg-white', 'border-l-transparent');
                        const iconWrapper = item.querySelector('div.rounded-full');
                        if (iconWrapper) {
                            iconWrapper.className = 'w-10 h-10 rounded-full flex items-center justify-center shrink-0 border bg-slate-50 text-slate-400 border-slate-200';
                        }
                    });
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>