@extends('layouts.app')

@section('title', 'Tambah Data Lansia')

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
        border-bottom: 2px solid #e74c3c;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }
    
    .form-header h3 {
        color: #c0392b;
        font-weight: 600;
        margin: 0;
    }
    
    .form-header i {
        color: #e74c3c;
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
        border-color: #e74c3c;
        box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
    }
    
    .btn-submit {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
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
        color: #c0392b;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(231, 76, 60, 0.2);
    }
    
    .info-box {
        background: rgba(231, 76, 60, 0.05);
        border: 1px solid rgba(231, 76, 60, 0.2);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .info-box i {
        color: #e74c3c;
        margin-right: 0.5rem;
    }
    
    textarea.form-control-custom {
        min-height: 100px;
        resize: vertical;
    }
</style>
@endpush

@section('content')
<div class="page-header animate-fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2><i class="fas fa-user-plus me-2"></i>Tambah Data Lansia</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.pasien.lansia.index') }}">Lansia</a></li>
                    <li class="breadcrumb-item active">Tambah Baru</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.pasien.lansia.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
</div>

<div class="form-card animate-fade-in" style="animation-delay: 0.1s">
    <form action="{{ route('admin.pasien.lansia.store') }}" method="POST">
        @csrf
        
        <div class="form-header">
            <h3><i class="fas fa-user-friends"></i>Informasi Lansia</h3>
            <p class="text-muted mb-0">Lengkapi data lansia baru di bawah ini.</p>
        </div>
        
        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <strong>Informasi:</strong> Data lansia untuk usia 60 tahun ke atas. Pastikan data sesuai dengan dokumen.
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
                <div class="form-text text-muted small mt-1">Minimal 60 tahun</div>
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
        
        <h5 class="section-title mt-4">Informasi Kesehatan</h5>
        
        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label">Penyakit Bawaan/Kronis</label>
                <textarea name="penyakit_bawaan" 
                          class="form-control form-control-custom @error('penyakit_bawaan') is-invalid @enderror" 
                          rows="3"
                          placeholder="Contoh: Hipertensi, Diabetes, Asma, dll. (kosongkan jika tidak ada)">{{ old('penyakit_bawaan') }}</textarea>
                @error('penyakit_bawaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text text-muted small mt-1">
                    Informasikan penyakit yang diderita untuk penanganan yang lebih baik
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <a href="{{ route('admin.pasien.lansia.index') }}" class="btn-cancel">
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
    // Set minimum date for elderly (60 years ago)
    const today = new Date();
    const minDate = new Date(today.getFullYear() - 60, today.getMonth(), today.getDate());
    document.querySelector('input[name="tanggal_lahir"]').max = minDate.toISOString().split('T')[0];
    
    // NIK validation
    document.querySelector('input[name="nik"]').addEventListener('input', function(e) {
        this.value = this.value.replace(/\D/g, '').slice(0, 16);
    });
</script>
@endpush