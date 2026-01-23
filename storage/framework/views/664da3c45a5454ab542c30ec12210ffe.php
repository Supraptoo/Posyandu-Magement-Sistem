

<?php $__env->startSection('title', 'Data Balita'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Data Balita</h1>
        <p class="text-muted mb-0">Kelola data balita di wilayah kerja Anda</p>
    </div>
    <a href="<?php echo e(route('kader.data.balita.create')); ?>" class="btn btn-primary shadow-sm rounded-pill px-4">
        <i class="fas fa-plus me-2"></i>Tambah Balita
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <form action="<?php echo e(route('kader.data.balita.index')); ?>" method="GET">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" class="form-control border-0 bg-light" name="search" 
                               placeholder="Cari nama balita, NIK, atau nama ibu..." 
                               value="<?php echo e(request('search')); ?>">
                        <button class="btn btn-primary px-4" type="submit">Cari</button>
                        <?php if(request('search')): ?>
                        <a href="<?php echo e(route('kader.data.balita.index')); ?>" class="btn btn-light border ms-2" title="Reset">
                            <i class="fas fa-sync-alt text-muted"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-md">
    <div class="card-body p-0">
        <?php if($balitas->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 border-0 text-secondary small text-uppercase fw-bold">Balita</th>
                        <th class="py-3 border-0 text-secondary small text-uppercase fw-bold">Informasi</th>
                        <th class="py-3 border-0 text-secondary small text-uppercase fw-bold">Orang Tua</th>
                        <th class="px-4 py-3 border-0 text-secondary small text-uppercase fw-bold text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $balitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $balita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-<?php echo e($balita->jenis_kelamin == 'L' ? 'info' : 'danger'); ?>-subtle text-<?php echo e($balita->jenis_kelamin == 'L' ? 'info' : 'danger'); ?> rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                    <i class="fas fa-baby fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark"><?php echo e($balita->nama_lengkap); ?></div>
                                    <div class="small text-muted">NIK: <?php echo e($balita->nik); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="d-flex flex-column gap-1">
                                <span class="badge bg-light text-dark border fw-normal" style="width: fit-content;">
                                    <i class="fas fa-birthday-cake me-1 text-warning"></i> 
                                    <?php
                                        $usia_bulan = $balita->tanggal_lahir->diffInMonths(now());
                                        $usia_tahun = floor($usia_bulan / 12);
                                        $sisa_bulan = $usia_bulan % 12;
                                    ?>
                                    <?php echo e($usia_tahun > 0 ? $usia_tahun . ' Th ' : ''); ?><?php echo e($sisa_bulan); ?> Bln
                                </span>
                                <small class="text-muted"><?php echo e($balita->tanggal_lahir->format('d M Y')); ?></small>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="small text-muted mb-1">Ibu: <span class="fw-bold text-dark"><?php echo e($balita->nama_ibu); ?></span></div>
                            <div class="small text-muted"><i class="fas fa-map-marker-alt me-1"></i> <?php echo e(Str::limit($balita->alamat, 20)); ?></div>
                        </td>
                        <td class="px-4 py-3 text-end">
                            <div class="dropdown">
                                <button class="btn btn-light btn-sm rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg">
                                    <li><a class="dropdown-item" href="<?php echo e(route('kader.data.balita.show', $balita->id)); ?>"><i class="fas fa-eye me-2 text-info"></i>Detail</a></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('kader.data.balita.edit', $balita->id)); ?>"><i class="fas fa-edit me-2 text-warning"></i>Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button type="button" class="dropdown-item text-danger btn-delete" data-id="<?php echo e($balita->id); ?>">
                                            <i class="fas fa-trash me-2"></i>Hapus
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-top">
            <?php echo e($balitas->links()); ?>

        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="fas fa-baby-carriage fa-3x text-muted opacity-25"></i>
            </div>
            <h5 class="text-muted">Tidak ada data balita ditemukan</h5>
            <p class="text-muted small">Coba kata kunci lain atau tambahkan data baru</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <div class="avatar-lg bg-danger-subtle text-danger rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-trash-alt fs-3"></i>
                    </div>
                </div>
                <h5 class="fw-bold mb-2">Hapus Data Balita?</h5>
                <p class="text-muted mb-4">Data yang dihapus tidak dapat dikembalikan. Riwayat pemeriksaan terkait juga akan terhapus.</p>
                <form id="deleteForm" method="POST" class="d-flex justify-content-center gap-2">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4 rounded-pill">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const form = document.getElementById('deleteForm');
            form.action = `<?php echo e(url('kader/data/balita')); ?>/${id}`;
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.kader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/data/balita/index.blade.php ENDPATH**/ ?>