{{--
  PATH   : resources/views/admin/users/index.blade.php
  FUNGSI : Daftar user warga + password flash + filter search
--}}
@extends('layouts.app')
@section('title', 'Manajemen User Warga')

@push('styles')
<style>
.adm-hero { background: linear-gradient(135deg,#0f172a,#0d9488); border-radius:16px; padding:1.5rem; color:#fff; margin-bottom:1.5rem; }
.adm-hero h4 { font-size:1.2rem; font-weight:800; margin:0 0 .25rem; }
.adm-hero p  { font-size:.8rem; opacity:.75; margin:0; }
.stat-row { display:flex; gap:1rem; margin-bottom:1.25rem; flex-wrap:wrap; }
.mini-stat { flex:1; min-width:130px; background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:.9rem 1rem; text-align:center; }
.mini-stat .val { font-size:1.4rem; font-weight:800; color:#0f172a; }
.mini-stat .lbl { font-size:.7rem; font-weight:600; color:#64748b; }
.filter-bar { background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:.85rem 1rem; margin-bottom:1rem; display:flex; gap:.65rem; flex-wrap:wrap; align-items:center; }
.fi { height:36px; border:1.5px solid #e2e8f0; border-radius:9px; padding:0 .75rem; font-size:.82rem; font-family:inherit; outline:none; transition:border .15s; }
.fi:focus { border-color:#0d9488; }
.fi-search { flex:1; min-width:180px; }
.pw-alert { background:linear-gradient(135deg,#0f172a,#0d9488); border-radius:14px; padding:1.1rem 1.25rem; color:#fff; margin-bottom:1.25rem; display:flex; align-items:center; gap:1rem; flex-wrap:wrap; }
.pw-box { font-family:monospace; font-size:1.05rem; font-weight:800; background:rgba(255,255,255,.15); padding:.35rem .85rem; border-radius:8px; letter-spacing:.05em; }
.pw-timer { font-size:.7rem; opacity:.6; margin-top:.2rem; }
.tbl-wrap { background:#fff; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden; }
.adm-tbl { width:100%; border-collapse:collapse; }
.adm-tbl th { background:#f8fafc; font-size:.7rem; font-weight:800; text-transform:uppercase; letter-spacing:.06em; color:#475569; padding:.75rem 1rem; border-bottom:1px solid #e2e8f0; text-align:left; white-space:nowrap; }
.adm-tbl td { padding:.75rem 1rem; border-bottom:1px solid #f1f5f9; font-size:.83rem; vertical-align:middle; }
.adm-tbl tr:last-child td { border-bottom:none; }
.adm-tbl tr:hover td { background:#fafbfc; }
.u-av { width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,#0d9488,#0ea5e9); display:flex; align-items:center; justify-content:center; font-weight:800; color:#fff; font-size:.8rem; flex-shrink:0; }
.u-name { font-weight:700; color:#0f172a; }
.u-sub { font-size:.7rem; color:#94a3b8; }
.nik-badge { font-family:monospace; font-size:.74rem; font-weight:700; background:#f1f5f9; color:#475569; padding:.18rem .55rem; border-radius:6px; letter-spacing:.03em; }
.status-aktif { background:#dcfce7; color:#166534; font-size:.67rem; font-weight:800; padding:.15rem .55rem; border-radius:20px; }
.status-nonaktif { background:#fee2e2; color:#991b1b; font-size:.67rem; font-weight:800; padding:.15rem .55rem; border-radius:20px; }
.pt-balita { background:#cffafe; color:#0e7490; font-size:.63rem; font-weight:700; padding:.1rem .4rem; border-radius:12px; }
.pt-remaja { background:#ede9fe; color:#5b21b6; font-size:.63rem; font-weight:700; padding:.1rem .4rem; border-radius:12px; }
.pt-lansia { background:#fef9c3; color:#92400e; font-size:.63rem; font-weight:700; padding:.1rem .4rem; border-radius:12px; }
.pt-none   { background:#f1f5f9; color:#94a3b8; font-size:.63rem; font-weight:700; padding:.1rem .4rem; border-radius:12px; }
.act-btn { width:30px; height:30px; border:none; border-radius:8px; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; font-size:.78rem; text-decoration:none; transition:all .13s; }
.act-btn:hover { transform:scale(1.1); }
.btn-view  { background:#eff6ff; color:#1d4ed8; }
.btn-edit  { background:#f0fdf4; color:#166534; }
.btn-pw    { background:#f0fdfa; color:#0d9488; }
.btn-reset { background:#fffbeb; color:#b45309; }
.btn-del   { background:#fef2f2; color:#dc2626; }
@media(max-width:768px){
    .adm-tbl thead { display:none; }
    .adm-tbl, .adm-tbl tbody, .adm-tbl tr, .adm-tbl td { display:block; width:100%; }
    .adm-tbl td { padding:.5rem .85rem; border-bottom:none; }
    .adm-tbl tr { border-bottom:1px solid #e2e8f0; padding:.35rem 0; }
    .adm-tbl td::before { content:attr(data-label); font-size:.65rem; font-weight:800; color:#94a3b8; text-transform:uppercase; display:block; margin-bottom:.15rem; }
}
</style>
@endpush

@section('content')

<div class="adm-hero">
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
        <div>
            <h4><i class="fas fa-users me-2"></i>Manajemen User Warga</h4>
            <p>Kelola akun warga — login menggunakan NIK 16 digit</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-primary-app">
            <i class="fas fa-plus"></i> Tambah Warga
        </a>
    </div>
</div>

{{-- Password Flash --}}
@if(session('generated_password') || session('reset_password'))
<div class="pw-alert" id="pwAlert">
    <i class="fas fa-key fa-lg opacity-75"></i>
    <div class="flex-grow-1">
        <div style="font-size:.8rem;font-weight:700;opacity:.8;margin-bottom:.3rem">
            {{ session('generated_password') ? '🔑 Password Baru Dibuat' : '🔄 Password Direset' }} —
            {{ session('user_name') ?? session('reset_name') }}
            <span class="nik-badge ms-1" style="background:rgba(255,255,255,.15);color:#fff">
                NIK: {{ session('user_nik') ?? session('reset_nik') }}
            </span>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="pw-box" id="pwText">
                {{ session('generated_password') ?? session('reset_password') }}
            </span>
            <button onclick="copyPw()" class="btn-primary-app" style="font-size:.72rem;padding:.3rem .75rem;height:auto">
                <i class="fas fa-copy"></i> Salin
            </button>
        </div>
        <div class="pw-timer" id="pwTimer">Otomatis hilang dalam <span id="pwSec">60</span> detik</div>
    </div>
    <button onclick="document.getElementById('pwAlert').remove()" style="background:transparent;border:none;color:rgba(255,255,255,.6);font-size:1.1rem;cursor:pointer;align-self:flex-start">×</button>
</div>
@endif

{{-- Stats --}}
<div class="stat-row">
    <div class="mini-stat"><div class="val">{{ $stats['total'] }}</div><div class="lbl">Total Warga</div></div>
    <div class="mini-stat"><div class="val" style="color:#166534">{{ $stats['aktif'] }}</div><div class="lbl">Aktif</div></div>
    <div class="mini-stat"><div class="val" style="color:#dc2626">{{ $stats['nonaktif'] }}</div><div class="lbl">Nonaktif</div></div>
</div>

{{-- Filter --}}
<form method="GET" class="filter-bar">
    <input type="text" name="search" class="fi fi-search" placeholder="🔍  Cari nama / NIK..." value="{{ request('search') }}">
    <select name="status" class="fi">
        <option value="">Semua Status</option>
        <option value="active"   {{ request('status')=='active'   ? 'selected':'' }}>Aktif</option>
        <option value="inactive" {{ request('status')=='inactive' ? 'selected':'' }}>Nonaktif</option>
    </select>
    <button type="submit" class="btn-primary-app" style="height:36px;padding:0 1rem;font-size:.8rem">Filter</button>
    @if(request()->hasAny(['search','status']))
    <a href="{{ route('admin.users.index') }}" class="btn-secondary-app" style="height:36px;padding:0 .85rem;font-size:.8rem">Reset</a>
    @endif
</form>

{{-- Table --}}
<div class="tbl-wrap">
    <table class="adm-tbl">
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>NIK</th>
                <th>Data Pasien</th>
                <th>Status</th>
                <th style="text-align:center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $u)
            @php
                $nm = $u->profile?->full_name ?? $u->name;
                $nik = $u->nik ?? $u->profile?->nik ?? '-';
            @endphp
            <tr>
                <td data-label="#">{{ $loop->iteration + ($users->firstItem() - 1) }}</td>
                <td data-label="User">
                    <div class="d-flex align-items-center gap-2">
                        <div class="u-av">{{ strtoupper(substr($nm,0,1)) }}</div>
                        <div>
                            <div class="u-name">{{ $nm }}</div>
                            <div class="u-sub">ID #{{ $u->id }}</div>
                        </div>
                    </div>
                </td>
                <td data-label="NIK"><span class="nik-badge">{{ $nik }}</span></td>
                <td data-label="Data Pasien">
                    @php
                        $hasB = \App\Models\Balita::where('user_id',$u->id)->orWhere('nik_ibu',$nik)->orWhere('nik_ayah',$nik)->exists();
                        $hasR = \App\Models\Remaja::where('user_id',$u->id)->orWhere('nik',$nik)->exists();
                        $hasL = \App\Models\Lansia::where('user_id',$u->id)->orWhere('nik',$nik)->exists();
                    @endphp
                    <div class="d-flex gap-1 flex-wrap">
                        @if($hasB)<span class="pt-balita">Balita</span>@endif
                        @if($hasR)<span class="pt-remaja">Remaja</span>@endif
                        @if($hasL)<span class="pt-lansia">Lansia</span>@endif
                        @if(!$hasB && !$hasR && !$hasL)<span class="pt-none">Belum ada</span>@endif
                    </div>
                </td>
                <td data-label="Status">
                    <span class="status-{{ $u->status === 'active' ? 'aktif' : 'nonaktif' }}">
                        {{ $u->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td data-label="Aksi">
                    <div class="d-flex gap-1 justify-content-center flex-wrap">
                        <a href="{{ route('admin.users.show', $u->id) }}" class="act-btn btn-view" title="Detail"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.users.edit', $u->id) }}" class="act-btn btn-edit" title="Edit"><i class="fas fa-pen"></i></a>
                        <form action="{{ route('admin.users.generate-password', $u->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="act-btn btn-pw" title="Generate Password"
                                onclick="return confirm('Buat password baru untuk {{ addslashes($nm) }}?')">
                                <i class="fas fa-key"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.users.reset-password', $u->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="act-btn btn-reset" title="Reset Password (6 digit NIK + Ps!)"
                                onclick="return confirm('Reset password ke default?\nFormat: 6 digit akhir NIK + Ps!')">
                                <i class="fas fa-undo"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="act-btn btn-del" title="Hapus"
                                onclick="return confirm('Hapus akun {{ addslashes($nm) }}? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;padding:3rem;color:#94a3b8">
                    <i class="fas fa-users d-block mb-2" style="font-size:2rem"></i>
                    Tidak ada data warga ditemukan
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
@if($users->hasPages())
<div class="d-flex justify-content-center mt-3">
    {{ $users->withQueryString()->links() }}
</div>
@endif

@endsection
@push('scripts')
<script>
function copyPw() {
    const t = document.getElementById('pwText').innerText.trim();
    navigator.clipboard.writeText(t).then(() => {
        Swal.fire({icon:'success',title:'Password disalin!',timer:1200,showConfirmButton:false,toast:true,position:'top-end'});
    });
}
let sec = 60;
const ti = setInterval(() => {
    const el = document.getElementById('pwSec');
    if (!el) { clearInterval(ti); return; }
    el.textContent = --sec;
    if (sec <= 0) { clearInterval(ti); document.getElementById('pwAlert')?.remove(); }
}, 1000);
</script>
@endpush