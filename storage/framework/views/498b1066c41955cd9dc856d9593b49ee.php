

<?php $__env->startSection('title', 'Manajemen Kader'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .page-header {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        padding: 2rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);
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
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
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
        color: #f39c12;
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
        border-color: #f39c12;
        box-shadow: 0 0 0 0.2rem rgba(243, 156, 18, 0.25);
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
        border-bottom: 2px solid #f39c12;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-custom tbody tr {
        transition: all 0.3s ease;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(243, 156, 18, 0.05);
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
        background: linear-gradient(135deg, #f39c12, #e67e22);
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

    .user-email {
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
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="main-content">
    <!-- Page Header -->
    <?php if(session('password')): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <h5 class="alert-heading"><i class="fas fa-key"></i> Password Berhasil Dibuat!</h5>
        <hr>
        <p><strong>Email:</strong> <?php echo e(session('email') ?? 'N/A'); ?></p>
        <p><strong>Password:</strong> <code class="text-danger fs-5"><?php echo e(session('password')); ?></code></p>
        <hr>
        <p class="mb-0"><small><i class="fas fa-exclamation-triangle"></i> Segera catat password ini!</small></p>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2><i class="fas fa-user-nurse me-2"></i>Manajemen Kader Posyandu</h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Kader</li>
                    </ol>
                </nav>
            </div>
            <div class="mt-3 mt-md-0">
                <a href="<?php echo e(route('admin.kaders.create')); ?>" class="btn btn-light">
                    <i class="fas fa-user-plus me-2"></i>Tambah Kader
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="search-filter-card">
        <form method="GET">
            <div class="row align-items-end">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label fw-bold">Cari Nama/Email/NIK</label>
                    <input type="text" 
                           name="search" 
                           class="form-control form-control-custom" 
                           placeholder="Cari nama, email, atau NIK..."
                           value="<?php echo e(request('search')); ?>">
                </div>
                <div class="col-md-3 mb-3 mb-md-0">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select form-select-custom">
                        <option value="">Semua Status</option>
                        <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Aktif</option>
                        <option value="inactive" <?php echo e(request('status') == 'inactive' ? 'selected' : ''); ?>>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn w-100" style="background: #f39c12; color: white;">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Kader Table -->
    <div class="card-custom">
        <div class="card-header-custom">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h4><i class="fas fa-list me-2"></i>Daftar Kader Posyandu</h4>
                <div class="text-white">
                    Total: <strong><?php echo e($kaders->total()); ?></strong> Kader
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-container">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kader</th>
                            <th>Email</th>
                            <th>Jabatan</th>
                            <th>Status Kader</th>
                            <th>Status Akun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $kaders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kader): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $profile = $kader->profile;
                            $initials = strtoupper(substr($profile->full_name ?? 'K', 0, 1));
                        ?>
                        <tr>
                            <td><?php echo e($loop->iteration + ($kaders->currentPage() - 1) * $kaders->perPage()); ?></td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar"><?php echo e($initials); ?></div>
                                    <div>
                                        <p class="user-name"><?php echo e($profile->full_name ?? 'N/A'); ?></p>
                                        <p class="user-email"><?php echo e($kader->email); ?></p>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo e($kader->email); ?></td>
                            <td>
                                <span class="badge bg-info"><?php echo e($kader->kader->jabatan ?? '-'); ?></span>
                            </td>
                            <td>
                                <?php if($kader->kader): ?>
                                    <span class="status-badge <?php echo e($kader->kader->status_kader == 'aktif' ? 'status-active' : 'status-inactive'); ?>">
                                        <?php echo e($kader->kader->status_kader == 'aktif' ? 'Aktif' : 'Nonaktif'); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="status-badge status-<?php echo e($kader->status); ?>">
                                    <?php echo e($kader->status == 'active' ? 'Aktif' : 'Nonaktif'); ?>

                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo e(route('admin.kaders.show', $kader->id)); ?>" 
                                       class="btn-action btn-view" 
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.kaders.edit', $kader->id)); ?>" 
                                       class="btn-action btn-edit" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('admin.kaders.reset-password', $kader->id)); ?>" 
                                          method="POST" 
                                          style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                class="btn-action btn-reset" 
                                                title="Reset Password"
                                                onclick="return confirm('Reset password kader ini?')">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('admin.kaders.destroy', $kader->id)); ?>" 
                                          method="POST" 
                                          style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" 
                                                class="btn-action btn-delete" 
                                                title="Hapus"
                                                onclick="return confirm('Yakin menghapus kader ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7">
                                <div class="no-data">
                                    <i class="fas fa-user-nurse-slash"></i>
                                    <h5>Belum ada data kader</h5>
                                    <p class="text-muted">Silakan tambahkan kader baru</p>
                                    <a href="<?php echo e(route('admin.kaders.create')); ?>" class="btn btn-warning mt-2">
                                        <i class="fas fa-plus me-2"></i>Tambah Kader Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if($kaders->hasPages()): ?>
                <div class="mt-4">
                    <?php echo e($kaders->links('vendor.pagination.bootstrap-5')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/admin/kaders/index.blade.php ENDPATH**/ ?>