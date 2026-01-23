@extends('layouts.app')

@section('title', 'Detail User Warga')

@push('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: bold;
        color: white;
        margin: 0 auto 1rem;
        border: 5px solid rgba(255, 255, 255, 0.3);
    }
    
    .info-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
    }
    
    .info-title {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #3498db;
    }
    
    .info-row {
        display: flex;
        margin-bottom: 0.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px dashed #eee;
    }
    
    .info-label {
        flex: 0 0 150px;
        font-weight: 500;
        color: #6c757d;
    }
    
    .info-value {
        flex: 1;
        color: #2c3e50;
    }
    
    .timeline {
        position: relative;
        padding-left: 2rem;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #3498db;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -1.25rem;
        top: 0.25rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #3498db;
        border: 2px solid white;
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="text-center">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->profile->full_name ?? 'U', 0, 1)) }}
            </div>
            <h2 class="mb-2">{{ $user->profile->full_name }}</h2>
            <p class="mb-0 opacity-75">
                <i class="fas fa-id-card me-1"></i>NIK: {{ $user->profile->nik }}
            </p>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="d-flex justify-content-end mb-4 gap-2">
        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edit
        </a>
        <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-info text-white" onclick="return confirm('Reset password user ini?')">
                <i class="fas fa-key me-2"></i>Reset Password
            </button>
        </form>
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin menghapus user ini?')">
                <i class="fas fa-trash me-2"></i>Hapus
            </button>
        </form>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    
    <div class="row">
        <!-- Data Pribadi -->
        <div class="col-md-6">
            <div class="info-card">
                <h5 class="info-title"><i class="fas fa-user me-2"></i>Data Pribadi</h5>
                
                <div class="info-row">
                    <div class="info-label">NIK</div>
                    <div class="info-value">{{ $user->profile->nik ?? '-' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value">{{ $user->profile->full_name ?? '-' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Jenis Kelamin</div>
                    <div class="info-value">
                        @if($user->profile->jenis_kelamin == 'L')
                            Laki-laki
                        @elseif($user->profile->jenis_kelamin == 'P')
                            Perempuan
                        @else
                            -
                        @endif
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Tempat/Tgl Lahir</div>
                    <div class="info-value">
                        {{ $user->profile->tempat_lahir ?? '-' }} / {{ $user->profile->tanggal_lahir ? \Carbon\Carbon::parse($user->profile->tanggal_lahir)->format('d-m-Y') : '-' }}
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Telepon</div>
                    <div class="info-value">{{ $user->profile->telepon ?? '-' }}</div>
                </div>
            </div>
        </div>
        
        <!-- Alamat -->
        <div class="col-md-6">
            <div class="info-card">
                <h5 class="info-title"><i class="fas fa-home me-2"></i>Alamat</h5>
                
                <div class="info-row">
                    <div class="info-label">Alamat Lengkap</div>
                    <div class="info-value">{{ $user->profile->alamat ?? '-' }}</div>
                </div>
            </div>
        </div>
        
        <!-- Info Akun -->
        <div class="col-md-12">
            <div class="info-card">
                <h5 class="info-title"><i class="fas fa-user-circle me-2"></i>Informasi Akun</h5>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="info-row">
                            <div class="info-label">User ID</div>
                            <div class="info-value">{{ $user->id }}</div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="info-row">
                            <div class="info-label">Role</div>
                            <div class="info-value">
                                <span class="badge bg-primary">{{ strtoupper($user->role) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="info-row">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span class="badge {{ $user->status == 'active' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $user->status == 'active' ? 'AKTIF' : 'NONAKTIF' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="info-row">
                            <div class="info-label">Login Terakhir</div>
                            <div class="info-value">
                                {{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->format('d-m-Y H:i') : 'Belum pernah' }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Dibuat Pada</div>
                    <div class="info-value">{{ $user->created_at->format('d-m-Y H:i') }}</div>
                </div>
                
                <div class="info-row">
                    <div class="info-label">Diperbarui Pada</div>
                    <div class="info-value">{{ $user->updated_at->format('d-m-Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection