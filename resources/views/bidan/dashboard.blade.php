@extends('layouts.app')

@section('title', 'Dashboard Bidan')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-md me-2"></i>Dashboard Bidan
        </h1>
        <div class="d-none d-sm-inline-block">
            <span class="badge bg-primary">
                <i class="fas fa-calendar me-1"></i> {{ now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row">
        <!-- Kunjungan Hari Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Kunjungan Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['kunjungan_hari_ini'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pemeriksaan Hari Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Pemeriksaan Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['pemeriksaan_hari_ini'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Konsultasi Hari Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Konsultasi Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['konsultasi_hari_ini'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pemeriksaan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Pemeriksaan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total_pemeriksaan'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-medical fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Hari Ini -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-day me-2"></i>Jadwal Hari Ini
                    </h6>
                </div>
                <div class="card-body">
                    @if($jadwalHariIni->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Kunjungan</th>
                                    <th>Nama Pasien</th>
                                    <th>Jenis Pasien</th>
                                    <th>Jenis Kunjungan</th>
                                    <th>Keluhan</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jadwalHariIni as $kunjungan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $kunjungan->kode_kunjungan }}</span>
                                    </td>
                                    <td>{{ $kunjungan->nama_pasien }}</td>
                                    <td>
                                        @if($kunjungan->pasien_type == 'balita')
                                            <span class="badge bg-danger">Balita</span>
                                        @elseif($kunjungan->pasien_type == 'remaja')
                                            <span class="badge bg-secondary">Remaja</span>
                                        @else
                                            <span class="badge bg-dark">Lansia</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($kunjungan->jenis_kunjungan == 'rutin')
                                            <span class="badge bg-primary">Rutin</span>
                                        @elseif($kunjungan->jenis_kunjungan == 'imunisasi')
                                            <span class="badge bg-success">Imunisasi</span>
                                        @elseif($kunjungan->jenis_kunjungan == 'konsultasi')
                                            <span class="badge bg-info">Konsultasi</span>
                                        @else
                                            <span class="badge bg-warning">Pengobatan</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($kunjungan->keluhan, 30) }}</td>
                                    <td>{{ $kunjungan->created_at->format('H:i') }}</td>
                                    <td>
                                        @if(!$kunjungan->pemeriksaan)
                                        <a href="{{ route('bidan.pemeriksaan.create', $kunjungan->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fas fa-stethoscope me-1"></i>Periksa
                                        </a>
                                        @else
                                        <a href="{{ route('bidan.pemeriksaan.show', $kunjungan->pemeriksaan->id) }}" 
                                           class="btn btn-sm btn-success">
                                            <i class="fas fa-eye me-1"></i>Lihat
                                        </a>
                                        @endif
                                        
                                        @if($kunjungan->jenis_kunjungan == 'konsultasi')
                                        <a href="{{ route('bidan.konsultasi.create', $kunjungan->id) }}" 
                                           class="btn btn-sm btn-info mt-1">
                                            <i class="fas fa-comments me-1"></i>Konsultasi
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle me-2"></i>
                        Tidak ada jadwal kunjungan untuk hari ini.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-4">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-stethoscope fa-3x text-primary mb-3"></i>
                    <h5>Pemeriksaan</h5>
                    <p>Lakukan pemeriksaan pasien</p>
                    <a href="{{ route('bidan.pemeriksaan.index') }}" class="btn btn-primary">
                        Mulai Pemeriksaan
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-left-success shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-comments fa-3x text-success mb-3"></i>
                    <h5>Konsultasi</h5>
                    <p>Beri konsultasi kesehatan</p>
                    <a href="{{ route('bidan.konsultasi.index') }}" class="btn btn-success">
                        Lihat Konsultasi
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-left-info shadow h-100">
                <div class="card-body text-center">
                    <i class="fas fa-chart-bar fa-3x text-info mb-3"></i>
                    <h5>Analisis</h5>
                    <p>Analisis data kesehatan</p>
                    <a href="#" class="btn btn-info">
                        Lihat Analisis
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection