{{--
  PATH   : resources/views/layouts/app.blade.php
  FUNGSI : Layout utama untuk semua role (admin, bidan, kader, user)
  CATATAN: Bug fix -> auth()->user()->name (bukan ->nama)
           Sidebar dark, konten center, font Inter dari Google Fonts
           Fully responsive + mobile-first
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SIPOSYANDU') — SIPOSYANDU</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    /* ═══════════════════════════════════════════
       SIPOSYANDU — Master Layout v2
       Font: Inter | Tema: Teal Healthcare
       Mobile-first | Centered Content
    ═══════════════════════════════════════════ */
    :root {
        --nav-h:   60px;
        --sb-w:    260px;
        --t:       #0d9488;
        --t2:      #0ea5e9;
        --t-light: #f0fdfa;
        --sb-bg:   #0f172a;
        --sb-sec:  #1e293b;
        --sb-muted:rgba(148,163,184,.6);
        --bg:      #f1f5f9;
        --card:    #ffffff;
        --border:  #e2e8f0;
        --txt:     #0f172a;
        --muted:   #64748b;
        --r:       14px;
        --rs:      10px;
        --shadow:  0 1px 3px rgba(0,0,0,.06), 0 4px 20px rgba(0,0,0,.05);
        --grad:    linear-gradient(135deg, #0d9488, #0ea5e9);
    }

    *, *::before, *::after { box-sizing: border-box; }
    html, body { margin: 0; padding: 0; }

    body {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        background: var(--bg);
        color: var(--txt);
        min-height: 100vh;
        padding-top: var(--nav-h);
        overflow-x: hidden;
        font-size: 14px;
        line-height: 1.5;
    }

    /* ── NAVBAR ─────────────────────────────────── */
    .sp-nav {
        position: fixed; top: 0; left: 0; right: 0;
        z-index: 1060; height: var(--nav-h);
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        display: flex; align-items: center;
        padding: 0 1rem; gap: .5rem;
        box-shadow: 0 2px 20px rgba(0,0,0,.3);
    }

    .sp-toggle {
        background: transparent; border: none;
        color: rgba(255,255,255,.65); width: 36px; height: 36px;
        border-radius: 8px; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem; transition: all .15s; flex-shrink: 0;
    }
    .sp-toggle:hover { background: rgba(255,255,255,.1); color: #fff; }

    .sp-brand {
        font-size: 1rem; font-weight: 800; color: #fff;
        text-decoration: none; letter-spacing: -.02em;
        display: flex; align-items: center; gap: .5rem;
        white-space: nowrap; flex-shrink: 0;
    }
    .sp-brand .bic {
        width: 32px; height: 32px; border-radius: 8px;
        background: var(--grad);
        display: flex; align-items: center; justify-content: center;
        font-size: .85rem; color: #fff; flex-shrink: 0;
    }
    .sp-brand:hover { color: #2dd4bf; }

    .sp-right { margin-left: auto; display: flex; align-items: center; gap: .3rem; }

    /* Bell */
    .sp-bell {
        position: relative; color: rgba(255,255,255,.65);
        text-decoration: none; width: 36px; height: 36px;
        border-radius: 8px; display: flex; align-items: center;
        justify-content: center; font-size: .9rem; transition: all .15s;
    }
    .sp-bell:hover { background: rgba(255,255,255,.1); color: #fff; }
    .sp-bell-dot {
        position: absolute; top: 6px; right: 6px;
        width: 7px; height: 7px; border-radius: 50%;
        background: #ef4444; border: 1.5px solid #0f172a; display: none;
    }

    /* User dropdown */
    .sp-drop { position: relative; }
    .sp-user {
        display: flex; align-items: center; gap: .45rem;
        color: rgba(255,255,255,.8); cursor: pointer;
        border-radius: 10px; padding: .3rem .6rem;
        transition: background .15s; user-select: none;
    }
    .sp-user:hover { background: rgba(255,255,255,.08); }
    .sp-av {
        width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0;
        background: var(--grad);
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: .8rem; color: #fff;
    }
    .sp-uname { font-size: .8rem; font-weight: 600; max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .sp-role-chip {
        font-size: .58rem; font-weight: 800; text-transform: uppercase;
        background: var(--t); color: #fff; border-radius: 5px;
        padding: .1rem .38rem; letter-spacing: .04em;
    }
    .sp-chevron { font-size: .5rem; opacity: .5; }

    .sp-dropmenu {
        position: absolute; top: calc(100% + 8px); right: 0;
        background: #fff; border: 1px solid var(--border);
        border-radius: 12px; padding: .35rem; min-width: 160px;
        box-shadow: 0 8px 30px rgba(0,0,0,.14); display: none;
        z-index: 9999; animation: dropIn .1s ease both;
    }
    @keyframes dropIn { from { opacity:0; transform:translateY(-5px) } to { opacity:1; transform:none } }
    .sp-drop:hover .sp-dropmenu { display: block; }
    .sp-dropmenu a, .sp-dropmenu button {
        display: flex; align-items: center; gap: .45rem;
        padding: .45rem .7rem; border-radius: 8px; width: 100%;
        font-size: .8rem; font-weight: 600; color: var(--txt);
        text-decoration: none; border: none; background: none; cursor: pointer;
        transition: background .1s;
    }
    .sp-dropmenu a:hover, .sp-dropmenu button:hover { background: #f8fafc; }
    .sp-dropmenu button { color: #dc2626; }
    .sp-dropmenu .sp-sep { border-color: var(--border); margin: .25rem 0; }

    /* ── SIDEBAR ─────────────────────────────────── */
    .sp-sidebar {
        position: fixed; top: var(--nav-h); left: 0;
        z-index: 1040; width: var(--sb-w);
        height: calc(100vh - var(--nav-h));
        background: linear-gradient(180deg, var(--sb-bg) 0%, var(--sb-sec) 100%);
        overflow-y: auto; overflow-x: hidden;
        transition: transform .28s cubic-bezier(.4,0,.2,1);
        scrollbar-width: thin; scrollbar-color: #1e3a5f transparent;
    }
    .sp-sidebar::-webkit-scrollbar { width: 3px; }
    .sp-sidebar::-webkit-scrollbar-thumb { background: #1e3a5f; border-radius: 3px; }
    .sp-sidebar.sb-collapsed { transform: translateX(-100%); }

    /* Sidebar items */
    .sb-brand-area {
        padding: 1rem 1rem .7rem;
        border-bottom: 1px solid rgba(255,255,255,.07);
        margin-bottom: .3rem;
        display: flex; align-items: center; gap: .6rem;
    }
    .sb-brand-ic {
        width: 34px; height: 34px; border-radius: 9px; flex-shrink: 0;
        background: var(--grad);
        display: flex; align-items: center; justify-content: center;
        font-size: .9rem; color: #fff;
    }
    .sb-brand-name { font-size: .72rem; font-weight: 800; color: #fff; line-height: 1; }
    .sb-brand-sub { font-size: .62rem; color: var(--sb-muted); margin-top: .08rem; }

    .sb-section { padding: .7rem 1rem .2rem; font-size: .6rem; font-weight: 800;
        letter-spacing: .1em; text-transform: uppercase; color: var(--sb-muted); user-select: none; }
    .sb-divider { border-top: 1px solid rgba(255,255,255,.06); margin: .4rem .85rem; }

    .sb-link {
        display: flex; align-items: center; gap: .6rem;
        padding: .62rem 1rem; color: rgba(255,255,255,.65);
        text-decoration: none; border-radius: 9px;
        margin: .08rem .55rem; font-size: .84rem; font-weight: 500;
        transition: all .15s; position: relative; overflow: hidden;
    }
    .sb-link::before {
        content: ''; position: absolute; left: 0; top: 15%; height: 70%;
        width: 3px; background: var(--t); border-radius: 0 3px 3px 0;
        transform: scaleX(0); transition: transform .15s; transform-origin: left;
    }
    .sb-link i { width: 16px; text-align: center; font-size: .85rem; flex-shrink: 0; }
    .sb-link:hover { background: rgba(255,255,255,.07); color: #fff; padding-left: 1.25rem; }
    .sb-link:hover::before { transform: scaleX(1); }
    .sb-link.active {
        background: linear-gradient(135deg, rgba(13,148,136,.38), rgba(14,165,233,.18));
        color: #fff; font-weight: 700;
    }
    .sb-link.active::before { transform: scaleX(1); }
    .sb-badge {
        margin-left: auto; font-size: .57rem; font-weight: 800;
        background: var(--t); color: #fff; border-radius: 30px;
        padding: .08rem .4rem; line-height: 1.5;
    }
    .sb-badge.nik { background: #7c3aed; }
    .sb-badge.email { background: #0284c7; }
    .sb-logout { color: rgba(248,113,113,.7) !important; }
    .sb-logout:hover { background: rgba(239,68,68,.1) !important; color: #fca5a5 !important; }

    /* ── OVERLAY (mobile) ────────────────────────── */
    .sp-overlay {
        position: fixed; inset: var(--nav-h) 0 0 0; z-index: 1035;
        background: rgba(0,0,0,.5); backdrop-filter: blur(3px);
        opacity: 0; visibility: hidden; transition: all .25s;
    }
    .sp-overlay.show { opacity: 1; visibility: visible; }

    /* ── MAIN CONTENT ────────────────────────────── */
    .sp-main {
        margin-left: var(--sb-w);
        padding: 1.5rem;
        min-height: calc(100vh - var(--nav-h));
        transition: margin-left .28s cubic-bezier(.4,0,.2,1);
        /* CENTER konten di layar lebar */
    }
    .sp-main.main-full { margin-left: 0; }

    /* Wrapper center untuk konten */
    .content-center {
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
    }

    /* ── RESPONSIVE ──────────────────────────────── */
    @media (max-width: 992px) {
        .sp-sidebar { transform: translateX(-100%); }
        .sp-sidebar.sb-open { transform: translateX(0); }
        .sp-main { margin-left: 0 !important; padding: 1rem; }
        .sp-uname, .sp-role-chip, .sp-chevron { display: none; }
    }

    @media (max-width: 576px) {
        body { font-size: 13px; }
        :root { --nav-h: 56px; }
        .sp-main { padding: .75rem; }
        .sp-brand span.brand-text { display: none; }
        .content-center { padding: 0; }
    }

    /* ── UTILITY CLASSES ─────────────────────────── */
    .card-base {
        background: var(--card); border: 1px solid var(--border);
        border-radius: var(--r); box-shadow: var(--shadow); overflow: hidden;
    }
    .btn-primary-app {
        background: var(--grad); color: #fff; border: none;
        border-radius: var(--rs); padding: .55rem 1.25rem;
        font-size: .84rem; font-weight: 700; cursor: pointer;
        display: inline-flex; align-items: center; gap: .4rem;
        text-decoration: none; transition: opacity .15s, transform .1s;
        font-family: inherit;
    }
    .btn-primary-app:hover { opacity: .9; color: #fff; transform: translateY(-1px); }
    .btn-secondary-app {
        background: #f1f5f9; color: var(--muted); border: 1px solid var(--border);
        border-radius: var(--rs); padding: .55rem 1.25rem;
        font-size: .84rem; font-weight: 700; cursor: pointer;
        display: inline-flex; align-items: center; gap: .4rem;
        text-decoration: none; transition: background .12s;
        font-family: inherit;
    }
    .btn-secondary-app:hover { background: #e2e8f0; color: var(--txt); }

    /* Gradient text utility */
    .text-grad {
        background: var(--grad); -webkit-background-clip: text;
        -webkit-text-fill-color: transparent; background-clip: text;
    }
    </style>

    @stack('styles')
</head>
<body>

@auth
{{-- ══════════════ NAVBAR ══════════════ --}}
<nav class="sp-nav">
    <button class="sp-toggle" id="spToggle" aria-label="Toggle Sidebar">
        <i class="fas fa-bars" id="spIcon"></i>
    </button>

    <a href="{{ route('home') }}" class="sp-brand">
        <span class="bic"><i class="fas fa-heartbeat"></i></span>
        <span class="brand-text">SIPOSYANDU</span>
    </a>

    <div class="sp-right">
        {{-- Bell notifikasi (role: user saja) --}}
        @if(auth()->user()->role === 'user')
        <a href="{{ route('user.notifikasi.index') }}" class="sp-bell" title="Notifikasi">
            <i class="fas fa-bell"></i>
            <span class="sp-bell-dot" id="notifDot"></span>
        </a>
        @endif

        {{-- User Dropdown --}}
        <div class="sp-drop">
            <div class="sp-user" role="button" tabindex="0">
                <div class="sp-av">
                    {{ strtoupper(substr(auth()->user()->profile?->full_name ?? auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <span class="sp-uname">
                    {{ Str::limit(auth()->user()->profile?->full_name ?? auth()->user()->name, 18) }}
                </span>
                <span class="sp-role-chip">{{ auth()->user()->role }}</span>
                <i class="fas fa-chevron-down sp-chevron"></i>
            </div>
            <div class="sp-dropmenu">
                <a href="{{ route('password.change') }}">
                    <i class="fas fa-key" style="color:var(--t)"></i> Ganti Password
                </a>
                <hr class="sp-sep">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

{{-- ══════════════ SIDEBAR ══════════════ --}}
<div class="sp-overlay" id="spOverlay"></div>
<aside class="sp-sidebar" id="spSidebar" role="navigation">
    @if(auth()->user()->role === 'admin')
        @include('partials.sidebar.admin')
    @elseif(auth()->user()->role === 'bidan')
        @include('partials.sidebar.bidan')
    @elseif(auth()->user()->role === 'kader')
        @include('partials.sidebar.sidebar-kader')
    @else
        @include('partials.sidebar.user')
    @endif
</aside>

{{-- ══════════════ KONTEN UTAMA ══════════════ --}}
<main class="sp-main" id="spMain">
    <div class="content-center">
        @yield('content')
    </div>
</main>

@else
    @yield('content')
@endauth

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// ── Global Toast ──
const _T = Swal.mixin({
    toast: true, position: 'top-end',
    showConfirmButton: false, timer: 3500, timerProgressBar: true,
    customClass: { popup: 'swal2-toast-custom' }
});

// ── Flash Messages ──
@if(session('success') && !session('generated_password') && !session('reset_password'))
    _T.fire({ icon: 'success', title: '{{ addslashes(session("success")) }}' });
@endif
@if(session('error'))
    _T.fire({ icon: 'error', title: '{{ addslashes(session("error")) }}' });
@endif
@if(session('warning'))
    _T.fire({ icon: 'warning', title: '{{ addslashes(session("warning")) }}' });
@endif
@if(session('info'))
    _T.fire({ icon: 'info', title: '{{ addslashes(session("info")) }}' });
@endif

// ── Sidebar Toggle ──
const _sb  = document.getElementById('spSidebar');
const _mn  = document.getElementById('spMain');
const _ov  = document.getElementById('spOverlay');
const _ic  = document.getElementById('spIcon');
let   _mob = window.innerWidth <= 992;

function _syncMode() {
    _mob = window.innerWidth <= 992;
    if (!_mob) {
        _sb.classList.remove('sb-open');
        _ov.classList.remove('show');
        document.body.style.overflow = '';
    }
}

document.getElementById('spToggle').addEventListener('click', () => {
    if (_mob) {
        const open = _sb.classList.toggle('sb-open');
        _ov.classList.toggle('show', open);
        document.body.style.overflow = open ? 'hidden' : '';
    } else {
        const collapsed = _sb.classList.toggle('sb-collapsed');
        _mn.classList.toggle('main-full', collapsed);
        _ic.className = collapsed ? 'fas fa-bars' : 'fas fa-times';
    }
});

_ov.addEventListener('click', () => {
    _sb.classList.remove('sb-open');
    _ov.classList.remove('show');
    document.body.style.overflow = '';
});

let _rt;
window.addEventListener('resize', () => {
    clearTimeout(_rt);
    _rt = setTimeout(_syncMode, 150);
});
_syncMode();

// ── Notif Polling (user only) ──
@if(auth()->check() && auth()->user()->role === 'user')
(function pollNotif() {
    fetch('{{ route("user.notifikasi.latest") }}')
        .then(r => r.json())
        .then(d => {
            const dot = document.getElementById('notifDot');
            if (dot) dot.style.display = (d.unread_count > 0) ? 'block' : 'none';
        }).catch(() => {});
    setTimeout(pollNotif, 30000);
})();
@endif
</script>

@stack('scripts')
</body>
</html>