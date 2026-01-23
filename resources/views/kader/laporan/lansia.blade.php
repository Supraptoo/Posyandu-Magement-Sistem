@extends('layouts.kader')

@section('title', 'Laporan Lansia')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-friends me-2"></i>Laporan Lansia
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
            <form action="{{ route('kader.laporan.lansia') }}" method="GET">
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

    <!-- Data Table -->
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-file-alt me-2"></i>Laporan Data Lansia
                <small class="float-end">
                    Periode: {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                </small>
            </h6>
        </div>
        <div class="card-body">
            @if($lansias->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th rowspan="2" class="align-middle">No</th>
                            <th rowspan="2" class="align-middle">Nama Lansia</th>
                            <th rowspan="2" class="align-middle">NIK</th>
                            <th rowspan="2" class="align-middle">TTL</th>
                            <th rowspan="2" class="align-middle">Usia</th>
                            <th rowspan="2" class="align-middle">Penyakit Bawaan</th>
                            <th colspan="5" class="text-center">Pemeriksaan Terakhir</th>
                            <th rowspan="2" class="align-middle">Tanggal Kunjungan</th>
                        </tr>
                        <tr>
                            <th>BB (kg)</th>
                            <th>TB (cm)</th>
                            <th>TD (mmHg)</th>
                            <th>GD (mg/dL)</th>
                            <th>Kolesterol</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lansias as $index => $lansia)
                        @php
                            $usia_tahun = $lansia->tanggal_lahir->diffInYears(now());
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $lansia->nama_lengkap }}</strong><br>
                                <small class="text-muted">{{ $lansia->kode_lansia }}</small>
                            </td>
                            <td>{{ $lansia->nik }}</td>
                            <td>
                                {{ $lansia->tempat_lahir }},<br>
                                {{ $lansia->tanggal_lahir->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
                                {{ $usia_tahun }} tahun
                            </td>
                            <td>
                                @if($lansia->penyakit_bawaan)
                                    <span class="badge bg-warning">{{ $lansia->penyakit_bawaan }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $lansia->kunjungans->first()->pemeriksaan->berat_badan ?? '-' }}</td>
                            <td class="text-center">{{ $lansia->kunjungans->first()->pemeriksaan->tinggi_badan ?? '-' }}</td>
                            <td class="text-center">{{ $lansia->kunjungans->first()->pemeriksaan->tekanan_darah ?? '-' }}</td>
                            <td class="text-center">{{ $lansia->kunjungans->first()->pemeriksaan->gula_darah ?? '-' }}</td>
                            <td class="text-center">{{ $lansia->kunjungans->first()->pemeriksaan->kolesterol ?? '-' }}</td>
                            <td>
                                @if($lansia->kunjungans->count() > 0)
                                {{ $lansia->kunjungans->first()->tanggal_kunjungan->format('d/m/Y') }}
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-dark">
                        <tr>
                            <td colspan="12" class="text-center">
                                <strong>Total Data: {{ $lansias->count() }} lansia</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <!-- Export Options -->
            <div class="mt-4 text-center">
                <form action="{{ route('kader.laporan.generate', 'lansia') }}" method="GET" class="d-inline">
                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                    <input type="hidden" name="format" value="pdf">
                    <button type="submit" class="btn btn-dark">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </button>
                </form>
                
                <form action="{{ route('kader.laporan.generate', 'lansia') }}" method="GET" class="d-inline ms-2">
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
                Tidak ada data lansia dalam periode yang dipilih.
            </div>
            @endif
        </div>
    </div>
    
    <!-- Summary -->
    @if($lansias->count() > 0)
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar me-2"></i>Statistik
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h2 class="font-weight-bold text-dark">{{ $lansias->count() }}</h2>
                        <p class="text-muted">Total Lansia</p>
                    </div>
                    <div class="mt-3">
                        <p><i class="fas fa-male text-primary me-2"></i> Laki-laki: 
                            {{ $lansias->where('jenis_kelamin', 'L')->count() }}
                        </p>
                        <p><i class="fas fa-female text-danger me-2"></i> Perempuan: 
                            {{ $lansias->where('jenis_kelamin', 'P')->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-line me-2"></i>Distribusi Usia
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="ageChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
@if($lansias->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Age distribution chart
    const ageGroups = {
        '60-64 tahun': 0,
        '65-69 tahun': 0,
        '70-74 tahun': 0,
        '75-79 tahun': 0,
        '80+ tahun': 0
    };
    
    @foreach($lansias as $lansia)
        @php
            $usia_tahun = $lansia->tanggal_lahir->diffInYears(now());
        @endphp
        
        @if($usia_tahun >= 60 && $usia_tahun <= 64)
            ageGroups['60-64 tahun']++;
        @elseif($usia_tahun >= 65 && $usia_tahun <= 69)
            ageGroups['65-69 tahun']++;
        @elseif($usia_tahun >= 70 && $usia_tahun <= 74)
            ageGroups['70-74 tahun']++;
        @elseif($usia_tahun >= 75 && $usia_tahun <= 79)
            ageGroups['75-79 tahun']++;
        @elseif($usia_tahun >= 80)
            ageGroups['80+ tahun']++;
        @endif
    @endforeach
    
    const ctx = document.getElementById('ageChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(ageGroups),
            datasets: [{
                label: 'Jumlah Lansia',
                data: Object.values(ageGroups),
                backgroundColor: [
                    '#5a5c69', '#4e73df', '#36b9cc', '#1cc88a', '#f6c23e'
                ],
                borderColor: [
                    '#5a5c69', '#4e73df', '#36b9cc', '#1cc88a', '#f6c23e'
                ],
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
        background-color: #5a5c69 !important;
        -webkit-print-color-adjust: exact;
    }
    .table-dark {
        background-color: #e3e6f0 !important;
        -webkit-print-color-adjust: exact;
    }
    .btn, .card.shadow {
        display: none;
    }
}
</style>
@endsection