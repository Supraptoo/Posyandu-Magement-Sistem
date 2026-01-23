@extends('layouts.kader')

@section('title', 'Laporan Remaja')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-child me-2"></i>Laporan Remaja
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
            <form action="{{ route('kader.laporan.remaja') }}" method="GET">
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
        <div class="card-header bg-secondary text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-file-alt me-2"></i>Laporan Data Remaja
                <small class="float-end">
                    Periode: {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                </small>
            </h6>
        </div>
        <div class="card-body">
            @if($remajas->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-secondary">
                        <tr>
                            <th rowspan="2" class="align-middle">No</th>
                            <th rowspan="2" class="align-middle">Nama Remaja</th>
                            <th rowspan="2" class="align-middle">NIK</th>
                            <th rowspan="2" class="align-middle">TTL</th>
                            <th rowspan="2" class="align-middle">Usia</th>
                            <th rowspan="2" class="align-middle">Sekolah</th>
                            <th colspan="4" class="text-center">Pemeriksaan Terakhir</th>
                            <th rowspan="2" class="align-middle">Tanggal Kunjungan</th>
                        </tr>
                        <tr>
                            <th>BB (kg)</th>
                            <th>TB (cm)</th>
                            <th>TD (mmHg)</th>
                            <th>Hb (g/dL)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($remajas as $index => $remaja)
                        @php
                            $usia_tahun = $remaja->tanggal_lahir->diffInYears(now());
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $remaja->nama_lengkap }}</strong><br>
                                <small class="text-muted">{{ $remaja->kode_remaja }}</small>
                            </td>
                            <td>{{ $remaja->nik }}</td>
                            <td>
                                {{ $remaja->tempat_lahir }},<br>
                                {{ $remaja->tanggal_lahir->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
                                {{ $usia_tahun }} tahun
                            </td>
                            <td>
                                {{ $remaja->sekolah }}<br>
                                <small class="text-muted">Kelas: {{ $remaja->kelas }}</small>
                            </td>
                            <td class="text-center">{{ $remaja->kunjungans->first()->pemeriksaan->berat_badan ?? '-' }}</td>
                            <td class="text-center">{{ $remaja->kunjungans->first()->pemeriksaan->tinggi_badan ?? '-' }}</td>
                            <td class="text-center">{{ $remaja->kunjungans->first()->pemeriksaan->tekanan_darah ?? '-' }}</td>
                            <td class="text-center">{{ $remaja->kunjungans->first()->pemeriksaan->hemoglobin ?? '-' }}</td>
                            <td>
                                @if($remaja->kunjungans->count() > 0)
                                {{ $remaja->kunjungans->first()->tanggal_kunjungan->format('d/m/Y') }}
                                @else
                                -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-secondary">
                        <tr>
                            <td colspan="11" class="text-center">
                                <strong>Total Data: {{ $remajas->count() }} remaja</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <!-- Export Options -->
            <div class="mt-4 text-center">
                <form action="{{ route('kader.laporan.generate', 'remaja') }}" method="GET" class="d-inline">
                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                    <input type="hidden" name="format" value="pdf">
                    <button type="submit" class="btn btn-secondary">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </button>
                </form>
                
                <form action="{{ route('kader.laporan.generate', 'remaja') }}" method="GET" class="d-inline ms-2">
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
                Tidak ada data remaja dalam periode yang dipilih.
            </div>
            @endif
        </div>
    </div>
    
    <!-- Summary -->
    @if($remajas->count() > 0)
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
                        <h2 class="font-weight-bold text-secondary">{{ $remajas->count() }}</h2>
                        <p class="text-muted">Total Remaja</p>
                    </div>
                    <div class="mt-3">
                        <p><i class="fas fa-male text-primary me-2"></i> Laki-laki: 
                            {{ $remajas->where('jenis_kelamin', 'L')->count() }}
                        </p>
                        <p><i class="fas fa-female text-danger me-2"></i> Perempuan: 
                            {{ $remajas->where('jenis_kelamin', 'P')->count() }}
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
@if($remajas->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Age distribution chart
    const ageGroups = {
        '10-12 tahun': 0,
        '13-15 tahun': 0,
        '16-18 tahun': 0,
        '19+ tahun': 0
    };
    
    @foreach($remajas as $remaja)
        @php
            $usia_tahun = $remaja->tanggal_lahir->diffInYears(now());
        @endphp
        
        @if($usia_tahun >= 10 && $usia_tahun <= 12)
            ageGroups['10-12 tahun']++;
        @elseif($usia_tahun >= 13 && $usia_tahun <= 15)
            ageGroups['13-15 tahun']++;
        @elseif($usia_tahun >= 16 && $usia_tahun <= 18)
            ageGroups['16-18 tahun']++;
        @elseif($usia_tahun >= 19)
            ageGroups['19+ tahun']++;
        @endif
    @endforeach
    
    const ctx = document.getElementById('ageChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(ageGroups),
            datasets: [{
                label: 'Jumlah Remaja',
                data: Object.values(ageGroups),
                backgroundColor: [
                    '#6c757d', '#4e73df', '#36b9cc', '#1cc88a'
                ],
                borderColor: [
                    '#6c757d', '#4e73df', '#36b9cc', '#1cc88a'
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
        background-color: #6c757d !important;
        -webkit-print-color-adjust: exact;
    }
    .table-secondary {
        background-color: #e9ecef !important;
        -webkit-print-color-adjust: exact;
    }
    .btn, .card.shadow {
        display: none;
    }
}
</style>
@endsection