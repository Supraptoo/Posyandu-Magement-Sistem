@extends('layouts.app')

@section('title', 'Data Remaja')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(155, 89, 182, 0.3);
    }

    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 4px solid;
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .stats-card.purple {
        border-left-color: #9b59b6;
    }

    .stats-card.success {
        border-left-color: #27ae60;
    }

    .stats-card.warning {
        border-left-color: #f39c12;
    }

    .stats-card.info {
        border-left-color: #3498db;
    }

    .stats-card .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin: 0;
    }

    .stats-card .stat-label {
        color: #7f8c8d;
        font-size: 0.875rem;
        margin: 0;
    }

    .table-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .table-card .card-header {
        background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
        color: white;
        border: none;
        padding: 1.25rem 1.5rem;
    }

    .table thead th {
        background-color: var(--light-gray);
        color: var(--dark-bg);
        font-weight: 600;
        border: none;
        padding: 1rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        padding: 1rem;
        vertical-align: middle;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(155, 89, 182, 0.05);
    }

    .badge-custom {
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.75rem;
    }

    .btn-action {
        padding: 0.4rem 0.7rem;
        border-radius: 6px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .patient-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #9b59b6, #8e44ad);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        margin-right: 0.75rem;
    }

    .patient-info {
        display: flex;
        align-items: center;
    }

    .patient-name {
        font-weight: 600;
        color: var(--dark-bg);
        margin: 0;
    }

    .patient-nik {
        font-size: 0.75rem;
        color: #7f8c8d;
        margin: 0;
    }

    .age-badge {
        background: linear-gradient(135deg, #9b59b6, #8e44ad);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2><i class="fas fa-child me-2"></i>Data Remaja</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Pasien</li>
                        <li class="breadcrumb-item active">Remaja</li>
                    </ol>
                </nav>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="{{ route('admin.pasien.remaja.create') }}" class="btn btn-light">
                    <i class="fas fa-user-plus me-2"></i>Tambah Remaja
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Mini Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card purple">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Total Remaja</p>
                        <h3 class="stat-value" style="color: #9b59b6;">{{ $stats['total_remaja'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-child fa-2x" style="opacity: 0.3; color: #9b59b6;"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card success">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Laki-laki</p>
                        <h3 class="stat-value text-success">{{ $stats['laki_laki'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-mars fa-2x text-success" style="opacity: 0.3;"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card warning">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Perempuan</p>
                        <h3 class="stat-value text-warning">{{ $stats['perempuan'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-venus fa-2x text-warning" style="opacity: 0.3;"></i>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="stats-card info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="stat-label">Kunjungan Bulan Ini</p>
                        <h3 class="stat-value text-info">{{ $stats['kunjungan'] ?? 0 }}</h3>
                    </div>
                    <i class="fas fa-calendar-check fa-2x text-info" style="opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-8">
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Cari nama, NIK, atau kode remaja..."
                           value="{{ $search }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.pasien.remaja.index') }}" class="btn btn-secondary w-100">
                        <i class="fas fa-redo me-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h5 class="mb-0"><i class="fas fa-table me-2"></i>Daftar Remaja</h5>
                <div>
                    <button class="btn btn-sm btn-light" onclick="alert('Export Excel akan segera tersedia')">
                        <i class="fas fa-file-excel me-1"></i>Excel
                    </button>
                    <button class="btn btn-sm btn-light" onclick="alert('Export PDF akan segera tersedia')">
                        <i class="fas fa-file-pdf me-1"></i>PDF
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="25%">Remaja</th>
                            <th width="10%">Usia</th>
                            <th width="12%">Jenis Kelamin</th>
                            <th width="20%">Alamat</th>
                            <th width="15%">Nama Orang Tua</th>
                            <th width="13%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($remajas as $remaja)
                        @php
                            $usia = $remaja->usia ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="patient-info">
                                    <div class="patient-avatar">R{{ $remaja->id }}</div>
                                    <div>
                                        <p class="patient-name">{{ $remaja->nama_lengkap }}</p>
                                        <p class="patient-nik">NIK: {{ $remaja->nik }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="age-badge">{{ $usia }} Tahun</span>
                            </td>
                            <td>
                                @if($remaja->jenis_kelamin == 'L')
                                    <span class="badge badge-custom bg-primary">
                                        <i class="fas fa-mars me-1"></i>Laki-laki
                                    </span>
                                @else
                                    <span class="badge badge-custom" style="background-color: #e91e63;">
                                        <i class="fas fa-venus me-1"></i>Perempuan
                                    </span>
                                @endif
                            </td>
                            <td>{{ Str::limit($remaja->alamat, 30) }}</td>
                            <td>{{ $remaja->nama_ortu ?? '-' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.pasien.remaja.show', $remaja->id) }}" 
                                       class="btn btn-info btn-action" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pasien.remaja.edit', $remaja->id) }}" 
                                       class="btn btn-warning btn-action" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete('{{ $remaja->id }}')" 
                                            class="btn btn-danger btn-action" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $remaja->id }}" 
                                      action="{{ route('admin.pasien.remaja.destroy', $remaja->id) }}" 
                                      method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-user-slash fa-2x mb-2"></i>
                                    <p>Tidak ada data remaja</p>
                                    <a href="{{ route('admin.pasien.remaja.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i>Tambah Remaja
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($remajas->hasPages())
            <div class="card-footer">
                <div class="d-flex justify-content-center">
                    {{ $remajas->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data remaja akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#95a5a6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endpush