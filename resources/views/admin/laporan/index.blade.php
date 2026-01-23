@extends('layouts.app')

@section('title', 'Laporan')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, var(--dark-bg) 0%, var(--dark-secondary) 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .report-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border-left: 4px solid;
        position: relative;
        overflow: hidden;
    }

    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .report-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        opacity: 0.1;
        font-family: 'Font Awesome 6 Free';
        font-size: 4rem;
        font-weight: 900;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .report-card.kunjungan {
        border-left-color: #3498db;
    }

    .report-card.kunjungan::before {
        content: '\f0c0';
        color: #3498db;
    }

    .report-card.imunisasi {
        border-left-color: #27ae60;
    }

    .report-card.imunisasi::before {
        content: '\f48e';
        color: #27ae60;
    }

    .report-card.balita {
        border-left-color: #f39c12;
    }

    .report-card.balita::before {
        content: '\f1ae';
        color: #f39c12;
    }

    .report-card.remaja {
        border-left-color: #9b59b6;
    }

    .report-card.remaja::before {
        content: '\f007';
        color: #9b59b6;
    }

    .report-card.lansia {
        border-left-color: #e74c3c;
    }

    .report-card.lansia::before {
        content: '\f0c0';
        color: #e74c3c;
    }

    .report-card.custom {
        border-left-color: var(--accent-cyan);
    }

    .report-card.custom::before {
        content: '\f0ce';
        color: var(--accent-cyan);
    }

    .report-card .report-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        margin-bottom: 1rem;
    }

    .report-card h5 {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark-bg);
    }

    .report-card p {
        color: #7f8c8d;
        margin-bottom: 1rem;
        font-size: 0.875rem;
    }

    .report-card .btn {
        width: 100%;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .report-card .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .filter-section {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .filter-section .form-control,
    .filter-section .form-select {
        border-radius: 8px;
        border: 2px solid var(--light-gray);
    }

    .filter-section .form-control:focus,
    .filter-section .form-select:focus {
        border-color: var(--accent-cyan);
        box-shadow: 0 0 0 0.2rem rgba(0, 173, 181, 0.25);
    }

    .quick-stats {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
    }

    .stat-item .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark-bg);
    }

    .stat-item .stat-label {
        color: #7f8c8d;
        font-size: 0.875rem;
    }

    .stat-item .stat-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        opacity: 0.3;
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2><i class="fas fa-chart-bar me-2"></i>Laporan Posyandu</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Laporan</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Quick Statistics -->
    <div class="quick-stats">
        <h5 class="mb-4"><i class="fas fa-chart-line me-2"></i>Statistik Cepat</h5>
        <div class="row">
            <div class="col-md-3 mb-3">
                <div class="stat-item">
                    <i class="fas fa-users stat-icon text-primary"></i>
                    <div class="stat-value text-primary">{{ $stats['total_kunjungan'] ?? 0 }}</div>
                    <div class="stat-label">Total Kunjungan</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-item">
                    <i class="fas fa-syringe stat-icon text-success"></i>
                    <div class="stat-value text-success">{{ $stats['total_imunisasi'] ?? 0 }}</div>
                    <div class="stat-label">Imunisasi</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-item">
                    <i class="fas fa-baby stat-icon text-warning"></i>
                    <div class="stat-value text-warning">{{ $stats['total_balita'] ?? 0 }}</div>
                    <div class="stat-label">Balita Terdaftar</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-item">
                    <i class="fas fa-calendar-day stat-icon text-info"></i>
                    <div class="stat-value text-info">{{ $stats['kunjungan_hari_ini'] ?? 0 }}</div>
                    <div class="stat-label">Kunjungan Hari Ini</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <h5 class="mb-3"><i class="fas fa-filter me-2"></i>Filter Laporan</h5>
        <form method="GET">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Tanggal Mulai</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date', date('Y-m-01')) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Tanggal Akhir</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date', date('Y-m-d')) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Jenis Laporan</label>
                    <select name="type" class="form-select">
                        <option value="">Semua Laporan</option>
                        <option value="kunjungan">Kunjungan</option>
                        <option value="imunisasi">Imunisasi</option>
                        <option value="balita">Balita</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i>Tampilkan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Report Cards -->
    <div class="row">
        <!-- Laporan Kunjungan -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="report-card kunjungan">
                <div class="report-icon bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-users"></i>
                </div>
                <h5>Laporan Kunjungan</h5>
                <p>Laporan data kunjungan pasien ke posyandu berdasarkan periode tertentu</p>
                <a href="{{ route('admin.laporan.kunjungan') }}" class="btn btn-primary">
                    <i class="fas fa-file-alt me-2"></i>Lihat Laporan
                </a>
            </div>
        </div>

        <!-- Laporan Imunisasi -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="report-card imunisasi">
                <div class="report-icon bg-success bg-opacity-10 text-success">
                    <i class="fas fa-syringe"></i>
                </div>
                <h5>Laporan Imunisasi</h5>
                <p>Laporan data imunisasi yang telah diberikan kepada balita dan anak</p>
                <a href="{{ route('admin.laporan.imunisasi') }}" class="btn btn-success">
                    <i class="fas fa-file-alt me-2"></i>Lihat Laporan
                </a>
            </div>
        </div>

        <!-- Laporan Balita -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="report-card balita">
                <div class="report-icon bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-baby"></i>
                </div>
                <h5>Laporan Balita</h5>
                <p>Laporan pertumbuhan dan perkembangan balita yang terdaftar</p>
                <a href="{{ route('admin.laporan.balita') }}" class="btn btn-warning">
                    <i class="fas fa-file-alt me-2"></i>Lihat Laporan
                </a>
            </div>
        </div>

        <!-- Laporan Remaja -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="report-card remaja">
                <div class="report-icon bg-purple bg-opacity-10" style="color: #9b59b6;">
                    <i class="fas fa-child"></i>
                </div>
                <h5>Laporan Remaja</h5>
                <p>Laporan kesehatan dan pemeriksaan remaja di posyandu</p>
                <button class="btn btn-secondary" onclick="alert('Fitur akan segera tersedia')">
                    <i class="fas fa-clock me-2"></i>Segera Hadir
                </button>
            </div>
        </div>

        <!-- Laporan Lansia -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="report-card lansia">
                <div class="report-icon bg-danger bg-opacity-10 text-danger">
                    <i class="fas fa-user-friends"></i>
                </div>
                <h5>Laporan Lansia</h5>
                <p>Laporan kesehatan dan pemeriksaan lansia di posyandu</p>
                <button class="btn btn-secondary" onclick="alert('Fitur akan segera tersedia')">
                    <i class="fas fa-clock me-2"></i>Segera Hadir
                </button>
            </div>
        </div>

        <!-- Laporan Custom -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="report-card custom">
                <div class="report-icon bg-info bg-opacity-10" style="color: var(--accent-cyan);">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h5>Laporan Custom</h5>
                <p>Buat laporan sesuai kebutuhan dengan filter kustom</p>
                <button class="btn btn-info" style="background-color: var(--accent-cyan); border: none;" onclick="alert('Fitur akan segera tersedia')">
                    <i class="fas fa-plus-circle me-2"></i>Buat Laporan
                </button>
            </div>
        </div>
    </div>

    <!-- Export Options -->
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-3"><i class="fas fa-download me-2"></i>Export Laporan</h5>
            <p class="text-muted mb-3">Export semua laporan dalam berbagai format</p>
            <div class="d-flex gap-2 flex-wrap">
                <button class="btn btn-success" onclick="alert('Export Excel akan segera tersedia')">
                    <i class="fas fa-file-excel me-2"></i>Export ke Excel
                </button>
                <button class="btn btn-danger" onclick="alert('Export PDF akan segera tersedia')">
                    <i class="fas fa-file-pdf me-2"></i>Export ke PDF
                </button>
                <button class="btn btn-primary" onclick="alert('Export CSV akan segera tersedia')">
                    <i class="fas fa-file-csv me-2"></i>Export ke CSV
                </button>
                <button class="btn btn-secondary" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Print Laporan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection