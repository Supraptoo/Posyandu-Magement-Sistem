@extends('layouts.app')

@section('title', 'Tambah User Warga')

@push('styles')
<style>
:root{--t:#0d9488;--t2:#0ea5e9;--tbg:#f0fdfa;--bdr:#e2e8f0;--text:#0f172a;--muted:#64748b;--r:14px;--rs:9px;--shad:0 1px 3px rgba(0,0,0,.05),0 4px 16px rgba(0,0,0,.04);}
.f-hero{background:linear-gradient(135deg,#0d9488,#0ea5e9);border-radius:var(--r);padding:1.4rem 1.75rem;color:#fff;margin-bottom:1.25rem;position:relative;overflow:hidden;}
.f-hero::before{content:'';position:absolute;width:150px;height:150px;border-radius:50%;background:rgba(255,255,255,.07);top:-40px;right:-30px;pointer-events:none;}
.f-hero h4{font-size:1.15rem;font-weight:800;margin:0;letter-spacing:-.02em;}
.f-hero p{font-size:.8rem;opacity:.82;margin:.2rem 0 0;}
.f-card{background:#fff;border:1px solid var(--bdr);border-radius:var(--r);box-shadow:var(--shad);overflow:hidden;margin-bottom:1.1rem;}
.f-section-head{display:flex;align-items:center;gap:.55rem;font-size:.72rem;font-weight:800;text-transform:uppercase;letter-spacing:.08em;color:var(--t);padding:.9rem 1.25rem;border-bottom:1px solid #f1f5f9;background:var(--tbg);}
.f-section-head i{font-size:.85rem;}
.f-body{padding:1.25rem;}
.f-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem;}
.f-group{display:flex;flex-direction:column;gap:.35rem;margin-bottom:.9rem;}
.f-group label{font-size:.78rem;font-weight:700;color:var(--text);}
.f-group label .req{color:#ef4444;margin-left:.15rem;}
.f-group input,.f-group select,.f-group textarea{
    border:1.5px solid var(--bdr);border-radius:var(--rs);
    padding:.5rem .85rem;font-size:.85rem;color:var(--text);
    outline:none;transition:border-color .15s;background:#fff;width:100%;
}
.f-group input:focus,.f-group select:focus,.f-group textarea:focus{border-color:var(--t);box-shadow:0 0 0 3px rgba(13,148,136,.1);}
.f-group input.is-invalid,.f-group select.is-invalid,.f-group textarea.is-invalid{border-color:#ef4444;}
.f-group .err{font-size:.72rem;color:#ef4444;}
.f-group .hint{font-size:.71rem;color:var(--muted);}
.info-box{background:var(--tbg);border:1px solid #99f6e4;border-radius:var(--rs);padding:.9rem 1.1rem;font-size:.8rem;color:var(--t);}
.info-box ul{margin:.4rem 0 0;padding-left:1.1rem;}
.info-box ul li{margin-bottom:.2rem;}
.f-actions{display:flex;justify-content:space-between;align-items:center;padding:.9rem 1.25rem;border-top:1px solid #f1f5f9;background:#fafcff;}
.btn-cancel{display:inline-flex;align-items:center;gap:.4rem;padding:.48rem 1rem;border-radius:var(--rs);font-size:.82rem;font-weight:600;color:var(--muted);border:1.5px solid var(--bdr);background:#fff;text-decoration:none;transition:all .15s;}
.btn-cancel:hover{background:#f8fafc;color:var(--text);}
.btn-save{display:inline-flex;align-items:center;gap:.4rem;padding:.48rem 1.25rem;border-radius:var(--rs);font-size:.82rem;font-weight:700;color:#fff;border:none;background:linear-gradient(135deg,var(--t),var(--t2));cursor:pointer;transition:opacity .15s;}
.btn-save:hover{opacity:.88;}
@media(max-width:600px){.f-row{grid-template-columns:1fr;}}
</style>
@endpush

@section('content')
<div class="container-fluid px-0" style="max-width:760px;">

    {{-- Hero --}}
    <div class="f-hero">
        <div style="position:relative;z-index:2;">
            <div style="font-size:.65rem;font-weight:800;letter-spacing:.1em;text-transform:uppercase;opacity:.75;">
                <a href="{{ route('admin.users.index') }}" style="color:rgba(255,255,255,.8);text-decoration:none;">
                    User Warga
                </a> / Tambah Baru
            </div>
            <h4><i class="fas fa-user-plus me-2"></i>Daftarkan User Warga Baru</h4>
            <p>NIK yang didaftarkan akan otomatis terhubung ke data balita/remaja/lansia yang sesuai.</p>
        </div>
    </div>

    @if($errors->any())
    <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:var(--rs);padding:.75rem 1rem;margin-bottom:1rem;font-size:.82rem;color:#dc2626;">
        <i class="fas fa-exclamation-circle me-1"></i> Mohon periksa kembali data yang diisi.
    </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        {{-- Seksi 1: Data Pribadi --}}
        <div class="f-card">
            <div class="f-section-head"><i class="fas fa-user"></i> Data Pribadi</div>
            <div class="f-body">
                <div class="f-row">
                    <div class="f-group">
                        <label>Nama Lengkap<span class="req">*</span></label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}"
                            placeholder="Nama sesuai KTP" class="{{ $errors->has('full_name') ? 'is-invalid' : '' }}">
                        @error('full_name') <span class="err">{{ $message }}</span> @enderror
                    </div>
                    <div class="f-group">
                        <label>NIK (16 digit)<span class="req">*</span></label>
                        <input type="text" name="nik" id="nikInput" value="{{ old('nik') }}"
                            placeholder="16 digit NIK KTP" maxlength="16"
                            class="{{ $errors->has('nik') ? 'is-invalid' : '' }}">
                        <span class="hint"><i class="fas fa-info-circle me-1"></i>NIK digunakan sebagai username login</span>
                        @error('nik') <span class="err">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="f-row">
                    <div class="f-group">
                        <label>Jenis Kelamin<span class="req">*</span></label>
                        <select name="jenis_kelamin" class="{{ $errors->has('jenis_kelamin') ? 'is-invalid' : '' }}">
                            <option value="">Pilih...</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <span class="err">{{ $message }}</span> @enderror
                    </div>
                    <div class="f-group">
                        <label>Nomor Telepon</label>
                        <input type="text" name="telepon" id="telponInput" value="{{ old('telepon') }}"
                            placeholder="08xxxxxxxxxx">
                        @error('telepon') <span class="err">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Seksi 2: Alamat & Kelahiran --}}
        <div class="f-card">
            <div class="f-section-head"><i class="fas fa-map-marker-alt"></i> Alamat & Tanggal Lahir</div>
            <div class="f-body">
                <div class="f-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                    @error('alamat') <span class="err">{{ $message }}</span> @enderror
                </div>
                <div class="f-row">
                    <div class="f-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Kota/Kabupaten">
                        @error('tempat_lahir') <span class="err">{{ $message }}</span> @enderror
                    </div>
                    <div class="f-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                        @error('tanggal_lahir') <span class="err">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Seksi 3: Akun --}}
        <div class="f-card">
            <div class="f-section-head"><i class="fas fa-shield-alt"></i> Pengaturan Akun</div>
            <div class="f-body">
                <div class="f-row">
                    <div class="f-group">
                        <label>Status Akun<span class="req">*</span></label>
                        <select name="status">
                            <option value="active"   {{ old('status','active') == 'active'   ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('status') <span class="err">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="info-box">
                    <strong><i class="fas fa-key me-1"></i>Informasi Password:</strong>
                    <ul>
                        <li>Password akan digenerate otomatis oleh sistem (8 karakter acak)</li>
                        <li>Password akan ditampilkan sekali setelah user berhasil dibuat</li>
                        <li>NIK digunakan sebagai username login, bukan email</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="f-actions">
            <a href="{{ route('admin.users.index') }}" class="btn-cancel">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn-save">
                <i class="fas fa-save"></i> Simpan & Daftarkan
            </button>
        </div>
    </form>

</div>
@endsection

@push('scripts')
<script>
document.getElementById('nikInput').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, '');
});
document.getElementById('telponInput').addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9+]/g, '');
});
</script>
@endpush