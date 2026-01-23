@extends('layouts.kader')

@section('title', 'Laporan Balita')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-baby me-2"></i>Laporan Balita
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
            <form action="{{ route('kader.laporan.balita') }}" method="GET">
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
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Balita
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $balitas->count() }}
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
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Laki-laki
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $balitas->where('jenis_kelamin', 'L')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-male fa-2x text-gray-300"></i>
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
                                Perempuan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $balitas->where('jenis_kelamin', 'P')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-female fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Kunjungan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $balitas->sum(function($balita) { return $balita->kunjungans->count(); }) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-file-alt me-2"></i>Laporan Data Balita
                <small class="float-end">
                    Periode: {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                </small>
            </h6>
        </div>
        <div class="card-body">
            @if($balitas->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-danger">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Balita</th>
                            <th>NIK</th>
                            <th>TTL</th>
                            <th>Usia</th>
                            <th>JK</th>
                            <th>Nama Ibu</th>
                            <th>BB/TB Terakhir</th>
                            <th>Tanggal Kunjungan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($balitas as $index => $balita)
                        @php
                            $usia_bulan = $balita->tanggal_lahir->diffInMonths(now());
                            $usia_tahun = floor($usia_bulan / 12);
                            $sisa_bulan = $usia_bulan % 12;
                            
                            $kunjungan_terakhir = $balita->kunjungans->first();
                            $pemeriksaan_terakhir = $kunjungan_terakhir ? $kunjungan_terakhir->pemeriksaan : null;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $balita->kode_balita }}</td>
                            <td>
                                <strong>{{ $balita->nama_lengkap }}</strong><br>
                                <small class="text-muted">{{ $balita->nik }}</small>
                            </td>
                            <td>{{ $balita->nik }}</td>
                            <td>
                                {{ $balita->tempat_lahir }},<br>
                                {{ $balita->tanggal_lahir->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
                                @if($usia_tahun > 0)
                                    {{ $usia_tahun }} thn {{ $sisa_bulan }} bln
                                @else
                                    {{ $sisa_bulan }} bln
                                @endif
                            </td>
                            <td class="text-center">{{ $balita->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>
                            <td>{{ $balita->nama_ibu }}</td>
                            <td class="text-center">
                                @if($pemeriksaan_terakhir && $pemeriksaan_terakhir->berat_badan && $pemeriksaan_terakhir->tinggi_badan)
                                    {{ $pemeriksaan_terakhir->berat_badan }} kg / {{ $pemeriksaan_terakhir->tinggi_badan }} cm
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                @if($kunjungan_terakhir)
                                    {{ $kunjungan_terakhir->tanggal_kunjungan->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Export Options -->
            <div class="mt-4 text-center">
                <form action="{{ route('kader.laporan.generate', 'balita') }}" method="GET" class="d-inline">
                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                    <input type="hidden" name="format" value="pdf">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </button>
                </form>
                
                <form action="{{ route('kader.laporan.generate', 'balita') }}" method="GET" class="d-inline ms-2">
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
                Tidak ada data balita dalam periode yang dipilih.
            </div>
            @endif
        </div>
    </div>
    
    <!-- Summary Charts -->
    @if($balitas->count() > 0)
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-pie me-2"></i>Distribusi Usia Balita
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="ageChart" height="150"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar me-2"></i>Distribusi Jenis Kelamin
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="genderChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
@if($balitas->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Age distribution chart
    const ageGroups = {
        '0-6 bulan': 0,
        '7-12 bulan': 0,
        '1-2 tahun': 0,
        '2-3 tahun': 0,
        '3-4 tahun': 0,
        '4-5 tahun': 0
    };
    
    @foreach($balitas as $balita)
        @php
            $usia_bulan = $balita->tanggal_lahir->diffInMonths(now());
            $usia_tahun = floor($usia_bulan / 12);
        @endphp
        
        @if($usia_bulan <= 6)
            ageGroups['0-6 bulan']++;
        @elseif($usia_bulan <= 12)
            ageGroups['7-12 bulan']++;
        @elseif($usia_tahun <= 2)
            ageGroups['1-2 tahun']++;
        @elseif($usia_tahun <= 3)
            ageGroups['2-3 tahun']++;
        @elseif($usia_tahun <= 4)
            ageGroups['3-4 tahun']++;
        @elseif($usia_tahun <= 5)
            ageGroups['4-5 tahun']++;
        @endif
    @endforeach
    
    // Age chart
    const ageCtx = document.getElementById('ageChart').getContext('2d');
    new Chart(ageCtx, {
        type: 'pie',
        data: {
            labels: Object.keys(ageGroups),
            datasets: [{
                data: Object.values(ageGroups),
                backgroundColor: ['#e74a3b', '#f6c23e', '#1cc88a', '#36b9cc', '#4e73df', '#6c757d'],
                borderColor: ['#e74a3b', '#f6c23e', '#1cc88a', '#36b9cc', '#4e73df', '#6c757d'],
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
    
    // Gender chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'bar',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                label: 'Jumlah',
                data: [
                    {{ $balitas->where('jenis_kelamin', 'L')->count() }},
                    {{ $balitas->where('jenis_kelamin', 'P')->count() }}
                ],
                backgroundColor: ['#4e73df', '#e74a3b'],
                borderColor: ['#4e73df', '#e74a3b'],
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
        background-color: #e74a3b !important;
        -webkit-print-color-adjust: exact;
    }
    .table-danger {
        background-color: #f8d7da !important;
        -webkit-print-color-adjust: exact;
    }
    .btn, .card.shadow {
        display: none;
    }
}
</style>
@endsection