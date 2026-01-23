@extends('layouts.kader')

@section('title', 'Laporan')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-file-alt me-2"></i>Generate Laporan
        </h1>
    </div>

    <!-- Report Cards -->
    <div class="row">
        <!-- Balita Report -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Laporan Balita
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                Laporan data dan pemeriksaan balita
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-baby fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('kader.laporan.balita') }}" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-eye me-2"></i>Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Remaja Report -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Laporan Remaja
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                Laporan data dan pemeriksaan remaja
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-child fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('kader.laporan.remaja') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-eye me-2"></i>Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lansia Report -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                Laporan Lansia
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                Laporan data dan pemeriksaan lansia
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('kader.laporan.lansia') }}" class="btn btn-outline-dark btn-sm">
                            <i class="fas fa-eye me-2"></i>Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Imunisasi Report -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Laporan Imunisasi
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                Laporan kegiatan imunisasi
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-syringe fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('kader.laporan.imunisasi') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-eye me-2"></i>Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kunjungan Report -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Laporan Kunjungan
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                Statistik kunjungan harian/bulanan
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('kader.laporan.kunjungan') }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-eye me-2"></i>Lihat Laporan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Generate -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-download me-2"></i>Quick Generate Laporan
            </h6>
        </div>
        <div class="card-body">
            <p class="text-muted">Generate laporan cepat dengan periode waktu tertentu:</p>
            
            <form id="quickReportForm" method="POST" action="">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="report_type" class="form-label">Jenis Laporan</label>
                            <select class="form-select" id="report_type" name="type" required>
                                <option value="">Pilih Jenis</option>
                                <option value="balita">Laporan Balita</option>
                                <option value="remaja">Laporan Remaja</option>
                                <option value="lansia">Laporan Lansia</option>
                                <option value="imunisasi">Laporan Imunisasi</option>
                                <option value="kunjungan">Laporan Kunjungan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ date('Y-m-01') }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="format" class="form-label">Format</label>
                            <select class="form-select" id="format" name="format">
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-download me-2"></i>Generate Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('quickReportForm');
    const reportType = document.getElementById('report_type');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const type = reportType.value;
        if (!type) {
            alert('Silakan pilih jenis laporan terlebih dahulu');
            return;
        }
        
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const format = document.getElementById('format').value;
        
        // Set form action
        form.action = `{{ route('kader.laporan.generate', '') }}/${type}`;
        
        // Submit form
        form.submit();
    });
});
</script>
@endpush
@endsection