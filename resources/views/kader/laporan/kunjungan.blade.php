@extends('layouts.kader')

@section('title', 'Laporan Kunjungan')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-calendar-check me-2"></i>Laporan Kunjungan
        </h1>
        <div>
            <button class="btn btn-success" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Cetak
            </button>
        </div>
    </div>

    <!-- Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('kader.laporan.kunjungan') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="{{ $start_date }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="{{ $end_date }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid gap-2" style="margin-top: 32px">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik Card -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Kunjungan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Kunjungan Balita
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['balita'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-baby fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Kunjungan Remaja
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['remaja'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-child fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                Kunjungan Lansia
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['lansia'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-file-alt me-2"></i>Detail Kunjungan
                <small class="float-end">
                    Periode: {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                </small>
            </h6>
        </div>
        <div class="card-body">
            @if($kunjungans->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-info">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Pasien</th>
                            <th>Jenis Pasien</th>
                            <th>Jenis Kunjungan</th>
                            <th>Keluhan</th>
                            <th>Petugas</th>
                            <th>Kode Kunjungan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kunjungans as $index => $kunjungan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="text-center">{{ $kunjungan->tanggal_kunjungan->format('d/m/Y') }}</td>
                            <td>
                                <strong>{{ $kunjungan->pasien->nama_lengkap ?? '-' }}</strong><br>
                                <small class="text-muted">NIK: {{ $kunjungan->pasien->nik ?? '-' }}</small>
                            </td>
                            <td class="text-center">
                                @if($kunjungan->pasien_type == 'App\Models\Balita')
                                    <span class="badge bg-danger">Balita</span>
                                @elseif($kunjungan->pasien_type == 'App\Models\Remaja')
                                    <span class="badge bg-secondary">Remaja</span>
                                @else
                                    <span class="badge bg-dark">Lansia</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-{{ $kunjungan->jenis_kunjungan == 'imunisasi' ? 'success' : ($kunjungan->jenis_kunjungan == 'pemeriksaan' ? 'primary' : 'warning') }}">
                                    {{ ucfirst($kunjungan->jenis_kunjungan) }}
                                </span>
                            </td>
                            <td>{{ $kunjungan->keluhan ?? '-' }}</td>
                            <td>{{ $kunjungan->petugas->profile->full_name ?? 'Sistem' }}</td>
                            <td class="text-center">
                                <small class="text-muted">{{ $kunjungan->kode_kunjungan ?? '-' }}</small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-info">
                        <tr>
                            <td colspan="8" class="text-center">
                                <strong>Total Kunjungan: {{ $stats['total'] }}</strong> | 
                                Pemeriksaan: {{ $stats['pemeriksaan'] ?? 0 }} | 
                                Imunisasi: {{ $stats['imunisasi'] ?? 0 }} | 
                                Konsultasi: {{ $stats['konsultasi'] ?? 0 }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <!-- Export Options -->
            <div class="mt-4 text-center">
                <form action="{{ route('kader.laporan.generate', 'kunjungan') }}" method="GET" class="d-inline">
                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                    <input type="hidden" name="format" value="pdf">
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </button>
                </form>
                
                <form action="{{ route('kader.laporan.generate', 'kunjungan') }}" method="GET" class="d-inline ms-2">
                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                    <input type="hidden" name="format" value="excel">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-file-excel me-2"></i>Export Excel
                    </button>
                </form>
            </div>
            @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>
                Tidak ada data kunjungan dalam periode yang dipilih.
            </div>
            @endif
        </div>
    </div>
    
    <!-- Summary Chart -->
    @if($kunjungans->count() > 0)
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-pie me-2"></i>Distribusi Jenis Pasien
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="pasienChart" height="150"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar me-2"></i>Distribusi Jenis Kunjungan
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="kunjunganChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
@if($kunjungans->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pasien distribution chart
    const pasienCtx = document.getElementById('pasienChart').getContext('2d');
    new Chart(pasienCtx, {
        type: 'pie',
        data: {
            labels: ['Balita', 'Remaja', 'Lansia'],
            datasets: [{
                data: [
                    {{ $stats['balita'] }},
                    {{ $stats['remaja'] }},
                    {{ $stats['lansia'] }}
                ],
                backgroundColor: ['#e74a3b', '#6c757d', '#5a5c69'],
                borderColor: ['#e74a3b', '#6c757d', '#5a5c69'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });

    // Kunjungan distribution chart
    const kunjunganCtx = document.getElementById('kunjunganChart').getContext('2d');
    new Chart(kunjunganCtx, {
        type: 'bar',
        data: {
            labels: ['Pemeriksaan', 'Imunisasi', 'Konsultasi'],
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: [
                    {{ $stats['pemeriksaan'] ?? 0 }},
                    {{ $stats['imunisasi'] ?? 0 }},
                    {{ $stats['konsultasi'] ?? 0 }}
                ],
                backgroundColor: ['#4e73df', '#1cc88a', '#f6c23e'],
                borderColor: ['#4e73df', '#1cc88a', '#f6c23e'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endif
@endpush

<style>
@media print {
    .card-header {
        background-color: #36b9cc !important;
        -webkit-print-color-adjust: exact;
    }
    .table-info {
        background-color: #d1ecf1 !important;
        -webkit-print-color-adjust: exact;
    }
    .btn, .card.shadow {
        display: none;
    }
}
</style>
@endsection