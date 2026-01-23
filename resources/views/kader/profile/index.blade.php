@extends('layouts.kader')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user me-2"></i>Profil Saya
        </h1>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!-- Profile Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-id-card me-2"></i>Informasi Profil
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="avatar-circle bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" 
                         style="width: 100px; height: 100px; font-size: 2.5rem;">
                        <i class="fas fa-user-nurse"></i>
                    </div>
                    
                    <h4 class="font-weight-bold">{{ $user->profile->full_name ?? $user->email }}</h4>
                    <span class="badge bg-primary mb-3">Kader Posyandu</span>
                    
                    <hr>
                    
                    <div class="text-start">
                        <p>
                            <strong><i class="fas fa-envelope me-2 text-muted"></i>Email:</strong><br>
                            {{ $user->email }}
                        </p>
                        
                        <p>
                            <strong><i class="fas fa-fingerprint me-2 text-muted"></i>NIK:</strong><br>
                            {{ $user->profile->nik ?? '-' }}
                        </p>
                        
                        <p>
                            <strong><i class="fas fa-phone me-2 text-muted"></i>Telepon:</strong><br>
                            {{ $user->profile->telepon ?? '-' }}
                        </p>
                        
                        <p>
                            <strong><i class="fas fa-map-marker-alt me-2 text-muted"></i>Alamat:</strong><br>
                            {{ $user->profile->alamat ?? '-' }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Status -->
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-info-circle me-2"></i>Status Akun
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'danger' }}">
                            {{ $user->status == 'active' ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Login Terakhir:</strong><br>
                        {{ $user->last_login_at ? $user->last_login_at->translatedFormat('d F Y H:i') : '-' }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Bergabung Sejak:</strong><br>
                        {{ $user->created_at->translatedFormat('d F Y') }}
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <!-- Edit Profile Form -->
            <div class="card shadow mb-4">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-edit me-2"></i>Edit Profil
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('kader.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="full_name" class="form-label">Nama Lengkap *</label>
                                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                           id="full_name" name="full_name" 
                                           value="{{ old('full_name', $user->profile->full_name ?? '') }}" required>
                                    @error('full_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" 
                                           id="nik" name="nik" maxlength="16"
                                           value="{{ old('nik', $user->profile->nik ?? '') }}">
                                    @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                           id="tempat_lahir" name="tempat_lahir" 
                                           value="{{ old('tempat_lahir', $user->profile->tempat_lahir ?? '') }}">
                                    @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                           id="tanggal_lahir" name="tanggal_lahir" 
                                           value="{{ old('tanggal_lahir', $user->profile->tanggal_lahir ?? '') }}">
                                    @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="telepon" class="form-label">Telepon *</label>
                                    <input type="text" class="form-control @error('telepon') is-invalid @enderror" 
                                           id="telepon" name="telepon" 
                                           value="{{ old('telepon', $user->profile->telepon ?? '') }}" required>
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                            id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" {{ old('jenis_kelamin', $user->profile->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin', $user->profile->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat *</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                      id="alamat" name="alamat" rows="3" required>{{ old('alamat', $user->profile->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr>
                        <div class="text-end">
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Activity -->
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-history me-2"></i>Aktivitas Terakhir
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-sign-in-alt text-success me-2"></i>
                                <strong>Login Terakhir</strong>
                                <small class="d-block text-muted">
                                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : '-' }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-calendar-check text-primary me-2"></i>
                                <strong>Kunjungan Hari Ini</strong>
                                <small class="d-block text-muted">
                                    {{ $user->kunjungan()->whereDate('created_at', today())->count() }} kali
                                </small>
                            </div>
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-user-plus text-info me-2"></i>
                                <strong>Pasien Terdaftar</strong>
                                <small class="d-block text-muted">
                                    {{ $user->createdBalitas->count() + $user->createdRemajas->count() + $user->createdLansias->count() }} orang
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set max date for tanggal lahir
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal_lahir').max = today;
});
</script>
@endpush
@endsection