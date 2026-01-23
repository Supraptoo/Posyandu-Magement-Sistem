@extends('layouts.kader')

@section('title', 'Riwayat Import')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-history me-2"></i>Riwayat Import
        </h1>
        <div>
            <a href="{{ route('kader.import.index') }}" class="btn btn-primary">
                <i class="fas fa-upload me-2"></i>Upload Baru
            </a>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-list me-2"></i>Daftar Riwayat Import
            </h6>
        </div>
        <div class="card-body">
            @if($imports->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-info">
                        <tr>
                            <th>No</th>
                            <th>Nama File</th>
                            <th>Jenis Data</th>
                            <th>Tanggal Upload</th>
                            <th>Status</th>
                            <th>Total Data</th>
                            <th>Berhasil</th>
                            <th>Gagal</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($imports as $index => $import)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $import->nama_file }}</td>
                            <td>
                                @if($import->jenis_data == 'balita')
                                    <span class="badge bg-danger">Balita</span>
                                @elseif($import->jenis_data == 'remaja')
                                    <span class="badge bg-secondary">Remaja</span>
                                @else
                                    <span class="badge bg-dark">Lansia</span>
                                @endif
                            </td>
                            <td>{{ $import->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                @if($import->status == 'completed')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($import->status == 'processing')
                                    <span class="badge bg-warning">Diproses</span>
                                @elseif($import->status == 'pending')
                                    <span class="badge bg-info">Menunggu</span>
                                @else
                                    <span class="badge bg-danger">Gagal</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $import->total_data ?? '-' }}</td>
                            <td class="text-center">{{ $import->data_berhasil ?? '-' }}</td>
                            <td class="text-center">{{ $import->data_gagal ?? '-' }}</td>
                            <td>{{ $import->catatan ?? '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('kader.import.show', $import->id) }}" 
                                   class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $imports->links() }}
            </div>
            @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>
                Belum ada riwayat import data.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection