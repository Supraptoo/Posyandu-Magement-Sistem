@extends('layouts.kader')

@section('title', 'Detail Jadwal')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-calendar me-2"></i>Detail Jadwal
        </h1>
        <div>
            <a href="{{ route('kader.jadwal.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('kader.jadwal.edit', $jadwal->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            @if($jadwal->status == 'aktif')
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#broadcastModal">
                <i class="fas fa-bullhorn me-2"></i>Broadcast
            </button>
            @endif
        </div>
    </div>

    <!-- Jadwal Detail -->
    <div class="row">
        <div class="col-lg-8">
            <!-- Main Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-info-circle me-2"></i>Informasi Jadwal
                    </h6>
                </div>
                <div class="card-body">
                    <h3 class="card-title">{{ $jadwal->judul }}</h3>
                    <p class="card-text">{{ $jadwal->deskripsi }}</p>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong><i class="fas fa-calendar-alt me-2 text-muted"></i>Tanggal:</strong><br>
                                <span class="fs-5">{{ $jadwal->tanggal ? \Carbon\Carbon::parse($jadwal->tanggal)->format('d F Y') : '-' }}</span>
                            </div>
                            
                            <div class="mb-3">
                                <strong><i class="fas fa-clock me-2 text-muted"></i>Waktu:</strong><br>
                                <span class="fs-5">{{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }}</span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong><i class="fas fa-map-marker-alt me-2 text-muted"></i>Lokasi:</strong><br>
                                <span class="fs-5">{{ $jadwal->lokasi }}</span>
                            </div>
                            
                            <div class="mb-3">
                                <strong><i class="fas fa-tag me-2 text-muted"></i>Status:</strong><br>
                                @if($jadwal->status == 'aktif')
                                <span class="badge bg-success fs-6">Aktif</span>
                                @elseif($jadwal->status == 'selesai')
                                <span class="badge bg-secondary fs-6">Selesai</span>
                                @else
                                <span class="badge bg-danger fs-6">Dibatalkan</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong><i class="fas fa-filter me-2 text-muted"></i>Kategori:</strong><br>
                                <span class="badge bg-{{ $jadwal->kategori == 'imunisasi' ? 'success' : ($jadwal->kategori == 'pemeriksaan' ? 'primary' : 'warning') }} fs-6">
                                    {{ ucfirst($jadwal->kategori) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong><i class="fas fa-users me-2 text-muted"></i>Target Peserta:</strong><br>
                                @if($jadwal->target_peserta == 'semua')
                                <span class="badge bg-info fs-6">Semua</span>
                                @elseif($jadwal->target_peserta == 'balita')
                                <span class="badge bg-danger fs-6">Balita</span>
                                @elseif($jadwal->target_peserta == 'remaja')
                                <span class="badge bg-secondary fs-6">Remaja</span>
                                @elseif($jadwal->target_peserta == 'lansia')
                                <span class="badge bg-dark fs-6">Lansia</span>
                                @else
                                <span class="badge bg-warning fs-6">Ibu Hamil</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Side Cards -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-user-plus me-2"></i>Dibuat Oleh
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="avatar-circle bg-info text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-2" 
                         style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fas fa-user"></i>
                    </div>
                    <h5 class="font-weight-bold">{{ $jadwal->creator->profile->full_name ?? 'Sistem' }}</h5>
                    <p class="text-muted">Kader Posyandu</p>
                    
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>Dibuat: {{ optional($jadwal->created_at)->format('d/m/Y H:i') ?? '-' }}
                        </small><br>
                        <small class="text-muted">
                            <i class="fas fa-sync me-1"></i>Diperbarui: {{ optional($jadwal->updated_at)->format('d/m/Y H:i') ?? '-' }}
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($jadwal->status == 'aktif')
                        <a href="{{ route('kader.jadwal.edit', $jadwal->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Jadwal
                        </a>
                        
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#broadcastModal">
                            <i class="fas fa-bullhorn me-2"></i>Broadcast Notifikasi
                        </button>
                        
                        <!-- Modal Broadcast -->
                        <div class="modal fade" id="broadcastModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Broadcast Jadwal</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Kirim notifikasi jadwal ini ke semua user?</p>
                                        <div class="alert alert-info">
                                            <strong>{{ $jadwal->judul }}</strong><br>
                                            {{ $jadwal->deskripsi }}<br>
                                            <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d/m/Y') }}<br>
                                            <strong>Waktu:</strong> {{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }}<br>
                                            <strong>Lokasi:</strong> {{ $jadwal->lokasi }}
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('kader.jadwal.broadcast', $jadwal->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-bullhorn me-2"></i>Ya, Broadcast
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        
                        <a href="{{ route('kader.jadwal.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list me-2"></i>Lihat Semua Jadwal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Countdown (if upcoming) -->
    @if($jadwal->status == 'aktif' && \Carbon\Carbon::parse($jadwal->tanggal)->isFuture())
    <div class="card shadow mt-4">
        <div class="card-header bg-success text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-hourglass-half me-2"></i>Menuju Jadwal
            </h6>
        </div>
        <div class="card-body">
            <div class="row text-center">
                @php
                    $now = now();
                    $jadwalDate = \Carbon\Carbon::parse($jadwal->tanggal);
                    $diff = $now->diff($jadwalDate);
                @endphp
                
                <div class="col-md-3">
                    <div class="countdown-box">
                        <h2 class="font-weight-bold text-success">{{ $diff->days }}</h2>
                        <p class="text-muted">Hari</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="countdown-box">
                        <h2 class="font-weight-bold text-success">{{ $diff->h }}</h2>
                        <p class="text-muted">Jam</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="countdown-box">
                        <h2 class="font-weight-bold text-success">{{ $diff->i }}</h2>
                        <p class="text-muted">Menit</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="countdown-box">
                        <h2 class="font-weight-bold text-success">{{ $diff->s }}</h2>
                        <p class="text-muted">Detik</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.avatar-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.countdown-box {
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 10px;
    margin: 5px;
}

.countdown-box h2 {
    margin-bottom: 5px;
}

.countdown-box p {
    margin-bottom: 0;
}

.card-header {
    border-bottom: none;
}
</style>

@push('scripts')
@if($jadwal->status == 'aktif' && \Carbon\Carbon::parse($jadwal->tanggal)->isFuture())
<script>
// Countdown timer
function updateCountdown() {
    const jadwalDate = new Date("{{ $jadwal->tanggal }}").getTime();
    const now = new Date().getTime();
    const distance = jadwalDate - now;
    
    if (distance < 0) {
        clearInterval(countdownInterval);
        return;
    }
    
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Update elements if they exist
    const daysEl = document.querySelector('.countdown-box:nth-child(1) h2');
    const hoursEl = document.querySelector('.countdown-box:nth-child(2) h2');
    const minutesEl = document.querySelector('.countdown-box:nth-child(3) h2');
    const secondsEl = document.querySelector('.countdown-box:nth-child(4) h2');
    
    if (daysEl) daysEl.textContent = days;
    if (hoursEl) hoursEl.textContent = hours;
    if (minutesEl) minutesEl.textContent = minutes;
    if (secondsEl) secondsEl.textContent = seconds;
}

// Update every second
const countdownInterval = setInterval(updateCountdown, 1000);
updateCountdown(); // Initial call
</script>
@endif
@endpush
@endsection