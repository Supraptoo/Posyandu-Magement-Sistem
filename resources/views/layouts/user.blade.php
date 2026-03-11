<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portal Warga') — PosyanduCare</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Plus Jakarta Sans', sans-serif;
            --color-brand-teal: #0d9488;
            --color-brand-sky: #0ea5e9;
        }

        body {
            font-family: var(--font-sans);
            background-color: #f8fafc; /* Latar belakang cerah, bersih, tidak sakit di mata */
            -webkit-tap-highlight-color: transparent;
        }

        /* Sembunyikan scrollbar bawaan agar terasa seperti Aplikasi Android/iOS */
        ::-webkit-scrollbar { width: 0px; background: transparent; }

        /* Efek Kaca (Glassmorphism) */
        .glass-effect {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        /* Area aman untuk HP berponi (iPhone Notch/Android) */
        .pb-safe { padding-bottom: env(safe-area-inset-bottom, 16px); }
        
        /* Animasi Bottom Nav Mulus */
        .nav-bottom-item { @apply flex flex-col items-center justify-center w-full py-2 transition-all duration-300; }
        .nav-bottom-item.active { @apply text-teal-600 font-bold -translate-y-1 scale-105; }
        .nav-bottom-item:not(.active) { @apply text-slate-400 font-medium hover:text-teal-500; }
        
        /* Loader Animasi */
        @keyframes pulseGlow { 0% { box-shadow: 0 0 0 0 rgba(13, 148, 136, 0.4); } 70% { box-shadow: 0 0 0 15px rgba(13, 148, 136, 0); } 100% { box-shadow: 0 0 0 0 rgba(13, 148, 136, 0); } }
        .btn-pulse { animation: pulseGlow 2s infinite; }
    </style>
    @stack('styles')
</head>
<body class="text-slate-800 antialiased lg:pb-0 pb-[80px]"> <div id="userLoader" class="fixed inset-0 bg-slate-50/90 backdrop-blur-md z-[9999] flex flex-col items-center justify-center transition-all duration-400 opacity-0 pointer-events-none">
        <div class="relative w-20 h-20 flex items-center justify-center mb-4">
            <div class="absolute inset-0 border-4 border-teal-100 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-teal-500 rounded-full border-t-transparent animate-spin"></div>
            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm">
                <i class="fas fa-heartbeat text-teal-500 animate-pulse text-2xl"></i>
            </div>
        </div>
        <p class="text-teal-800 font-extrabold tracking-[0.2em] text-xs">MEMUAT DATA...</p>
    </div>

    <div class="flex min-h-screen w-full relative">
        
        <aside class="hidden lg:block w-[280px] bg-white border-r border-slate-200 fixed h-full z-40 shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
            @include('partials.sidebar.user')
        </aside>

        <div class="flex-1 lg:ml-[280px] flex flex-col w-full min-w-0 transition-all duration-300">
            
            <header class="h-16 glass-effect border-b border-slate-200/80 sticky top-0 z-30 flex items-center justify-between px-5 sm:px-8 shadow-sm">
                
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-[10px] bg-gradient-to-br from-teal-400 to-teal-600 text-white flex items-center justify-center shadow-md lg:hidden">
                        <i class="fas fa-hand-holding-medical text-sm"></i>
                    </div>
                    <div>
                        <h1 class="text-lg sm:text-xl font-extrabold text-slate-800 tracking-tight leading-none">Posyandu<span class="text-teal-600">Care</span></h1>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest hidden sm:block mt-0.5">Sistem Layanan Warga</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 sm:gap-4">
                    <a href="{{ route('user.notifikasi.index') }}" class="smooth-route relative w-10 h-10 flex items-center justify-center text-slate-500 hover:text-teal-600 hover:bg-teal-50 rounded-full transition-all bg-white border border-slate-100 shadow-sm">
                        <i class="fas fa-bell text-[18px]"></i>
                        <span id="badgeNotif" class="hidden absolute top-1 right-1.5 w-2.5 h-2.5 bg-rose-500 rounded-full ring-2 ring-white animate-pulse shadow-[0_0_8px_rgba(244,63,94,0.6)]"></span>
                    </a>

                    <a href="{{ route('user.profile.edit') }}" class="smooth-route w-10 h-10 rounded-full ring-2 ring-slate-100 overflow-hidden flex items-center justify-center bg-gradient-to-br from-teal-50 to-sky-50 text-teal-700 font-extrabold shadow-sm hover:ring-teal-300 transition-all border border-teal-200">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </a>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 lg:p-8 w-full max-w-6xl mx-auto relative z-0">
                @foreach (['success' => ['bg-emerald-50', 'text-emerald-600', 'fa-check-circle', 'border-emerald-200'], 'error' => ['bg-rose-50', 'text-rose-600', 'fa-exclamation-circle', 'border-rose-200']] as $msg => $cls)
                    @if(session($msg))
                        <div class="mb-5 px-4 py-3.5 {{ $cls[0] }} border {{ $cls[3] }} rounded-2xl flex items-center justify-between shadow-sm animate-[slideDown_0.4s_ease-out]">
                            <div class="flex items-center gap-3">
                                <i class="fas {{ $cls[2] }} {{ $cls[1] }} text-xl"></i>
                                <span class="{{ $cls[1] }} text-sm font-bold">{{ session($msg) }}</span>
                            </div>
                            <button onclick="this.parentElement.style.display='none'" class="{{ $cls[1] }} hover:opacity-70 p-1"><i class="fas fa-times"></i></button>
                        </div>
                    @endif
                @endforeach

                @yield('content')
            </main>

        </div>
    </div>

    <nav class="lg:hidden fixed bottom-0 left-0 w-full glass-effect border-t border-slate-200/80 z-50 pb-safe rounded-t-3xl shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
        <div class="flex justify-between items-center px-4 pt-1">
            
            <a href="{{ route('user.dashboard') }}" class="smooth-route nav-bottom-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home text-xl mb-1"></i>
                <span class="text-[10px] tracking-wide">Beranda</span>
            </a>

            <a href="{{ route('user.jadwal.index') }}" class="smooth-route nav-bottom-item {{ request()->routeIs('user.jadwal.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt text-xl mb-1"></i>
                <span class="text-[10px] tracking-wide">Jadwal</span>
            </a>

            <div class="relative -top-6 px-3">
                <a href="{{ route('user.riwayat.index') }}" class="smooth-route w-14 h-14 rounded-full bg-gradient-to-tr from-teal-500 to-sky-500 text-white flex items-center justify-center text-2xl shadow-[0_8px_20px_rgba(13,148,136,0.4)] border-[4px] border-[#f8fafc] hover:scale-105 transition-transform btn-pulse">
                    <i class="fas fa-notes-medical"></i>
                </a>
            </div>

            <a href="{{ route('user.notifikasi.index') }}" class="smooth-route nav-bottom-item {{ request()->routeIs('user.notifikasi.*') ? 'active' : '' }} relative">
                <i class="fas fa-bell text-xl mb-1"></i>
                <span class="text-[10px] tracking-wide">Pesan</span>
                <span id="badgeNotifBottom" class="hidden absolute top-2 right-1/4 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white"></span>
            </a>

            <a href="{{ route('user.profile.edit') }}" class="smooth-route nav-bottom-item {{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
                <i class="fas fa-user-circle text-xl mb-1"></i>
                <span class="text-[10px] tracking-wide">Profil</span>
            </a>

        </div>
    </nav>

    <script>
        // Logika Transisi Mulus (SPA Feel)
        const showUserLoader = () => {
            const loader = document.getElementById('userLoader');
            if(loader) {
                loader.style.display = 'flex';
                loader.offsetHeight; 
                loader.classList.remove('opacity-0', 'pointer-events-none');
                loader.classList.add('opacity-100');
            }
        };

        window.addEventListener('pageshow', () => {
            const loader = document.getElementById('userLoader');
            if(loader) {
                loader.classList.remove('opacity-100');
                loader.classList.add('opacity-0', 'pointer-events-none');
                setTimeout(() => loader.style.display = 'none', 300);
            }
        });

        document.querySelectorAll('.smooth-route').forEach(link => {
            link.addEventListener('click', function(e) {
                if(!this.classList.contains('target-blank') && this.target !== '_blank' && !e.ctrlKey) {
                    showUserLoader();
                }
            });
        });

        // Polling Notifikasi Otomatis
        function checkNotifications() {
            fetch('{{ route("user.notifikasi.latest") }}', {
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'ok' && data.unread_count > 0) {
                    document.getElementById('badgeNotif')?.classList.remove('hidden');
                    document.getElementById('badgeNotifBottom')?.classList.remove('hidden');
                } else {
                    document.getElementById('badgeNotif')?.classList.add('hidden');
                    document.getElementById('badgeNotifBottom')?.classList.add('hidden');
                }
            }).catch(() => {});
        }

        document.addEventListener('DOMContentLoaded', () => {
            checkNotifications();
            setInterval(checkNotifications, 10000); // Mengecek info Bidan setiap 10 Detik
        });
    </script>
    @stack('scripts')
</body>
</html>