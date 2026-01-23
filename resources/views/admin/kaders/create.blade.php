@extends('layouts.app')

@section('title', 'Tambah Kader')

@push('styles')
<style>
    .card-form {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        background: white;
    }
    
    .card-header-form {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
        border: none;
    }
    
    .form-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border-left: 5px solid #f39c12; /* Penanda visual section */
    }
    
    .section-title {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #dee2e6;
    }
    
    .section-title i {
        color: #f39c12;
        margin-right: 0.5rem;
    }
    
    .required-label::after {
        content: " *";
        color: #e74c3c;
        font-weight: bold;
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2 class="mb-0"><i class="fas fa-user-plus me-2"></i>Tambah Kader Baru</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.kaders.index') }}">Kader</a></li>
                        <li class="breadcrumb-item active">Tambah Baru</li>
                    </ol>
                </nav>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="{{ route('admin.kaders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
            <div>
                <strong>Gagal Menyimpan Data!</strong>
                <p class="mb-0">Mohon periksa inputan berikut:</p>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card-form">
        <div class="card-header-form">
            <h4 class="mb-0"><i class="fas fa-user-nurse me-2"></i>Form Pendaftaran Kader</h4>
            <p class="mb-0 opacity-75">Isi data kader dengan lengkap dan benar</p>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('admin.kaders.store') }}" method="POST" id="kaderForm">
                @csrf
                
                <div class="form-section">
                    <h5 class="section-title"><i class="fas fa-user-circle"></i>Data Akun</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label required-label">Email</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="email@example.com"
                                   required>
                            <small class="form-text text-muted">Email akan digunakan sebagai username login</small>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label required-label">Status Akun</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status"
                                    required>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h5 class="section-title"><i class="fas fa-user"></i>Data Pribadi</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label required-label">Nama Lengkap</label>
                            <input type="text" 
                                   class="form-control @error('full_name') is-invalid @enderror" 
                                   id="full_name" 
                                   name="full_name" 
                                   value="{{ old('full_name') }}"
                                   placeholder="Masukkan nama lengkap"
                                   required>
                            @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nik" class="form-label required-label">NIK (16 digit)</label>
                            <input type="text" 
                                   class="form-control @error('nik') is-invalid @enderror" 
                                   id="nik" 
                                   name="nik" 
                                   value="{{ old('nik') }}"
                                   maxlength="16"
                                   minlength="16"
                                   placeholder="16 digit NIK"
                                   required>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jenis_kelamin" class="form-label required-label">Jenis Kelamin</label>
                            <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                    id="jenis_kelamin" 
                                    name="jenis_kelamin"
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
                            <label for="telepon" class="form-label required-label">Nomor Telepon</label>
                            <input type="text" 
                                   class="form-control @error('telepon') is-invalid @enderror" 
                                   id="telepon" 
                                   name="telepon" 
                                   value="{{ old('telepon') }}"
                                   placeholder="Contoh: 081234567890"
                                   required>
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="alamat" class="form-label required-label">Alamat Lengkap</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" 
                                  name="alamat" 
                                  rows="3"
                                  placeholder="Masukkan alamat lengkap"
                                  required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="form-section">
                    <h5 class="section-title"><i class="fas fa-user-nurse"></i>Data Kader</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jabatan" class="form-label required-label">Jabatan</label>
                            <input type="text" 
                                   class="form-control @error('jabatan') is-invalid @enderror" 
                                   id="jabatan" 
                                   name="jabatan" 
                                   value="{{ old('jabatan') }}"
                                   placeholder="Contoh: Kader Utama, Kader Pendamping"
                                   required>
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_bergabung" class="form-label required-label">Tanggal Bergabung</label>
                            <input type="date" 
                                   class="form-control @error('tanggal_bergabung') is-invalid @enderror" 
                                   id="tanggal_bergabung" 
                                   name="tanggal_bergabung" 
                                   value="{{ old('tanggal_bergabung', date('Y-m-d')) }}"
                                   required>
                            @error('tanggal_bergabung')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status_kader" class="form-label required-label">Status Kader</label>
                            <select class="form-select @error('status_kader') is-invalid @enderror" 
                                    id="status_kader" 
                                    name="status_kader"
                                    required>
                                <option value="aktif" {{ old('status_kader') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status_kader') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status_kader')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h5 class="section-title"><i class="fas fa-info-circle"></i>Informasi Sistem</h5>
                    
                    <div class="alert alert-warning">
                        <div class="d-flex">
                            <i class="fas fa-lightbulb fa-lg me-3 mt-1"></i>
                            <div>
                                <strong>Catatan Penting:</strong>
                                <ul class="mb-0 mt-2 ps-3">
                                    <li>Password akan digenerate otomatis oleh sistem.</li>
                                    <li>Password akan ditampilkan pada notifikasi sukses setelah data disimpan.</li>
                                    <li>Kader dapat login menggunakan Email dan Password yang diberikan.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.kaders.index') }}" class="btn btn-secondary btn-lg px-4">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-warning btn-lg px-4" id="btnSubmit">
                        <i class="fas fa-save me-2"></i>Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Format NIK input (Hanya Angka)
    document.getElementById('nik').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    // Format telepon input (Hanya Angka)
    document.getElementById('telepon').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Loading State saat Submit
    document.getElementById('kaderForm').addEventListener('submit', function() {
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Menyimpan...';
    });
</script>
@endpush