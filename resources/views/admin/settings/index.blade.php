{{--
  PATH   : resources/views/admin/settings/index.blade.php
  FUNGSI : Pengaturan sistem — profil posyandu + ganti password admin
--}}
@extends('layouts.app')
@section('title', 'Pengaturan Sistem')

@push('styles')
<style>
.set-hero { background:linear-gradient(135deg,#0f172a,#0d9488); border-radius:16px; padding:1.5rem; color:#fff; margin-bottom:1.5rem; }
.set-hero h4 { font-size:1.2rem; font-weight:800; margin:0 0 .2rem; }
.set-hero p  { font-size:.78rem; opacity:.75; margin:0; }
.set-card { background:#fff; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden; margin-bottom:1.25rem; }
.set-head { padding:.85rem 1.15rem; border-bottom:1px solid #f1f5f9; display:flex; align-items:center; gap:.5rem; }
.set-head h6 { font-size:.87rem; font-weight:800; color:#0f172a; margin:0; }
.set-head i { color:#0d9488; }
.set-body { padding:1.15rem; }
.form-row2 { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
.form-group { display:flex; flex-direction:column; gap:.35rem; margin-bottom:.85rem; }
.form-group.full { grid-column:1 / -1; }
.fl { font-size:.75rem; font-weight:700; color:#374151; }
.fl .req { color:#dc2626; }
.fi { height:40px; border:1.5px solid #e2e8f0; border-radius:10px; padding:0 .85rem; font-size:.84rem; font-family:inherit; outline:none; transition:border .15s; width:100%; }
.fi:focus { border-color:#0d9488; box-shadow:0 0 0 3px rgba(13,148,136,.1); }
.fi.is-invalid { border-color:#dc2626; }
.err { font-size:.72rem; color:#dc2626; }
.admin-chip { background:#f0fdfa; border:1.5px solid #99f6e4; border-radius:12px; padding:.85rem 1rem; display:flex; align-items:center; gap:.75rem; margin-bottom:1rem; }
.admin-av { width:42px; height:42px; border-radius:50%; background:linear-gradient(135deg,#0d9488,#0ea5e9); display:flex; align-items:center; justify-content:center; font-size:1rem; font-weight:800; color:#fff; flex-shrink:0; }
.sys-row { display:flex; justify-content:space-between; padding:.5rem 0; border-bottom:1px solid #f8fafc; font-size:.82rem; }
.sys-row:last-child { border-bottom:none; }
.sys-lbl { color:#64748b; font-weight:600; }
.sys-val { color:#0f172a; font-weight:700; font-family:monospace; font-size:.78rem; }
@media(max-width:576px){ .form-row2 { grid-template-columns:1fr; } }
</style>
@endpush

@section('content')

<div class="set-hero">
    <h4><i class="fas fa-cog me-2"></i>Pengaturan Sistem</h4>
    <p>Kelola profil posyandu dan keamanan akun admin</p>
</div>

<div class="row g-3">
    {{-- Profil Posyandu --}}
    <div class="col-lg-7">
        <div class="set-card">
            <div class="set-head"><i class="fas fa-hospital"></i><h6>Profil Posyandu</h6></div>
            <div class="set-body">
                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf @method('PUT')

                    <div style="font-size:.72rem;font-weight:800;text-transform:uppercase;color:#64748b;margin-bottom:.75rem;letter-spacing:.06em">Identitas Posyandu</div>
                    <div class="form-row2">
                        <div class="form-group full">
                            <label class="fl">Nama Posyandu <span class="req">*</span></label>
                            <input type="text" name="posyandu_name" class="fi @error('posyandu_name') is-invalid @enderror"
                                value="{{ old('posyandu_name', $settings['posyandu_name'] ?? '') }}"
                                placeholder="Posyandu Melati">
                            @error('posyandu_name')<span class="err">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label class="fl">Nomor Telepon</label>
                            <input type="text" name="posyandu_telepon" class="fi"
                                value="{{ old('posyandu_telepon', $settings['posyandu_telepon'] ?? '') }}"
                                placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="form-group">
                            <label class="fl">Email Posyandu</label>
                            <input type="email" name="posyandu_email" class="fi @error('posyandu_email') is-invalid @enderror"
                                value="{{ old('posyandu_email', $settings['posyandu_email'] ?? '') }}"
                                placeholder="posyandu@example.com">
                            @error('posyandu_email')<span class="err">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group full">
                            <label class="fl">Alamat Lengkap</label>
                            <input type="text" name="posyandu_alamat" class="fi"
                                value="{{ old('posyandu_alamat', $settings['posyandu_alamat'] ?? '') }}"
                                placeholder="Jl. Contoh No. 1">
                        </div>
                    </div>

                    <div style="font-size:.72rem;font-weight:800;text-transform:uppercase;color:#64748b;margin-bottom:.75rem;letter-spacing:.06em">Wilayah</div>
                    <div class="form-row2">
                        <div class="form-group">
                            <label class="fl">Kelurahan / Desa</label>
                            <input type="text" name="posyandu_kelurahan" class="fi"
                                value="{{ old('posyandu_kelurahan', $settings['posyandu_kelurahan'] ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label class="fl">Kecamatan</label>
                            <input type="text" name="posyandu_kecamatan" class="fi"
                                value="{{ old('posyandu_kecamatan', $settings['posyandu_kecamatan'] ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label class="fl">Kota / Kabupaten</label>
                            <input type="text" name="posyandu_kota" class="fi"
                                value="{{ old('posyandu_kota', $settings['posyandu_kota'] ?? '') }}">
                        </div>
                        <div class="form-group">
                            <label class="fl">Kode Pos</label>
                            <input type="text" name="posyandu_kode_pos" class="fi"
                                value="{{ old('posyandu_kode_pos', $settings['posyandu_kode_pos'] ?? '') }}"
                                maxlength="5" placeholder="12345">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-2">
                        <button type="submit" class="btn-primary-app">
                            <i class="fas fa-save"></i> Simpan Pengaturan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Keamanan + Info Sistem --}}
    <div class="col-lg-5">
        {{-- Admin Info --}}
        <div class="set-card mb-3">
            <div class="set-head"><i class="fas fa-shield-alt"></i><h6>Keamanan Akun Admin</h6></div>
            <div class="set-body">
                <div class="admin-chip">
                    <div class="admin-av">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div>
                        <div style="font-size:.85rem;font-weight:800;color:#0f172a">{{ auth()->user()->name }}</div>
                        <div style="font-size:.7rem;color:#64748b">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.settings.change-password') }}">
                    @csrf @method('PUT')

                    <div class="form-group">
                        <label class="fl">Password Saat Ini <span class="req">*</span></label>
                        <input type="password" name="current_password"
                            class="fi @error('current_password') is-invalid @enderror"
                            placeholder="••••••••">
                        @error('current_password')<span class="err">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="fl">Password Baru <span class="req">*</span></label>
                        <input type="password" name="new_password"
                            class="fi @error('new_password') is-invalid @enderror"
                            placeholder="Min. 8 karakter">
                        @error('new_password')<span class="err">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="fl">Konfirmasi Password Baru <span class="req">*</span></label>
                        <input type="password" name="new_password_confirmation" class="fi" placeholder="Ulangi password baru">
                    </div>

                    <button type="submit" class="btn-primary-app w-100 justify-content-center">
                        <i class="fas fa-lock"></i> Ubah Password
                    </button>
                </form>
            </div>
        </div>

        {{-- Info Sistem --}}
        <div class="set-card">
            <div class="set-head"><i class="fas fa-server"></i><h6>Info Sistem</h6></div>
            <div class="set-body">
                <div class="sys-row"><span class="sys-lbl">Laravel</span><span class="sys-val">{{ app()->version() }}</span></div>
                <div class="sys-row"><span class="sys-lbl">PHP</span><span class="sys-val">{{ phpversion() }}</span></div>
                <div class="sys-row"><span class="sys-lbl">Environment</span><span class="sys-val">{{ app()->environment() }}</span></div>
                <div class="sys-row"><span class="sys-lbl">Timezone</span><span class="sys-val">{{ config('app.timezone') }}</span></div>
                <div class="sys-row"><span class="sys-lbl">Server Time</span><span class="sys-val">{{ now()->format('d M Y H:i') }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection