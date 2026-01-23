@extends('layouts.kader')

@section('title', 'Dashboard Kader')
@section('page-name', 'Overview')

@section('content')
<style>
    /* ========== WELCOME SECTION ========== */
    .welcome-section {
        margin-bottom: 32px;
        animation: fadeIn 0.6s ease;
    }

    .welcome-title {
        font-size: 32px;
        font-weight: 800;
        color: var(--dark-color);
        margin: 0 0 8px;
        letter-spacing: -0.5px;
    }

    .welcome-subtitle {
        font-size: 15px;
        color: var(--gray-color);
        margin: 0;
    }

    .welcome-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: var(--primary-light);
        color: var(--primary-dark);
        padding: 8px 16px;
        border-radius: var(--radius-md);
        font-size: 13px;
        font-weight: 600;
        margin-top: 12px;
    }

    /* ========== STATS GRID ========== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .stat-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 24px;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(7, 59, 76, 0.06);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        opacity: 0.06;
        transition: all 0.6s ease;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }

    .stat-card:hover::before {
        transform: scale(1.2);
    }

    .stat-card.danger::before { background: var(--danger-color); }
    .stat-card.secondary::before { background: var(--gray-color); }
    .stat-card.dark::before { background: var(--dark-color); }
    .stat-card.success::before { background: var(--primary-color); }
    .stat-card.info::before { background: var(--secondary-color); }
    .stat-card.warning::before { background: var(--accent-color); }
    .stat-card.primary::before { background: var(--secondary-color); }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 16px;
        position: relative;
        z-index: 1;
    }

    .stat-card.danger .stat-icon {
        background: linear-gradient(135deg, rgba(239, 71, 111, 0.15) 0%, rgba(239, 71, 111, 0.05) 100%);
        color: var(--danger-color);
    }

    .stat-card.secondary .stat-icon {
        background: linear-gradient(135deg, rgba(139, 157, 169, 0.15) 0%, rgba(139, 157, 169, 0.05) 100%);
        color: var(--gray-color);
    }

    .stat-card.dark .stat-icon {
        background: linear-gradient(135deg, rgba(7, 59, 76, 0.15) 0%, rgba(7, 59, 76, 0.05) 100%);
        color: var(--dark-color);
    }

    .stat-card.success .stat-icon {
        background: linear-gradient(135deg, rgba(6, 214, 160, 0.15) 0%, rgba(6, 214, 160, 0.05) 100%);
        color: var(--primary-color);
    }

    .stat-card.info .stat-icon {
        background: linear-gradient(135deg, rgba(17, 138, 178, 0.15) 0%, rgba(17, 138, 178, 0.05) 100%);
        color: var(--secondary-color);
    }

    .stat-card.warning .stat-icon {
        background: linear-gradient(135deg, rgba(255, 209, 102, 0.15) 0%, rgba(255, 209, 102, 0.05) 100%);
        color: var(--accent-color);
    }

    .stat-card.primary .stat-icon {
        background: linear-gradient(135deg, rgba(17, 138, 178, 0.15) 0%, rgba(17, 138, 178, 0.05) 100%);
        color: var(--secondary-color);
    }

    .stat-content {
        position: relative;
        z-index: 1;
    }

    .stat-label {
        font-size: 12px;
        color: var(--gray-color);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: var(--dark-color);
        line-height: 1;
    }

    /* ========== CHART SECTION ========== */
    .chart-section {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        margin-bottom: 32px;
    }

    .chart-container {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 28px;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(7, 59, 76, 0.06);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .chart-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* ========== ACTIVITY SECTION ========== */
    .activity-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }

    .activity-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 24px;
        box-shadow: var(--shadow-md);
        border: 1px solid rgba(7, 59, 76, 0.06);
    }

    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid rgba(7, 59, 76, 0.08);
    }

    .activity-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark-color);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        max-height: 400px;
        overflow-y: auto;
    }

    .activity-list::-webkit-scrollbar {
        width: 4px;
    }

    .activity-list::-webkit-scrollbar-thumb {
        background: var(--gray-color);
        border-radius: 10px;
    }

    .activity-item {
        padding: 16px;
        background: var(--gray-light);
        border-radius: var(--radius-sm);
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
        text-decoration: none;
        color: var(--dark-color);
        display: block;
    }

    .activity-item:hover {
        background: var(--primary-light);
        border-left-color: var(--primary-color);
        transform: translateX(4px);
    }

    .activity-item-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 8px;
    }

    .activity-item-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 4px;
    }

    .activity-item-meta {
        font-size: 12px;
        color: var(--gray-color);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .activity-badge {
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
    }

    .badge-danger { background: rgba(239, 71, 111, 0.1); color: var(--danger-color); }
    .badge-secondary { background: rgba(139, 157, 169, 0.1); color: var(--gray-color); }
    .badge-dark { background: rgba(7, 59, 76, 0.1); color: var(--dark-color); }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: var(--gray-color);
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 16px;
        opacity: 0.3;
    }

    .empty-state p {
        font-size: 14px;
        margin: 0;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid rgba(7, 59, 76, 0.08);
    }

    .btn-custom {
        flex: 1;
        padding: 10px 16px;
        border-radius: var(--radius-sm);
        font-size: 13px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-custom:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-primary-custom {
        background: var(--primary-color);
        color: var(--white);
    }

    .btn-outline-custom {
        background: transparent;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 1200px) {
        .chart-section {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .activity-section {
            grid-template-columns: 1fr;
        }

        .welcome-title {
            font-size: 24px;
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<!-- Welcome Section -->
<div class="welcome-section">
    <h1 class="welcome-title">Selamat Datang, Kader! 👋</h1>
    <p class="welcome-subtitle">Berikut adalah ringkasan aktivitas Posyandu hari ini</p>
    <div class="welcome-badge">
        <i class="fas fa-calendar"></i>
        <span>{{ now()->translatedFormat('l, d F Y') }}</span>
    </div>
</div>

<!-- Statistics Grid -->
<div class="stats-grid">
    <div class="stat-card danger">
        <div class="stat-icon">
            <i class="fas fa-baby"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Balita</div>
            <div class="stat-value">{{ $stats['total_balita'] ?? 0 }}</div>
        </div>
    </div>

    <div class="stat-card secondary">
        <div class="stat-icon">
            <i class="fas fa-child"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Remaja</div>
            <div class="stat-value">{{ $stats['total_remaja'] ?? 0 }}</div>
        </div>
    </div>

    <div class="stat-card dark">
        <div class="stat-icon">
            <i class="fas fa-user-friends"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Total Lansia</div>
            <div class="stat-value">{{ $stats['total_lansia'] ?? 0 }}</div>
        </div>
    </div>

    <div class="stat-card success">
        <div class="stat-icon">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Kunjungan Hari Ini</div>
            <div class="stat-value">{{ $stats['kunjungan_hari_ini'] ?? 0 }}</div>
        </div>
    </div>

    <div class="stat-card info">
        <div class="stat-icon">
            <i class="fas fa-syringe"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Imunisasi Hari Ini</div>
            <div class="stat-value">{{ $stats['imunisasi_hari_ini'] ?? 0 }}</div>
        </div>
    </div>

    <div class="stat-card warning">
        <div class="stat-icon">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Kunjungan Saya</div>
            <div class="stat-value">{{ $stats['kunjungan_saya_hari_ini'] ?? 0 }}</div>
        </div>
    </div>

    <div class="stat-card primary">
        <div class="stat-icon">
            <i class="fas fa-calendar"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Jadwal Hari Ini</div>
            <div class="stat-value">{{ $stats['jadwal_hari_ini'] ?? 0 }}</div>
        </div>
    </div>

    <div class="stat-card success">
        <div class="stat-icon">
            <i class="fas fa-user-plus"></i>
        </div>
        <div class="stat-content">
            <div class="stat-label">Pendaftaran Bulan Ini</div>
            <div class="stat-value">{{ $pendaftaran_bulan_ini['total'] ?? 0 }}</div>
        </div>
    </div>
</div>


<!-- Activity Section -->
<div class="activity-section">
    <!-- Recent Balita -->
    <div class="activity-card">
        <div class="activity-header">
            <h3 class="activity-title">
                <i class="fas fa-baby" style="color: var(--danger-color);"></i>
                Balita Terbaru
            </h3>
        </div>
        <div class="activity-list">
            @forelse($balita_baru as $balita)
            <a href="{{ route('kader.data.balita.show', $balita->id) }}" class="activity-item">
                <div class="activity-item-header">
                    <div>
                        <div class="activity-item-title">{{ $balita->nama_lengkap }}</div>
                        <div class="activity-item-meta">
                            <i class="fas fa-barcode"></i>
                            {{ $balita->kode_balita }}
                        </div>
                    </div>
                    <span class="activity-badge badge-danger">
                        {{ $balita->tanggal_lahir->diffInMonths(now()) }} bulan
                    </span>
                </div>
            </a>
            @empty
            <div class="empty-state">
                <i class="fas fa-baby"></i>
                <p>Belum ada data balita terbaru</p>
            </div>
            @endforelse
        </div>
        <div class="action-buttons">
            <a href="{{ route('kader.data.balita.create') }}" class="btn-custom btn-primary-custom">
                <i class="fas fa-plus-circle"></i>
                Tambah Balita
            </a>
            <a href="{{ route('kader.data.balita.index') }}" class="btn-custom btn-outline-custom">
                <i class="fas fa-list"></i>
                Lihat Semua
            </a>
        </div>
    </div>

    <!-- Recent Visits -->
    <div class="activity-card">
        <div class="activity-header">
            <h3 class="activity-title">
                <i class="fas fa-calendar-check" style="color: var(--primary-color);"></i>
                Kunjungan Terbaru
            </h3>
        </div>
        <div class="activity-list">
            @forelse($kunjungan_baru as $kunjungan)
            <div class="activity-item">
                <div class="activity-item-header">
                    <div>
                        <div class="activity-item-title">{{ $kunjungan->pasien->nama_lengkap ?? 'Unknown' }}</div>
                        <div class="activity-item-meta">
                            <i class="fas fa-clock"></i>
                            {{ $kunjungan->jenis_kunjungan }} • {{ $kunjungan->created_at->format('H:i') }}
                        </div>
                    </div>
                    <span class="activity-badge 
                        @if($kunjungan->pasien_type == 'App\Models\Balita') badge-danger
                        @elseif($kunjungan->pasien_type == 'App\Models\Remaja') badge-secondary
                        @else badge-dark @endif">
                        @if($kunjungan->pasien_type == 'App\Models\Balita') Balita
                        @elseif($kunjungan->pasien_type == 'App\Models\Remaja') Remaja
                        @else Lansia @endif
                    </span>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <p>Belum ada kunjungan hari ini</p>
            </div>
            @endforelse
        </div>
        <div class="action-buttons">
            <a href="{{ route('kader.pemeriksaan.create') }}" class="btn-custom btn-primary-custom">
                <i class="fas fa-plus-circle"></i>
                Tambah Kunjungan
            </a>
        </div>
    </div>

    <!-- Upcoming Schedule -->
    <div class="activity-card">
        <div class="activity-header">
            <h3 class="activity-title">
                <i class="fas fa-calendar-alt" style="color: var(--secondary-color);"></i>
                Jadwal Mendatang
            </h3>
        </div>
        <div class="activity-list">
            @forelse($jadwal_mendatang as $jadwal)
            <div class="activity-item">
                <div class="activity-item-header">
                    <div>
                        <div class="activity-item-title">{{ $jadwal->judul }}</div>
                        <div class="activity-item-meta">
                            <i class="fas fa-calendar"></i>
                            {{ $jadwal->tanggal }} • {{ $jadwal->waktu_mulai }}
                        </div>
                    </div>
                    <span class="activity-badge" style="background: var(--secondary-color); color: var(--white);">
                        {{ $jadwal->target_peserta }}
                    </span>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-calendar"></i>
                <p>Tidak ada jadwal mendatang</p>
            </div>
            @endforelse
        </div>
        <div class="action-buttons">
            <a href="{{ route('kader.jadwal.create') }}" class="btn-custom btn-primary-custom">
                <i class="fas fa-plus-circle"></i>
                Tambah Jadwal
            </a>
            <a href="{{ route('kader.jadwal.index') }}" class="btn-custom btn-outline-custom">
                <i class="fas fa-list"></i>
                Lihat Semua
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart Kunjungan 7 Hari
    const kunjunganCtx = document.getElementById('kunjunganChart');
    if (kunjunganCtx) {
        const kunjunganLabels = {!! json_encode($kunjungan_7_hari->pluck('tanggal')) !!};
        const kunjunganData = {!! json_encode($kunjungan_7_hari->pluck('total')) !!};
        
        new Chart(kunjunganCtx, {
            type: 'line',
            data: {
                labels: kunjunganLabels,
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: kunjunganData,
                    borderColor: '#06D6A0',
                    backgroundColor: 'rgba(6, 214, 160, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#06D6A0',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(7, 59, 76, 0.9)',
                        padding: 12,
                        borderRadius: 8
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                        grid: { color: 'rgba(7, 59, 76, 0.06)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }
    
    // Chart Pendaftaran Bulan Ini
    const pendaftaranCtx = document.getElementById('pendaftaranChart');
    if (pendaftaranCtx) {
        new Chart(pendaftaranCtx, {
            type: 'doughnut',
            data: {
                labels: ['Balita', 'Remaja', 'Lansia'],
                datasets: [{
                    data: [
                        {{ $pendaftaran_bulan_ini['balita'] ?? 0 }},
                        {{ $pendaftaran_bulan_ini['remaja'] ?? 0 }},
                        {{ $pendaftaran_bulan_ini['lansia'] ?? 0 }}
                    ],
                    backgroundColor: ['#EF476F', '#8B9DA9', '#073B4C'],
                    hoverBackgroundColor: ['#d63e5e', '#7a8b97', '#05293a'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
});
</script>
@endpush