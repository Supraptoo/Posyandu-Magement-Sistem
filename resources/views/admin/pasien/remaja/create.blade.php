@extends('layouts.app')

@section('title', 'Tambah Data Remaja')

@push('styles')
<style>
    .form-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .form-header {
        border-bottom: 2px solid #9b59b6;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }
    
    .form-header h3 {
        color: #8e44ad;
        font-weight: 600;
        margin: 0;
    }
    
    .form-header i {
        color: #9b59b6;
        margin-right: 0.75rem;
    }
    
    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }
    
    .form-control-custom {
        border: 2px solid rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }
    
    .form-control-custom:focus {
        border-color: #9b59b6;
        box-shadow: 0 0 0 3px rgba(155, 89, 182, 0.1);
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(155, 89, 182, 0.3);
    }
    
    .btn-cancel {
        background: white;
        border: 2px solid #dee2e6;
        color: #6c757d;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-cancel:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
    }
    
    .section-title {
        color: #8e44ad;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(155, 89, 182, 0.2);
    }
    
    .info-box {
        background: rgba(155, 89, 182, 0.05);
        border: 1px solid rgba(155, 89, 182, 0.2);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .info-box i {
        color: #9b59b6;
        margin-right: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="page-header animate-fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-user-plus me-2"></i>Tambah Data Remaja</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.pasien.remaja.index') }}">Remaja</a></li>
                    <li class="breadcrumb-item active">Tambah Baru</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.pasien.remaja.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="form-card animate-fade-in" style="animation-delay: 0.1s">
    <form action="{{ route('admin.pasien.remaja.store') }}" method="POST">
        @csrf
        
        <div class="form-header">
            <h3><i class="fas fa-child"></i>Informasi Remaja</h3>
            <p class="text-muted mb-0">Lengkapi data remaja baru di bawah ini.</p>
        </div>
        
        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <strong>Informasi:</strong> Pastikan data yang diisi sudah benar dan sesuai dengan dokumen yang valid.
        </div>
        
        <h5 class="section-title">Data Pribadi</h5>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" 
                       name="nama_lengkap" 
                       class="form-control form-control-custom @error('nama_lengkap') is-invalid @enderror" 
                       value="{{ old('nama_lengkap') }}" 
                       required
                       placeholder="Masukkan nama lengkap">
                @error('nama_lengkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">NIK</label>
                <input type="text" 
                       name="nik" 
                       class="form-control form-control-custom @error('nik') is-invalid @enderror" 
                       value="{{ old('nik') }}" 
                       required 
                       maxlength="16"
                       placeholder="Masukkan NIK (16 digit)">
                @error('nik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text text-muted small mt-1">Nomor Induk Kependudukan 16 digit</div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Tempat Lahir</label>
                <input type="text" 
                       name="tempat_lahir" 
                       class="form-control form-control-custom @error('tempat_lahir') is-invalid @enderror" 
                       value="{{ old('tempat_lahir') }}"
                       required
                       placeholder="Masukkan tempat lahir">
                @error('tempat_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" 
                       name="tanggal_lahir" 
                       class="form-control form-control-custom @error('tanggal_lahir') is-invalid @enderror" 
                       value="{{ old('tanggal_lahir') }}"
                       required>
                @error('tanggal_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text text-muted small mt-1">Remaja berusia 10-18 tahun</div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" 
                        class="form-select form-control-custom @error('jenis_kelamin') is-invalid @enderror"
                        required>
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Alamat</label>
                <input type="text" 
                       name="alamat" 
                       class="form-control form-control-custom @error('alamat') is-invalid @enderror" 
                       value="{{ old('alamat') }}"
                       required
                       placeholder="Masukkan alamat lengkap">
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <h5 class="section-title mt-4">Informasi Pendidikan</h5>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Sekolah</label>
                <input type="text" 
                       name="sekolah" 
                       class="form-control form-control-custom @error('sekolah') is-invalid @enderror" 
                       value="{{ old('sekolah') }}"
                       required
                       placeholder="Nama sekolah">
                @error('sekolah')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Kelas</label>
                <input type="text" 
                       name="kelas" 
                       class="form-control form-control-custom @error('kelas') is-invalid @enderror" 
                       value="{{ old('kelas') }}"
                       required
                       placeholder="Contoh: X, XI, XII">
                @error('kelas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <h5 class="section-title mt-4">Informasi Orang Tua</h5>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nama Orang Tua</label>
                <input type="text" 
                       name="nama_ortu" 
                       class="form-control form-control-custom @error('nama_ortu') is-invalid @enderror" 
                       value="{{ old('nama_ortu') }}"
                       placeholder="Nama ayah/ibu">
                @error('nama_ortu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="col-md-6 mb-3">
                <label class="form-label">Telepon Orang Tua</label>
                <input type="tel" 
                       name="telepon_ortu" 
                       class="form-control form-control-custom @error('telepon_ortu') is-invalid @enderror" 
                       value="{{ old('telepon_ortu') }}"
                       placeholder="0812xxxxxxx">
                @error('telepon_ortu')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <a href="{{ route('admin.pasien.remaja.index') }}" class="btn-cancel">
                <i class="fas fa-times me-2"></i>Batal
            </a>
            <button type="submit" class="btn-submit">
                <i class="fas fa-save me-2"></i>Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Set date range for teenager (10-18 years)
    const today = new Date();
    const maxDate = new Date(today.getFullYear() - 10, today.getMonth(), today.getDate());
    const minDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
    
    document.querySelector('input[name="tanggal_lahir"]').max = maxDate.toISOString().split('T')[0];
    document.querySelector('input[name="tanggal_lahir"]').min = minDate.toISOString().split('T')[0];
    
    // NIK validation
    document.querySelector('input[name="nik"]').addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '').slice(0, 16);
    });
    
    // Phone number validation
    document.querySelector('input[name="telepon_ortu"]').addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '').slice(0, 15);
    });
</script>
@endpush