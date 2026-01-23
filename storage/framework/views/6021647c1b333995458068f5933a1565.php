

<?php $__env->startSection('title', 'Daftar Pemeriksaan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-notes-medical me-2"></i>Daftar Pemeriksaan</h1>
        <a href="<?php echo e(route('kader.pemeriksaan.create')); ?>" class="btn btn-primary shadow-sm"><i class="fas fa-plus me-2"></i>Pemeriksaan Baru</a>
    </div>

    <div class="card shadow mb-4 border-0">
        <div class="card-body">
            <form action="<?php echo e(route('kader.pemeriksaan.index')); ?>" method="GET" class="row g-3">
                <div class="col-md-4">
                    <select class="form-select" name="type" onchange="this.form.submit()">
                        <option value="all" <?php echo e($type == 'all' ? 'selected' : ''); ?>>Semua Kategori</option>
                        <option value="balita" <?php echo e($type == 'balita' ? 'selected' : ''); ?>>Balita</option>
                        <option value="remaja" <?php echo e($type == 'remaja' ? 'selected' : ''); ?>>Remaja</option>
                        <option value="lansia" <?php echo e($type == 'lansia' ? 'selected' : ''); ?>>Lansia</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama pasien..." value="<?php echo e($search); ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Tanggal</th>
                            <th>Nama Pasien</th>
                            <th>Kategori</th>
                            <th>Hasil Dasar</th>
                            <th>Diagnosa</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pemeriksaans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cek): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4"><?php echo e($cek->created_at->format('d/m/Y')); ?></td>
                            <td class="fw-bold"><?php echo e($cek->kunjungan->pasien->nama_lengkap); ?></td>
                            <td>
                                <?php
                                    $class = get_class($cek->kunjungan->pasien);
                                    $label = str_contains($class, 'Balita') ? 'Balita' : (str_contains($class, 'Remaja') ? 'Remaja' : 'Lansia');
                                    $badge = $label == 'Balita' ? 'success' : ($label == 'Remaja' ? 'info' : 'warning');
                                ?>
                                <span class="badge bg-<?php echo e($badge); ?>"><?php echo e($label); ?></span>
                            </td>
                            <td>
                                <small>
                                    BB: <?php echo e($cek->berat_badan); ?> kg<br>
                                    TB: <?php echo e($cek->tinggi_badan); ?> cm
                                </small>
                            </td>
                            <td><?php echo e(Str::limit($cek->diagnosa, 30) ?? '-'); ?></td>
                            <td class="text-end pe-4">
                                <a href="<?php echo e(route('kader.pemeriksaan.show', $cek->id)); ?>" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i></a>
                                <a href="<?php echo e(route('kader.pemeriksaan.edit', $cek->id)); ?>" class="btn btn-sm btn-warning text-white"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Belum ada data pemeriksaan.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                <?php echo e($pemeriksaans->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.kader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/pemeriksaan/index.blade.php ENDPATH**/ ?>