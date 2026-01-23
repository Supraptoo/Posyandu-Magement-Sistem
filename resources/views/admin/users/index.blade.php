@extends('layouts.app')

@section('title', 'Manajemen User Warga')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    }

    .card-custom {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
        overflow: hidden;
        background: white;
    }

    .card-header-custom {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        border: none;
        padding: 1.25rem 1.5rem;
    }

    .card-header-custom h4 {
        margin: 0;
        color: white;
        font-weight: 600;
    }

    .card-header-custom .btn {
        background: white;
        border: none;
        border-radius: 10px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        color: #3498db;
        transition: all 0.3s ease;
    }

    .card-header-custom .btn:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Search and Filter */
    .search-filter-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .form-control-custom, .form-select-custom {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control-custom:focus, .form-select-custom:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }

    /* Table */
    .table-container {
        overflow-x: auto;
    }

    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    .table-custom thead th {
        background-color: #f8f9fa;
        border: none;
        padding: 1rem 1.25rem;
        font-weight: 600;
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-custom tbody tr {
        transition: all 0.3s ease;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.05);
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .table-custom tbody td {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f1f1f1;
        vertical-align: middle;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3498db, #2980b9);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        margin-right: 0.75rem;
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .user-name {
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
        font-size: 0.95rem;
    }

    .user-nik {
        font-size: 0.75rem;
        color: #7f8c8d;
        margin: 0;
    }

    /* Status Badge */
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-active {
        background-color: rgba(46, 204, 113, 0.2);
        color: #27ae60;
    }

    .status-inactive {
        background-color: rgba(231, 76, 60, 0.2);
        color: #e74c3c;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-view {
        background-color: rgba(52, 152, 219, 0.1);
        color: #3498db;
    }

    .btn-view:hover {
        background-color: #3498db;
        color: white;
        transform: translateY(-2px);
    }

    .btn-edit {
        background-color: rgba(155, 89, 182, 0.1);
        color: #9b59b6;
    }

    .btn-edit:hover {
        background-color: #9b59b6;
        color: white;
        transform: translateY(-2px);
    }

    .btn-delete {
        background-color: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
    }

    .btn-delete:hover {
        background-color: #e74c3c;
        color: white;
        transform: translateY(-2px);
    }

    .btn-reset {
        background-color: rgba(243, 156, 18, 0.1);
        color: #f39c12;
    }

    .btn-reset:hover {
        background-color: #f39c12;
        color: white;
        transform: translateY(-2px);
    }

    /* No Data */
    .no-data {
        text-align: center;
        padding: 3rem;
    }

    .no-data i {
        font-size: 4rem;
        color: rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }

    .no-data h5 {
        color: rgba(0, 0, 0, 0.4);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    /* Pagination */
    .pagination-custom .page-link {
        border: none;
        color: #2c3e50;
        margin: 0 0.25rem;
        border-radius: 10px;
        padding: 0.5rem 0.75rem;
        transition: all 0.3s ease;
        background: white;
    }

    .pagination-custom .page-link:hover {
        background-color: rgba(52, 152, 219, 0.1);
        color: #3498db;
    }

    .pagination-custom .page-item.active .page-link {
        background-color: #3498db;
        color: white;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-action {
            width: 100%;
            margin-bottom: 0.25rem;
        }
        
        .user-info {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .user-avatar {
            margin-right: 0;
            margin-bottom: 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <!-- Page Header -->
    @if(session('generated_password'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <h5 class="alert-heading"><i class="fas fa-key"></i> Password Berhasil Dibuat!</h5>
        <hr>
        <p><strong>NIK:</strong> {{ session('user_nik') }}</p>
        <p><strong>Password:</strong> <code class="text-danger fs-5">{{ session('generated_password') }}</code></p>
        <hr>
        <p class="mb-0"><small><i class="fas fa-exclamation-triangle"></i> Segera catat password ini! User wajib mengganti password saat login pertama kali.</small></p>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('reset_password'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <h5 class="alert-heading"><i class="fas fa-key"></i> Password Berhasil Direset!</h5>
        <hr>
        <p><strong>NIK:</strong> {{ session('reset_nik') }}</p>
        <p><strong>Nama:</strong> {{ session('reset_name') }}</p>
        <p><strong>Password Baru:</strong> <code class="text-danger fs-5">{{ session('reset_password') }}</code></p>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2><i class="fas fa-users me-2"></i>Manajemen User Warga</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Warga</li>
                    </ol>
                </nav>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="{{ route('admin.users.create') }}" class="btn btn-light">
                    <i class="fas fa-user-plus me-2"></i>Tambah Warga
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="search-filter-card">
        <form method="GET">
            <div class="row align-items-end">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label fw-bold">Cari Nama/NIK</label>
                    <input type="text" 
                           name="search" 
                           class="form-control form-control-custom" 
                           placeholder="Cari nama atau NIK..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select form-select-custom">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn w-100" style="background: #3498db; color: white;">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="card-custom">
        <div class="card-header-custom">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h4><i class="fas fa-list me-2"></i>Daftar User Warga</h4>
                <div class="text-white">
                    Total: <strong>{{ $users->total() }}</strong> User
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>NIK</th>
                            <th>Jenis Kelamin</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        @php
                            $profile = $user->profile;
                            $initials = strtoupper(substr($profile->full_name ?? 'U', 0, 1));
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">{{ $initials }}</div>
                                    <div>
                                        <p class="user-name">{{ $profile->full_name ?? 'N/A' }}</p>
                                        <p class="user-nik">ID: {{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $profile->nik ?? 'N/A' }}</td>
                            <td>
                                @if($profile->jenis_kelamin == 'L')
                                    <span class="badge bg-primary">Laki-laki</span>
                                @elseif($profile->jenis_kelamin == 'P')
                                    <span class="badge" style="background-color: #e91e63;">Perempuan</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ Str::limit($profile->alamat ?? 'Tidak ada alamat', 30) }}</small>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $user->status }}">
                                    {{ $user->status == 'active' ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.users.show', $user->id) }}" 
                                       class="btn-action btn-view" 
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="btn-action btn-edit" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.reset-password', $user->id) }}" 
                                          method="POST" 
                                          style="display: inline;">
                                        @csrf
                                        <button type="submit" 
                                                class="btn-action btn-reset" 
                                                title="Reset Password"
                                                onclick="return confirm('Reset password user ini? Password baru akan dibuat otomatis.')">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                          method="POST" 
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-action btn-delete" 
                                                title="Hapus"
                                                onclick="return confirm('Yakin menghapus user ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="no-data">
                                    <i class="fas fa-user-slash"></i>
                                    <h5>Belum ada data user</h5>
                                    <p class="text-muted">Silakan tambahkan user baru</p>
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus me-2"></i>Tambah User Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
                <div class="mt-4">
                    {{ $users->links('vendor.pagination.bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

{{-- @extends('layouts.app')

@section('title', 'Manajemen User Warga')

@push('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        padding: 2.5rem;
        border-radius: 24px;
        margin-bottom: 2rem;
        box-shadow: 0 20px 60px rgba(79, 172, 254, 0.3);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .page-header h2 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .breadcrumb {
        background: rgba(255, 255, 255, 0.15);
        padding: 0.5rem 1rem;
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .breadcrumb-item a {
        color: white;
        text-decoration: none;
        opacity: 0.9;
        transition: opacity 0.3s;
    }

    .breadcrumb-item a:hover {
        opacity: 1;
    }

    .breadcrumb-item.active {
        color: white;
        opacity: 1;
    }

    .card-custom {
        border: none;
        border-radius: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        overflow: hidden;
        background: white;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-custom:hover {
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .card-header-custom {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border: none;
        padding: 1.75rem 2rem;
    }

    .card-header-custom h4 {
        margin: 0;
        color: white;
        font-weight: 600;
        font-size: 1.25rem;
    }

    .card-header-custom .btn {
        background: white;
        border: none;
        border-radius: 12px;
        padding: 0.625rem 1.5rem;
        font-weight: 600;
        color: #4facfe;
        transition: all 0.3s;
    }

    .card-header-custom .btn:hover {
        background: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Enhanced Alerts */
    .alert-custom {
        border-radius: 20px;
        border: none;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        animation: slideInDown 0.5s ease-out;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }

    .alert-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .alert-danger {
        background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
        color: white;
    }

    .password-display {
        background: rgba(255, 255, 255, 0.95);
        padding: 1.5rem;
        border-radius: 15px;
        margin: 1rem 0;
        border: 2px solid rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);
    }

    .password-display .row {
        margin-bottom: 0.5rem;
    }

    .password-display strong {
        color: rgba(0, 0, 0, 0.7);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }

    .password-display .fw-bold {
        color: rgba(0, 0, 0, 0.85);
        font-size: 1rem;
    }

    .password-display code {
        background: rgba(0, 0, 0, 0.1);
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-weight: 700;
        letter-spacing: 2px;
        color: #e63946;
        font-size: 1.1rem;
        display: inline-block;
        margin-top: 0.25rem;
    }

    .password-display hr {
        border-color: rgba(255, 255, 255, 0.3);
        margin: 1.25rem 0;
    }

    .password-display .alert-warning {
        background: rgba(255, 193, 7, 0.15);
        border: 2px solid rgba(255, 193, 7, 0.3);
        color: rgba(0, 0, 0, 0.8);
        border-radius: 10px;
        padding: 0.75rem 1rem;
    }

    .password-display .alert-warning i {
        color: #ffc107;
    }

    /* Search and Filter */
    .search-filter-card {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control-custom, .form-select-custom {
        border: 2px solid #e9ecef;
        border-radius: 15px;
        padding: 0.875rem 1.25rem;
        transition: all 0.3s;
        font-size: 0.95rem;
    }

    .form-control-custom:focus, .form-select-custom:focus {
        border-color: #4facfe;
        box-shadow: 0 0 0 0.25rem rgba(79, 172, 254, 0.15);
        outline: none;
        transform: translateY(-2px);
    }

    .btn-search {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        border: none;
        border-radius: 15px;
        padding: 0.875rem 2rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 172, 254, 0.4);
    }

    /* Table */
    .table-container {
        overflow-x: auto;
        border-radius: 0 0 24px 24px;
    }

    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    .table-custom thead th {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        padding: 1.25rem 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        border-bottom: 3px solid #4facfe;
        font-size: 0.813rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        white-space: nowrap;
    }

    .table-custom tbody tr {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-bottom: 1px solid #f1f3f5;
    }

    .table-custom tbody tr:hover {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.05) 0%, rgba(0, 242, 254, 0.05) 100%);
        transform: scale(1.002);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .table-custom tbody td {
        padding: 1.25rem 1.5rem;
        vertical-align: middle;
        font-size: 0.9rem;
    }

    /* User Info */
    .user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4facfe, #00f2fe);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        margin-right: 1rem;
        box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .user-name {
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
        font-size: 0.95rem;
    }

    .user-nik {
        font-size: 0.75rem;
        color: #95a5a6;
        margin: 0;
    }

    /* Enhanced Password Display */
    .password-cell {
        position: relative;
    }

    .password-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .password-text {
        font-family: 'Courier New', monospace;
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.85rem;
        padding: 0.5rem 0.875rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        border: 2px solid #dee2e6;
        cursor: pointer;
        transition: all 0.3s;
        user-select: none;
        min-width: 100px;
        text-align: center;
    }

    .password-text:hover {
        background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .password-hidden {
        letter-spacing: 4px;
        color: #6c757d;
    }

    .password-visible {
        color: #e63946;
        font-weight: 700;
        letter-spacing: 1.5px;
        background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
        border-color: #ff6a00;
        animation: pulse 0.5s ease-in-out;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .btn-toggle-password,
    .btn-copy-password {
        background: white;
        border: 2px solid #4facfe;
        color: #4facfe;
        border-radius: 10px;
        padding: 0.375rem;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
    }

    .btn-toggle-password:hover {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        transform: translateY(-2px) rotate(5deg);
        box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
    }

    .btn-copy-password {
        border-color: #11998e;
        color: #11998e;
    }

    .btn-copy-password:hover {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        transform: translateY(-2px) rotate(-5deg);
        box-shadow: 0 4px 15px rgba(17, 153, 142, 0.4);
    }

    .btn-copy-password:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        border-color: #ccc;
        color: #ccc;
    }

    .btn-copy-password:disabled:hover {
        background: white;
        transform: none;
        box-shadow: none;
    }

    /* Status Badge */
    .status-badge {
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .status-active {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }

    .status-inactive {
        background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
        color: white;
    }

    /* Gender Badge */
    .gender-badge {
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .gender-male {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .gender-female {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    /* Enhanced Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-action {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
        cursor: pointer;
        position: relative;
    }

    .btn-action:hover {
        transform: translateY(-3px) scale(1.05);
    }

    .btn-view {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);
        color: #4facfe;
        border-color: rgba(79, 172, 254, 0.2);
    }

    .btn-view:hover {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(79, 172, 254, 0.4);
    }

    .btn-edit {
        background: linear-gradient(135deg, rgba(52, 152, 219, 0.1) 0%, rgba(41, 128, 185, 0.1) 100%);
        color: #3498db;
        border-color: rgba(52, 152, 219, 0.2);
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(52, 152, 219, 0.4);
    }

    .btn-change-password {
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.1) 0%, rgba(56, 239, 125, 0.1) 100%);
        color: #11998e;
        border-color: rgba(17, 153, 142, 0.2);
    }

    .btn-change-password:hover {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(17, 153, 142, 0.4);
    }

    .btn-reset {
        background: linear-gradient(135deg, rgba(241, 196, 15, 0.1) 0%, rgba(243, 156, 18, 0.1) 100%);
        color: #f39c12;
        border-color: rgba(241, 196, 15, 0.2);
    }

    .btn-reset:hover {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(241, 196, 15, 0.4);
    }

    .btn-delete {
        background: linear-gradient(135deg, rgba(238, 9, 121, 0.1) 0%, rgba(255, 106, 0, 0.1) 100%);
        color: #ee0979;
        border-color: rgba(238, 9, 121, 0.2);
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #ee0979 0%, #ff6a00 100%);
        color: white;
        box-shadow: 0 8px 20px rgba(238, 9, 121, 0.4);
    }

    /* Stats Cards */
    .stats-row {
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 1.75rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 2px solid transparent;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        border-color: rgba(79, 172, 254, 0.2);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .stat-icon-primary {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.15) 0%, rgba(0, 242, 254, 0.15) 100%);
        color: #4facfe;
    }

    .stat-icon-success {
        background: linear-gradient(135deg, rgba(17, 153, 142, 0.15) 0%, rgba(56, 239, 125, 0.15) 100%);
        color: #11998e;
    }

    .stat-icon-danger {
        background: linear-gradient(135deg, rgba(238, 9, 121, 0.15) 0%, rgba(255, 106, 0, 0.15) 100%);
        color: #ee0979;
    }

    .stat-icon-warning {
        background: linear-gradient(135deg, rgba(241, 196, 15, 0.15) 0%, rgba(243, 156, 18, 0.15) 100%);
        color: #f39c12;
    }

    .stat-value {
        font-size: 2.25rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    /* No Data */
    .no-data {
        text-align: center;
        padding: 4rem 2rem;
    }

    .no-data i {
        font-size: 5rem;
        color: rgba(79, 172, 254, 0.2);
        margin-bottom: 1.5rem;
    }

    .no-data h5 {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 1rem;
        font-size: 1.25rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-header h2 {
            font-size: 1.5rem;
        }

        .stat-card {
            margin-bottom: 1rem;
        }

        .password-wrapper {
            flex-direction: column;
            gap: 0.25rem;
        }

        .btn-toggle-password,
        .btn-copy-password {
            width: 100%;
        }

        .password-display {
            padding: 1rem;
        }

        .password-display code {
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
        }
    }
</style>
@endpush

@section('content')
<div class="main-content">
    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-start">
            <div class="me-3">
                <i class="fas fa-check-circle fa-2x"></i>
            </div>
            <div class="flex-grow-1">
                <h5 class="alert-heading fw-bold mb-2">
                    {{ session('success') }}
                </h5>
                @if(session('generated_password'))
                <div class="password-display mt-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong><i class="fas fa-user me-2"></i>Nama:</strong><br>
                            <span class="fw-bold">{{ session('user_name') }}</span>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-id-card me-2"></i>NIK:</strong><br>
                            <span class="fw-bold">{{ session('user_nik') }}</span>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-key me-2"></i>Password Baru:</strong><br>
                            <code>{{ session('generated_password') }}</code>
                        </div>
                    </div>
                    <hr>
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <small><strong>PENTING:</strong> Catat password ini! User wajib mengganti password saat login pertama kali.</small>
                    </div>
                </div>
                @endif
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if(session('reset_password'))
    <div class="alert alert-info alert-custom alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-start">
            <div class="me-3">
                <i class="fas fa-sync-alt fa-2x"></i>
            </div>
            <div class="flex-grow-1">
                <h5 class="alert-heading fw-bold mb-2">
                    Password Berhasil Direset!
                </h5>
                <div class="password-display mt-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong><i class="fas fa-user me-2"></i>Nama:</strong><br>
                            <span class="fw-bold">{{ session('reset_name') }}</span>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-id-card me-2"></i>NIK:</strong><br>
                            <span class="fw-bold">{{ session('reset_nik') }}</span>
                        </div>
                        <div class="col-md-4">
                            <strong><i class="fas fa-key me-2"></i>Password Baru:</strong><br>
                            <code>{{ session('reset_password') }}</code>
                        </div>
                    </div>
                    <hr>
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        <small><strong>CATATAN:</strong> Password telah direset ke format default.</small>
                    </div>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-start">
            <div class="me-3">
                <i class="fas fa-exclamation-circle fa-2x"></i>
            </div>
            <div class="flex-grow-1">
                <h5 class="alert-heading fw-bold mb-0">
                    {{ session('error') }}
                </h5>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2><i class="fas fa-users-cog me-2"></i>Manajemen User Warga</h2>
                <nav aria-label="breadcrumb" class="mt-2">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Warga</li>
                    </ol>
                </nav>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="{{ route('admin.users.create') }}" class="btn btn-light">
                    <i class="fas fa-user-plus me-2"></i>Tambah Warga
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row stats-row">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon stat-icon-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-value">{{ $users->total() }}</div>
                <div class="stat-label">Total User</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon stat-icon-success">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-value">{{ $users->where('status', 'active')->count() }}</div>
                <div class="stat-label">User Aktif</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon stat-icon-danger">
                    <i class="fas fa-user-times"></i>
                </div>
                <div class="stat-value">{{ $users->where('status', 'inactive')->count() }}</div>
                <div class="stat-label">User Nonaktif</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon stat-icon-warning">
                    <i class="fas fa-key"></i>
                </div>
                <div class="stat-value">{{ $users->where('must_change_password', true)->count() }}</div>
                <div class="stat-label">Perlu Ganti PW</div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="search-filter-card">
        <form method="GET">
            <div class="row align-items-end">
                <div class="col-md-5 mb-3 mb-md-0">
                    <label class="form-label">Cari Nama/NIK</label>
                    <input type="text" 
                           name="search" 
                           class="form-control form-control-custom" 
                           placeholder="Ketik nama atau NIK..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select form-select-custom">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3 mb-md-0">
                    <label class="form-label">Per Halaman</label>
                    <select name="per_page" class="form-select form-select-custom">
                        <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-search w-100">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="card-custom">
        <div class="card-header-custom">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h4><i class="fas fa-list-ul me-2"></i>Daftar User Warga</h4>
                <div class="text-white">
                    Menampilkan <strong>{{ $users->count() }}</strong> dari <strong>{{ $users->total() }}</strong> User
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-container">
                <table class="table table-custom mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th style="min-width: 200px;">Informasi User</th>
                            <th style="min-width: 150px;">NIK</th>
                            <th style="min-width: 200px;">Password</th>
                            <th style="min-width: 130px;">Gender</th>
                            <th style="min-width: 200px;">Alamat</th>
                            <th style="min-width: 100px;">Status</th>
                            <th style="min-width: 280px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        @php
                            $profile = $user->profile;
                            $initials = strtoupper(substr($profile->full_name ?? 'U', 0, 1));
                            
                            // Cek apakah ini user yang baru dibuat/direset
                            $isNewUser = session('new_user_id') == $user->id;
                            $isResetUser = session('reset_user_id') == $user->id;
                            
                            // Tentukan password yang akan ditampilkan
                            if ($isNewUser && session('generated_password')) {
                                $displayPassword = session('generated_password');
                            } elseif ($isResetUser && session('reset_password')) {
                                $displayPassword = session('reset_password');
                            } else {
                                $displayPassword = '••••••••';
                            }
                        @endphp
                        <tr>
                            <td class="text-center fw-bold text-muted">
                                {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">{{ $initials }}</div>
                                    <div>
                                        <p class="user-name">{{ $profile->full_name ?? 'N/A' }}</p>
                                        <p class="user-nik">ID: {{ $user->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $profile->nik ?? 'N/A' }}</span>
                            </td>
                            <td class="password-cell">
                                <div class="password-wrapper">
                                    @if($isNewUser || $isResetUser)
                                    <span class="password-text password-visible" 
                                          data-password="{{ $displayPassword }}"
                                          id="password-{{ $user->id }}">
                                        {{ $displayPassword }}
                                    </span>
                                    @else
                                    <span class="password-text password-hidden" 
                                          data-password="••••••••"
                                          id="password-{{ $user->id }}">
                                        ••••••••
                                    </span>
                                    @endif
                                    <button type="button" 
                                            class="btn-copy-password" 
                                            onclick="copyPassword('{{ $isNewUser || $isResetUser ? $displayPassword : '' }}', {{ $user->id }})"
                                            title="Salin Password"
                                            {{ !($isNewUser || $isResetUser) ? 'disabled' : '' }}>
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                @if($isNewUser || $isResetUser)
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle me-1"></i>Password baru ditampilkan
                                </small>
                                @endif
                            </td>
                            <td>
                                @if($profile->jenis_kelamin == 'L')
                                    <span class="gender-badge gender-male">
                                        <i class="fas fa-mars me-1"></i>Laki-laki
                                    </span>
                                @elseif($profile->jenis_kelamin == 'P')
                                    <span class="gender-badge gender-female">
                                        <i class="fas fa-venus me-1"></i>Perempuan
                                    </span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ Str::limit($profile->alamat ?? 'Tidak ada alamat', 40) }}
                                </small>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $user->status }}">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>
                                    {{ $user->status == 'active' ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.users.show', $user->id) }}" 
                                       class="btn-action btn-view" 
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="btn-action btn-edit" 
                                       title="Edit User">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.generate-password', $user->id) }}" 
                                          method="POST" 
                                          style="display: inline;">
                                        @csrf
                                        <button type="button"
                                                class="btn-action btn-change-password" 
                                                title="Buat Password Baru"
                                                onclick="confirmGeneratePassword(event, '{{ addslashes($profile->full_name) }}', '{{ $profile->nik }}', this.form)">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.reset-password', $user->id) }}" 
                                          method="POST" 
                                          style="display: inline;">
                                        @csrf
                                        <button type="button" 
                                                class="btn-action btn-reset" 
                                                title="Reset ke Password Default"
                                                onclick="confirmResetPassword(event, '{{ addslashes($profile->full_name) }}', '{{ $profile->nik }}', this.form)">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                          method="POST" 
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn-action btn-delete" 
                                                title="Hapus User"
                                                onclick="confirmDelete(event, '{{ addslashes($profile->full_name) }}', this.form)">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">
                                <div class="no-data">
                                    <i class="fas fa-user-slash"></i>
                                    <h5>Belum Ada Data User</h5>
                                    <p>Silakan tambahkan user warga pertama untuk memulai</p>
                                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mt-2" style="border-radius: 15px; padding: 0.75rem 2rem;">
                                        <i class="fas fa-plus me-2"></i>Tambah User Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($users->hasPages())
                <div class="p-4 border-top">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="text-muted mb-3 mb-md-0">
                            Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} data
                        </div>
                        <div>
                            {{ $users->appends(request()->query())->links('vendor.pagination.bootstrap-5') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Copy password to clipboard
function copyPassword(password, userId) {
    if (!password || password === '••••••••') {
        Swal.fire({
            icon: 'warning',
            title: 'Password Tidak Tersedia',
            text: 'Tidak ada password yang dapat disalin',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }

    navigator.clipboard.writeText(password).then(() => {
        Swal.fire({
            icon: 'success',
            title: 'Password Disalin!',
            text: 'Password berhasil disalin ke clipboard',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            background: '#11998e',
            color: 'white'
        });
    }).catch(err => {
        console.error('Gagal menyalin password:', err);
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Tidak dapat menyalin password',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000
        });
    });
}

// Confirm generate new password
function confirmGeneratePassword(event, userName, userNik, form) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Buat Password Baru?',
        html: `
            <div class="text-start">
                <p>Anda akan membuat password <strong>BARU OTOMATIS</strong> untuk:</p>
                <div class="alert alert-info py-2 mb-3">
                    <strong><i class="fas fa-user me-2"></i>Nama:</strong> ${userName}<br>
                    <strong><i class="fas fa-id-card me-2"></i>NIK:</strong> ${userNik}
                </div>
                <div class="alert alert-warning py-2 mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i> 
                    <small>Sistem akan membuat password acak baru (8 karakter). Password lama akan diganti.</small>
                </div>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-key me-2"></i>Ya, Buat Password Baru',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#11998e',
        cancelButtonColor: '#6c757d',
        reverseButtons: true,
        width: '550px',
        customClass: {
            confirmButton: 'btn btn-success px-4 py-2',
            cancelButton: 'btn btn-secondary px-4 py-2'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// Confirm reset password to default
function confirmResetPassword(event, userName, userNik, form) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Reset Password ke Default?',
        html: `
            <div class="text-start">
                <p>Anda akan mereset password ke <strong>DEFAULT (dari NIK)</strong> untuk:</p>
                <div class="alert alert-info py-2 mb-3">
                    <strong><i class="fas fa-user me-2"></i>Nama:</strong> ${userName}<br>
                    <strong><i class="fas fa-id-card me-2"></i>NIK:</strong> ${userNik}
                </div>
                <div class="alert alert-warning py-2 mb-0">
                    <i class="fas fa-info-circle me-2"></i> 
                    <small>Password akan direset ke format default yang dibuat dari NIK.</small>
                </div>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-sync-alt me-2"></i>Ya, Reset Password',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#f39c12',
        cancelButtonColor: '#6c757d',
        reverseButtons: true,
        width: '550px',
        customClass: {
            confirmButton: 'btn btn-warning px-4 py-2',
            cancelButton: 'btn btn-secondary px-4 py-2'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// Confirm delete
function confirmDelete(event, userName, form) {
    event.preventDefault();
    
    Swal.fire({
        title: 'Hapus User?',
        html: `
            <div class="text-start">
                <p>Anda akan menghapus user:</p>
                <div class="alert alert-danger py-2 mb-3">
                    <strong><i class="fas fa-user me-2"></i>Nama:</strong> ${userName}
                </div>
                <div class="alert alert-warning py-2 mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i> 
                    <small><strong>PERHATIAN:</strong> Data yang dihapus tidak dapat dikembalikan! Semua data terkait user juga akan dihapus.</small>
                </div>
            </div>
        `,
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-trash-alt me-2"></i>Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#ee0979',
        cancelButtonColor: '#6c757d',
        reverseButtons: true,
        width: '550px',
        customClass: {
            confirmButton: 'btn btn-danger px-4 py-2',
            cancelButton: 'btn btn-secondary px-4 py-2'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
}

// Auto dismiss alerts and auto-hide passwords
document.addEventListener('DOMContentLoaded', function() {
    // Auto dismiss alerts after 15 seconds
    const alerts = document.querySelectorAll('.alert-custom');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 15000);
    });

    // Auto hide visible passwords after 30 seconds
    const visiblePasswords = document.querySelectorAll('.password-visible');
    visiblePasswords.forEach(function(passwordEl) {
        setTimeout(function() {
            passwordEl.textContent = '••••••••';
            passwordEl.classList.remove('password-visible');
            passwordEl.classList.add('password-hidden');
            passwordEl.setAttribute('data-password', '••••••••');
            
            // Disable copy button
            const copyBtn = passwordEl.nextElementSibling;
            if (copyBtn && copyBtn.classList.contains('btn-copy-password')) {
                copyBtn.disabled = true;
                copyBtn.style.opacity = '0.5';
                copyBtn.style.cursor = 'not-allowed';
            }
        }, 30000);
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush

@endsection --}}