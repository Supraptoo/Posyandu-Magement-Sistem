@extends('layouts.user')

@section('title', 'Dashboard - SIM Posyandu')
@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card welcome-card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-2">Selamat Datang, {{ $profile->full_name ?? $user->username }}!</h2>
                            <p class="text-muted mb-0">
                                @if($anakBalita->count() > 0)
                                    Anda memiliki {{ $anakBalita->count() }} anak balita terdaftar di Posyandu.
                                @elseif($dataRemaja)
                                    Anda terdaftar sebagai remaja di Posyandu.
                                @elseif($dataLansia)
                                    Anda terdaftar sebagai lansia di Posyandu.
                                @else
                                    Selamat menggunakan layanan Posyandu kami.
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="d-inline-block bg-primary bg-opacity-10 p-3 rounded-circle">
                                <i class="fas fa-heartbeat fa-3x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cepat -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card border-0 h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle">
                                <i class="fas fa-baby fa-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-1">{{ $statistik['total_anak'] }}</h3>
                            <p class="text-muted mb-0">Anak Balita</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card border-0 h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle">
                                <i class="fas fa-syringe fa-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-1">{{ $statistik['total_imunisasi'] }}</h3>
                            <p class="text-muted mb-0">Imunisasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card border-0 h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-info bg-opacity-10 text-info p-3 rounded-circle">
                                <i class="fas fa-file-medical fa-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-1">{{ $statistik['total_kunjungan'] }}</h3>
                            <p class="text-muted mb-0">Kunjungan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stat-card border-0 h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle">
                                <i class="fas fa-bell fa-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-1">{{ $statistik['notifikasi'] }}</h3>
                            <p class="text-muted mb-0">Notifikasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Data Anak Balita -->
        @if($anakBalita->count() > 0)
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">Data Anak Balita</h5>
                        <a href="{{ route('user.anak.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($anakBalita->take(3) as $anak)
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2">
                                    <i class="fas fa-baby fa-lg"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $anak['nama_lengkap'] }}</h6>
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            <span class="badge bg-primary">
                                                {{ $anak['usia_formatted'] }}
                                            </span>
                                            <span class="badge {{ $anak['jenis_kelamin'] == 'L' ? 'bg-info' : 'bg-pink' }}">
                                                {{ $anak['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('user.anak.show', $anak['id']) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        Detail
                                    </a>
                                </div>
                                
                                @if($anak['pemeriksaan_terakhir'])
                                <div class="mt-2">
                                    <small class="text-muted">Pemeriksaan Terakhir:</small>
                                    <div class="d-flex flex-wrap gap-3 mt-1">
                                        @if($anak['pemeriksaan_terakhir']->berat_badan)
                                        <span>
                                            <small class="text-muted d-block">Berat</small>
                                            <strong>{{ $anak['pemeriksaan_terakhir']->berat_badan }} kg</strong>
                                        </span>
                                        @endif
                                        @if($anak['pemeriksaan_terakhir']->tinggi_badan)
                                        <span>
                                            <small class="text-muted d-block">Tinggi</small>
                                            <strong>{{ $anak['pemeriksaan_terakhir']->tinggi_badan }} cm</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    @if($anakBalita->count() > 3)
                    <div class="text-center mt-3">
                        <a href="{{ route('user.anak.index') }}" class="text-decoration-none">
                            <small>Lihat {{ $anakBalita->count() - 3 }} anak lainnya →</small>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        <!-- Jadwal Posyandu Terdekat -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">Jadwal Posyandu Terdekat</h5>
                        {{-- <a href="{{ route('user.jadwal') }}" class="btn btn-sm btn-outline-primary">
                            Kalender
                        </a> --}}
                    </div>
                </div>
                <div class="card-body">
                    @if($jadwalTerdekat->count() > 0)
                        @foreach($jadwalTerdekat as $jadwal)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex">
                                <div class="flex-shrink-0 text-center me-3">
                                    <div class="bg-primary text-white rounded-3 p-2">
                                        <div class="fw-bold">{{ date('d', strtotime($jadwal->tanggal)) }}</div>
                                        <small>{{ date('M', strtotime($jadwal->tanggal)) }}</small>
                                    </div>
                                    <small class="text-muted d-block mt-1">{{ $jadwal->hari }}</small>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">{{ $jadwal->judul }}</h6>
                                    <p class="text-muted small mb-2">{{ $jadwal->deskripsi }}</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <small class="text-muted">
                                            <i class="far fa-clock me-1"></i>
                                            {{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }}
                                        </small>
                                        @if($jadwal->lokasi)
                                        <small class="text-muted">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            {{ $jadwal->lokasi }}
                                        </small>
                                        @endif
                                        <span class="badge bg-info">
                                            {{ ucfirst(str_replace('_', ' ', $jadwal->target_peserta)) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="far fa-calendar fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">Tidak ada jadwal posyandu dalam waktu dekat</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Perkembangan -->
    @if(!empty($grafikPerkembangan) && count($grafikPerkembangan['labels']) > 1)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0 fw-bold">Grafik Perkembangan {{ $anakBalita->first()['nama_lengkap'] ?? 'Anak' }}</h5>
                </div>
                <div class="card-body">
                    <canvas id="perkembanganChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Notifikasi Terbaru -->
    @if($notifikasiTerbaru->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold">Notifikasi Terbaru</h5>
                        <a href="{{ route('user.notifikasi') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @foreach($notifikasiTerbaru as $notif)
                    <div class="alert {{ $notif->tipe == 'jadwal' ? 'alert-info' : 'alert-warning' }} alert-dismissible fade show">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0 me-3">
                                @switch($notif->tipe)
                                    @case('jadwal')
                                        <i class="fas fa-calendar fa-lg"></i>
                                        @break
                                    @case('imunisasi')
                                        <i class="fas fa-syringe fa-lg"></i>
                                        @break
                                    @case('pemeriksaan')
                                        <i class="fas fa-file-medical fa-lg"></i>
                                        @break
                                    @default
                                        <i class="fas fa-info-circle fa-lg"></i>
                                @endswitch
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="alert-heading fw-bold">{{ $notif->judul }}</h6>
                                <p class="mb-2">{{ Str::limit($notif->pesan, 150) }}</p>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans() }}
                                </small>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@if(!empty($grafikPerkembangan))
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('perkembanganChart').getContext('2d');
        
        const data = {
            labels: @json($grafikPerkembangan['labels']),
            datasets: [
                {
                    label: 'Berat Badan (kg)',
                    data: @json($grafikPerkembangan['berat_badan']),
                    borderColor: '#06D6A0',
                    backgroundColor: 'rgba(6, 214, 160, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Tinggi Badan (cm)',
                    data: @json($grafikPerkembangan['tinggi_badan']),
                    borderColor: '#118AB2',
                    backgroundColor: 'rgba(17, 138, 178, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }
            ]
        };
        
        new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Nilai'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal Pemeriksaan'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endif
@endsection