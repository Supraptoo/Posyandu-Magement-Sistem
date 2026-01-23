@extends('layouts.kader')

@section('title', 'Detail Import')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-info-circle me-2"></i>Detail Import Data
        </h1>
        <div>
            <a href="{{ route('kader.import.history') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Detail Card -->
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-file-excel me-2"></i>Informasi Import
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Nama File:</strong><br>
                            {{ $import->nama_file }}
                        </div>
                        <div class="col-md-6">
                            <strong>Jenis Data:</strong><br>
                            @if($import->jenis_data == 'balita')
                                <span class="badge bg-danger">Balita</span>
                            @elseif($import->jenis_data == 'remaja')
                                <span class="badge bg-secondary">Remaja</span>
                            @else
                                <span class="badge bg-dark">Lansia</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Tanggal Upload:</strong><br>
                            {{ $import->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong><br>
                            @if($import->status == 'completed')
                                <span class="badge bg-success">Selesai</span>
                            @elseif($import->status == 'processing')
                                <span class="badge bg-warning">Diproses</span>
                            @elseif($import->status == 'pending')
                                <span class="badge bg-info">Menunggu</span>
                            @else
                                <span class="badge bg-danger">Gagal</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Total Data:</strong><br>
                            {{ $import->total_data ?? '0' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Data Berhasil:</strong><br>
                            {{ $import->data_berhasil ?? '0' }}
                        </div>
                        <div class="col-md-4">
                            <strong>Data Gagal:</strong><br>
                            {{ $import->data_gagal ?? '0' }}
                        </div>
                    </div>
                    
                    @if($import->catatan)
                    <div class="alert alert-{{ $import->status == 'completed' ? 'success' : ($import->status == 'failed' ? 'danger' : 'info') }}">
                        <i class="fas fa-sticky-note me-2"></i>
                        <strong>Catatan:</strong> {{ $import->catatan }}
                    </div>
                    @endif
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('kader.import.index') }}" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i>Upload Data Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection