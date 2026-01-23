

<?php $__env->startSection('title', 'Detail Pemeriksaan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pemeriksaan</h1>
        <div>
            <a href="<?php echo e(route('kader.pemeriksaan.edit', $pemeriksaan->id)); ?>" class="btn btn-warning"><i class="fas fa-edit me-2"></i>Edit</a>
            <a href="<?php echo e(route('kader.pemeriksaan.index')); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Data Pasien</h6>
                </div>
                <div class="card-body text-center">
                    <h4 class="fw-bold mb-1"><?php echo e($pemeriksaan->kunjungan->pasien->nama_lengkap); ?></h4>
                    <p class="text-muted mb-3"><?php echo e($pemeriksaan->kunjungan->pasien->nik); ?></p>
                    
                    <?php
                        $class = get_class($pemeriksaan->kunjungan->pasien);
                        $type = str_contains($class, 'Balita') ? 'balita' : (str_contains($class, 'Remaja') ? 'remaja' : 'lansia');
                    ?>

                    <ul class="list-group list-group-flush text-start">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Usia</span>
                            <span class="fw-bold"><?php echo e($pemeriksaan->kunjungan->pasien->tanggal_lahir->age); ?> Tahun</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Tanggal Periksa</span>
                            <span class="fw-bold"><?php echo e($pemeriksaan->created_at->format('d M Y')); ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Petugas</span>
                            <span class="fw-bold"><?php echo e($pemeriksaan->pemeriksa->profile->full_name ?? 'Admin'); ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">Hasil Pemeriksaan Fisik</h6>
                </div>
                <div class="card-body">
                    <h6 class="text-success fw-bold mb-3">Tanda Vital</h6>
                    <div class="row text-center mb-4">
                        <div class="col-3">
                            <div class="p-2 border rounded bg-light">
                                <small class="d-block text-muted">Berat Badan</small>
                                <span class="h5 fw-bold"><?php echo e($pemeriksaan->berat_badan); ?></span> kg
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2 border rounded bg-light">
                                <small class="d-block text-muted">Tinggi Badan</small>
                                <span class="h5 fw-bold"><?php echo e($pemeriksaan->tinggi_badan); ?></span> cm
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2 border rounded bg-light">
                                <small class="d-block text-muted">Suhu</small>
                                <span class="h5 fw-bold"><?php echo e($pemeriksaan->suhu_tubuh ?? '-'); ?></span> °C
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2 border rounded bg-light">
                                <small class="d-block text-muted">IMT</small>
                                <span class="h5 fw-bold"><?php echo e(number_format($pemeriksaan->imt, 1)); ?></span>
                            </div>
                        </div>
                    </div>

                    <?php if($type == 'balita'): ?>
                    <h6 class="text-success fw-bold mb-3">Pengukuran Balita</h6>
                    <ul class="list-group mb-4">
                        <li class="list-group-item">Lingkar Kepala: <strong><?php echo e($pemeriksaan->lingkar_kepala ?? '-'); ?> cm</strong></li>
                        <li class="list-group-item">Lingkar Lengan: <strong><?php echo e($pemeriksaan->lingkar_lengan ?? '-'); ?> cm</strong></li>
                    </ul>
                    <?php endif; ?>

                    <?php if($type == 'lansia' || $type == 'remaja'): ?>
                    <h6 class="text-success fw-bold mb-3">Laboratorium Sederhana</h6>
                    <div class="row g-2 mb-4">
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>Tekanan Darah</span>
                                <span class="fw-bold <?php echo e($pemeriksaan->tekanan_darah ? '' : 'text-muted'); ?>"><?php echo e($pemeriksaan->tekanan_darah ?? 'Tidak diukur'); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>Gula Darah</span>
                                <span class="fw-bold"><?php echo e($pemeriksaan->gula_darah ?? '-'); ?> mg/dL</span>
                            </div>
                        </div>
                        <?php if($type == 'lansia'): ?>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>Kolesterol</span>
                                <span class="fw-bold"><?php echo e($pemeriksaan->kolesterol ?? '-'); ?> mg/dL</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span>Asam Urat</span>
                                <span class="fw-bold"><?php echo e($pemeriksaan->asam_urat ?? '-'); ?> mg/dL</span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <div class="alert alert-secondary">
                        <h6 class="fw-bold">Diagnosa:</h6>
                        <p class="mb-0"><?php echo e($pemeriksaan->diagnosa ?? 'Belum ada diagnosa'); ?></p>
                        <hr>
                        <h6 class="fw-bold">Tindakan / Resep:</h6>
                        <p class="mb-0"><?php echo e($pemeriksaan->tindakan ?? '-'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.kader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/pemeriksaan/show.blade.php ENDPATH**/ ?>