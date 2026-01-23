@extends('layouts.app')

@section('title', 'Edit User Warga')

@push('styles')
<style>
    .card-form {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        background: white;
    }
    
    .card-header-form {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
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
    }
    
    .section-title {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #3498db;
    }
    
    .section-title i {
        color: #3498db;
        margin-right: 0.5rem;
    }
    
    .required-label::after {
        content: " *";
        color: #e74c3c;
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2><i class="fas fa-user-edit me-2"></i>Edit User Warga</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">User Warga</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card-form">
        <div class="card-header-form">
            <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Form Edit Data Warga</h4>
            <p class="mb-0 opacity-75">Edit data warga {{ $user->profile->full_name }}</p>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Data Pribadi -->
                <div class="form-section">
                    <h5 class="section-title"><i class="fas fa-user"></i>Data Pribadi</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label required-label">Nama Lengkap</label>
                            <input type="text" 
                                   class="form-control @error('full_name') is-invalid @enderror" 
                                   id="full_name" 
                                   name="full_name" 
                                   value="{{ old('full_name', $user->profile->full_name) }}"
                                   placeholder="Masukkan nama lengkap">
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
                                   value="{{ old('nik', $user->profile->nik) }}"
                                   maxlength="16"
                                   placeholder="16 digit NIK">
                            <small class="form-text text-muted">NIK digunakan sebagai username login</small>
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
                                    name="jenis_kelamin">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" {{ old('jenis_kelamin', $user->profile->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $user->profile->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label">Nomor Telepon</label>
                            <input type="text" 
                                   class="form-control @error('telepon') is-invalid @enderror" 
                                   id="telepon" 
                                   name="telepon" 
                                   value="{{ old('telepon', $user->profile->telepon) }}"
                                   placeholder="Contoh: 081234567890">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Data Tempat Tinggal -->
                <div class="form-section">
                    <h5 class="section-title"><i class="fas fa-home"></i>Data Tempat Tinggal</h5>
                    
                    <div class="mb-3">
                        <label for="alamat" class="form-label required-label">Alamat Lengkap</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                  id="alamat" 
                                  name="alamat" 
                                  rows="3"
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->profile->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" 
                                   class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                   id="tempat_lahir" 
                                   name="tempat_lahir" 
                                   value="{{ old('tempat_lahir', $user->profile->tempat_lahir) }}"
                                   placeholder="Kota/Kabupaten lahir">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" 
                                   class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                   id="tanggal_lahir" 
                                   name="tanggal_lahir" 
                                   value="{{ old('tanggal_lahir', $user->profile->tanggal_lahir ? \Carbon\Carbon::parse($user->profile->tanggal_lahir)->format('Y-m-d') : '') }}">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Status Akun -->
                <div class="form-section">
                    <h5 class="section-title"><i class="fas fa-cog"></i>Status Akun</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label required-label">Status Akun</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status">
                                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Format NIK input
    document.getElementById('nik').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    
    // Format telepon input
    document.getElementById('telepon').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9+]/g, '');
    });
</script>
@endpush