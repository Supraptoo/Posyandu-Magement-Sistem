@extends('layouts.kader')

@section('title', 'Laporan Imunisasi')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-syringe me-2"></i>Laporan Imunisasi
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
            <form action="{{ route('kader.laporan.imunisasi') }}" method="GET">
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
        <div class="card-header bg-success text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-file-alt me-2"></i>Laporan Imunisasi
                <small class="float-end">
                    Periode: {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                </small>
            </h6>
        </div>
        <div class="card-body">
            @if($imunisasis->count() > 0)
                @foreach($imunisasis as $jenis => $data_imunisasi)
                <h5 class="mb-3 text-success">{{ $jenis }} ({{ $data_imunisasi->count() }} data)</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Imunisasi</th>
                                <th>Vaksin</th>
                                <th>Dosis</th>
                                <th>Batch Number</th>
                                <th>Expiry Date</th>
                                <th>Penyelenggara</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data_imunisasi as $index => $imunisasi)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <strong>{{ $imunisasi->kunjungan->pasien->nama_lengkap ?? '-' }}</strong><br>
                                    <small class="text-muted">
                                        @if($imunisasi->kunjungan->pasien_type == 'App\Models\Balita')
                                            Balita
                                        @else
                                            Bayi
                                        @endif
                                    </small>
                                </td>
                                <td class="text-center">{{ $imunisasi->tanggal_imunisasi->format('d/m/Y') }}</td>
                                <td>{{ $imunisasi->vaksin }}</td>
                                <td class="text-center">{{ $imunisasi->dosis }}</td>
                                <td>{{ $imunisasi->batch_number }}</td>
                                <td class="text-center">{{ $imunisasi->expiry_date->format('d/m/Y') }}</td>
                                <td>{{ $imunisasi->penyelenggara }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
            
            <!-- Export Options -->
            <div class="mt-4 text-center">
                <form action="{{ route('kader.laporan.generate', 'imunisasi') }}" method="GET" class="d-inline">
                    <input type="hidden" name="start_date" value="{{ $start_date }}">
                    <input type="hidden" name="end_date" value="{{ $end_date }}">
                    <input type="hidden" name="format" value="pdf">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </button>
                </form>
                
                <form action="{{ route('kader.laporan.generate', 'imunisasi') }}" method="GET" class="d-inline ms-2">
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
                Tidak ada data imunisasi dalam periode yang dipilih.
            </div>
            @endif
        </div>
    </div>
    
    <!-- Summary -->
    @if($imunisasis->count() > 0)
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
                        <h2 class="font-weight-bold text-success">
                            @php
                                $total_imunisasi = 0;
                                foreach($imunisasis as $jenis => $data) {
                                    $total_imunisasi += $data->count();
                                }
                            @endphp
                            {{ $total_imunisasi }}
                        </h2>
                        <p class="text-muted">Total Imunisasi</p>
                    </div>
                    <div class="mt-3">
                        @foreach($imunisasis as $jenis => $data_imunisasi)
                        <p><i class="fas fa-syringe text-success me-2"></i> {{ $jenis }}: 
                            {{ $data_imunisasi->count() }}
                        </p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-pie me-2"></i>Distribusi Jenis Imunisasi
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="imunisasiChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
@if($imunisasis->count() > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Imunisasi distribution chart
    const jenisLabels = [];
    const jenisData = [];
    const jenisColors = ['#1cc88a', '#36b9cc', '#4e73df', '#f6c23e', '#e74a3b', '#fd7e14'];
    
    @foreach($imunisasis as $jenis => $data_imunisasi)
        jenisLabels.push('{{ $jenis }}');
        jenisData.push({{ $data_imunisasi->count() }});
    @endforeach
    
    const ctx = document.getElementById('imunisasiChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: jenisLabels,
            datasets: [{
                data: jenisData,
                backgroundColor: jenisColors,
                borderColor: jenisColors.map(color => color.replace('0.8', '1')),
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
});
</script>
@endif
@endpush

<style>
@media print {
    .card-header {
        background-color: #1cc88a !important;
        -webkit-print-color-adjust: exact;
    }
    .table-success {
        background-color: #d4edda !important;
        -webkit-print-color-adjust: exact;
    }
    .btn, .card.shadow {
        display: none;
    }
}
</style>
@endsection