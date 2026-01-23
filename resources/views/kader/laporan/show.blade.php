@extends('layouts.kader')

@section('title', 'Detail Pemeriksaan')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-stethoscope me-2"></i>Detail Pemeriksaan
        </h1>
        <div>
            <a href="{{ route('kader.pemeriksaan.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('kader.pemeriksaan.edit', $pemeriksaan->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
        </div>
    </div>

    <!-- Data Card -->
    <div class="row">
        <div class="col-lg-4">
            <!-- Pasien Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-user me-2"></i>Data Pasien
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar-circle bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2" 
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            @if($pemeriksaan->kunjungan->pasien_type == 'App\Models\Balita')
                                <i class="fas fa-baby"></i>
                            @elseif($pemeriksaan->kunjungan->pasien_type == 'App\Models\Remaja')
                                <i class="fas fa-child"></i>
                            @else
                                <i class="fas fa-user-friends"></i>
                            @endif
                        </div>
                        <h5 class="font-weight-bold">{{ $pemeriksaan->kunjungan->pasien->nama_lengkap }}</h5>
                        <span class="badge bg-{{ $pemeriksaan->kunjungan->pasien_type == 'App\Models\Balita' ? 'danger' : ($pemeriksaan->kunjungan->pasien_type == 'App\Models\Remaja' ? 'secondary' : 'dark') }}">
                            @if($pemeriksaan->kunjungan->pasien_type == 'App\Models\Balita')
                                Balita
                            @elseif($pemeriksaan->kunjungan->pasien_type == 'App\Models\Remaja')
                                Remaja
                            @else
                                Lansia
                            @endif
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <strong><i class="fas fa-fingerprint me-2 text-muted"></i>NIK:</strong><br>
                        {{ $pemeriksaan->kunjungan->pasien->nik }}
                    </div>
                    
                   <div class="mb-3">
    <strong><i class="fas fa-birthday-cake me-2 text-muted"></i>TTL:</strong><br>
    {{ $pemeriksaan->kunjungan->pasien->tempat_lahir }}, 
    @if($pemeriksaan->kunjungan->pasien->tanggal_lahir)
        {{ $pemeriksaan->kunjungan->pasien->tanggal_lahir->format('d/m/Y') }}
    @else
        <span class="text-muted">-</span>
    @endif
</div>
                    
                    <div class="mb-3">
                        <strong><i class="fas fa-venus-mars me-2 text-muted"></i>Jenis Kelamin:</strong><br>
                        {{ $pemeriksaan->kunjungan->pasien->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </div>
                    
                    <div class="mb-3">
                        <strong><i class="fas fa-home me-2 text-muted"></i>Alamat:</strong><br>
                        {{ $pemeriksaan->kunjungan->pasien->alamat }}
                    </div>
                </div>
            </div>
            
            <!-- Kunjungan Card -->
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-calendar-check me-2"></i>Data Kunjungan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
    <strong><i class="fas fa-calendar-alt me-2 text-muted"></i>Tanggal:</strong><br>
    @if($pemeriksaan->kunjungan->tanggal_kunjungan)
        {{ $pemeriksaan->kunjungan->tanggal_kunjungan->format('d/m/Y') }}
    @else
        <span class="text-muted">-</span>
    @endif
</div>
                    
                    <div class="mb-3">
                        <strong><i class="fas fa-stethoscope me-2 text-muted"></i>Jenis Kunjungan:</strong><br>
                        <span class="badge bg-{{ $pemeriksaan->kunjungan->jenis_kunjungan == 'imunisasi' ? 'success' : ($pemeriksaan->kunjungan->jenis_kunjungan == 'pemeriksaan' ? 'primary' : 'warning') }}">
                            {{ ucfirst($pemeriksaan->kunjungan->jenis_kunjungan) }}
                        </span>
                    </div>
                    
                    <div class="mb-3">
                        <strong><i class="fas fa-user-md me-2 text-muted"></i>Petugas:</strong><br>
                        {{ $pemeriksaan->kunjungan->petugas->profile->full_name ?? 'Sistem' }}
                    </div>
                    
                    @if($pemeriksaan->kunjungan->keluhan)
                    <div class="mb-3">
                        <strong><i class="fas fa-comment-medical me-2 text-muted"></i>Keluhan:</strong><br>
                        {{ $pemeriksaan->kunjungan->keluhan }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <!-- Pemeriksaan Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-clipboard-check me-2"></i>Hasil Pemeriksaan
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Vital Signs -->
                    <h6 class="font-weight-bold text-success mb-3">
                        <i class="fas fa-heartbeat me-2"></i>Vital Signs
                    </h6>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Berat Badan</h6>
                                    <h4 class="font-weight-bold">{{ $pemeriksaan->berat_badan ?? '-' }}</h4>
                                    <small class="text-muted">kg</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Tinggi Badan</h6>
                                    <h4 class="font-weight-bold">{{ $pemeriksaan->tinggi_badan ?? '-' }}</h4>
                                    <small class="text-muted">cm</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">IMT</h6>
                                    <h4 class="font-weight-bold">{{ $pemeriksaan->imt ? number_format($pemeriksaan->imt, 2) : '-' }}</h4>
                                    @if($pemeriksaan->kategori_imt)
                                    <span class="badge bg-{{ $pemeriksaan->kategori_imt == 'normal' ? 'success' : ($pemeriksaan->kategori_imt == 'kurus' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($pemeriksaan->kategori_imt) }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Suhu Tubuh</h6>
                                    <h4 class="font-weight-bold">{{ $pemeriksaan->suhu_tubuh ?? '-' }}</h4>
                                    <small class="text-muted">°C</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Measurements -->
                    @if($pemeriksaan->kunjungan->pasien_type == 'App\Models\Balita')
                    <h6 class="font-weight-bold text-success mb-3">
                        <i class="fas fa-ruler me-2"></i>Pengukuran Balita
                    </h6>
                    <div class="row mb-4">
                        @if($pemeriksaan->lingkar_kepala)
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Lingkar Kepala</h6>
                                    <h4 class="font-weight-bold">{{ $pemeriksaan->lingkar_kepala }}</h4>
                                    <small class="text-muted">cm</small>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($pemeriksaan->lingkar_lengan)
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Lingkar Lengan</h6>
                                    <h4 class="font-weight-bold">{{ $pemeriksaan->lingkar_lengan }}</h4>
                                    <small class="text-muted">cm</small>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    <!-- Lab Results -->
                    @if($pemeriksaan->kunjungan->pasien_type == 'App\Models\Remaja' || $pemeriksaan->kunjungan->pasien_type == 'App\Models\Lansia')
                    <h6 class="font-weight-bold text-success mb-3">
                        <i class="fas fa-flask me-2"></i>Hasil Laboratorium
                    </h6>
                    <div class="row mb-4">
                        @if($pemeriksaan->tekanan_darah)
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Tekanan Darah</h6>
                                    <h4 class="font-weight-bold">{{ $pemeriksaan->tekanan_darah }}</h4>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($pemeriksaan->hemoglobin)
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Hemoglobin</h6>
                                    <h4 class="font-weight-bold">{{ $pemeriksaan->hemoglobin }}</h4>
                                    <small class="text-muted">g/dL</small>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($pemeriksaan->gula_darah)
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Gula Darah</h6>
                                    <h4 class="font-weight-bold">{{ $pemeriksaan->gula_darah }}</h4>
                                    <small class="text-muted">mg/dL</small>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if($pemeriksaan->kolesterol)
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Kolesterol</h6>
                                    <h4 class="font-weight-bold">{{ $pemeriksaan->kolesterol }}</h4>
                                    <small class="text-muted">mg/dL</small>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                    
                    <!-- Diagnosis & Recommendation -->
                    <h6 class="font-weight-bold text-success mb-3">
                        <i class="fas fa-file-medical me-2"></i>Diagnosa & Rekomendasi
                    </h6>
                    
                    @if($pemeriksaan->diagnosa)
                    <div class="mb-3">
                        <strong>Diagnosa:</strong>
                        <p class="mb-2">{{ $pemeriksaan->diagnosa }}</p>
                    </div>
                    @endif
                    
                    @if($pemeriksaan->tindakan)
                    <div class="mb-3">
                        <strong>Tindakan:</strong>
                        <p class="mb-2">{{ $pemeriksaan->tindakan }}</p>
                    </div>
                    @endif
                    
                    @if($pemeriksaan->rekomendasi)
                    <div class="mb-3">
                        <strong>Rekomendasi:</strong>
                        <p class="mb-2">{{ $pemeriksaan->rekomendasi }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection