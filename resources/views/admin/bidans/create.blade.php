@extends('layouts.app')

@section('title', 'Tambah Bidan')

@push('styles')
<style>
    .card-form {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        background: white;
    }
    
    .card-header-form {
        background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
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
        border-bottom: 2px solid #27ae60;
    }
    
    .section-title i {
        color: #27ae60;
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
                <h2><i class="fas fa-user-plus me-2"></i>Tambah Bidan Baru</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.bidans.index') }}">Bidan</a></li>
                        <li class="breadcrumb-item active">Tambah Baru</li>
                    </ol>
                </nav>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="{{ route('admin.bidans.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card-form">
        <div class="card-header-form">
            <h4 class="mb-0"><i class="fas fa-user-md me-2"></i>Form Pendaftaran Bidan</h4>
            <p class="mb-0 opacity-75">Isi data bidan dengan lengkap dan benar</p>
        </div>
        
        <div class="card-body p-4">
            <form action="{{ route('admin.bidans.store') }}" method="POST">
                @csrf
                
                <!-- Data Akun -->
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
                                   placeholder="email@example.com">
                            <small class="form-text text-muted">Email akan digunakan sebagai username login</small>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label required-label">Status Akun</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
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
                                   value="{{ old('full_name') }}"
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
                                   value="{{ old('nik') }}"
                                   maxlength="16"
                                   placeholder="16 digit NIK">
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
                                   placeholder="Contoh: 081234567890">
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
                                  placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Data Bidan -->
                <div class="form-section">
                    <h5 class="section-title"><i class="fas fa-user-md"></i>Data Bidan</h5>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sip" class="form-label required-label">Nomor SIP</label>
                            <input type="text" 
                                   class="form-control @error('sip') is-invalid @enderror" 
                                   id="sip" 
                                   name="sip" 
                                   value="{{ old('sip') }}"
                                   placeholder="Contoh: SIP-123456">
                            @error('sip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="spesialisasi" class="form-label required-label">Spesialisasi</label>
                            <select class="form-select @error('spesialisasi') is-invalid @enderror" 
                                    id="spesialisasi" 
                                    name="spesialisasi">
                                <option value="">Pilih Spesialisasi</option>
                                <option value="Kesehatan Ibu dan Anak" {{ old('spesialisasi') == 'Kesehatan Ibu dan Anak' ? 'selected' : '' }}>Kesehatan Ibu dan Anak</option>
                                <option value="Kebidanan" {{ old('spesialisasi') == 'Kebidanan' ? 'selected' : '' }}>Kebidanan</option>
                                <option value="Kesehatan Reproduksi" {{ old('spesialisasi') == 'Kesehatan Reproduksi' ? 'selected' : '' }}>Kesehatan Reproduksi</option>
                                <option value="Keluarga Berencana" {{ old('spesialisasi') == 'Keluarga Berencana' ? 'selected' : '' }}>Keluarga Berencana</option>
                                <option value="Lainnya" {{ old('spesialisasi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('spesialisasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="rumah_sakit" class="form-label">Rumah Sakit/Praktek</label>
                        <input type="text" 
                               class="form-control @error('rumah_sakit') is-invalid @enderror" 
                               id="rumah_sakit" 
                               name="rumah_sakit" 
                               value="{{ old('rumah_sakit') }}"
                               placeholder="Nama rumah sakit atau tempat praktek">
                        @error('rumah_sakit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <!-- Informasi Sistem -->
                <div class="form-section">
                    <h5 class="section-title"><i class="fas fa-info-circle"></i>Informasi Sistem</h5>
                    
                    <div class="alert alert-success">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Catatan Penting:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Password akan digenerate otomatis oleh sistem</li>
                            <li>Password akan ditampilkan setelah proses pendaftaran selesai</li>
                            <li>Bidan akan login menggunakan email yang didaftarkan</li>
                            <li>Pastikan email valid dan dapat diakses</li>
                            <li>SIP harus unik dan valid</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.bidans.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-success">
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