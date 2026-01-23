

<?php $__env->startSection('title', 'Edit Pemeriksaan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-edit me-2"></i>Edit Pemeriksaan</h1>
        <a href="<?php echo e(route('kader.pemeriksaan.show', $pemeriksaan->id)); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <h6 class="m-0 font-weight-bold"><i class="fas fa-stethoscope me-2"></i>Form Edit Data</h6>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('kader.pemeriksaan.update', $pemeriksaan->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="alert alert-light border mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Nama Pasien:</strong> <?php echo e($pemeriksaan->kunjungan->pasien->nama_lengkap); ?><br>
                            <strong>Kategori:</strong> <span class="badge bg-info"><?php echo e(strtoupper($pasien_type)); ?></span>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <strong>Tanggal Kunjungan:</strong> <?php echo e($pemeriksaan->kunjungan->tanggal_kunjungan->format('d M Y')); ?>

                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Berat Badan (kg)</label>
                        <input type="number" step="0.01" class="form-control" name="berat_badan" value="<?php echo e($pemeriksaan->berat_badan); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tinggi Badan (cm)</label>
                        <input type="number" step="0.01" class="form-control" name="tinggi_badan" value="<?php echo e($pemeriksaan->tinggi_badan); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Suhu Tubuh (°C)</label>
                        <input type="number" step="0.1" class="form-control" name="suhu_tubuh" value="<?php echo e($pemeriksaan->suhu_tubuh); ?>">
                    </div>
                </div>

                <?php if($pasien_type == 'balita'): ?>
                <div class="card bg-light border-0 mb-3">
                    <div class="card-body">
                        <h6 class="text-primary fw-bold">Parameter Balita</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Lingkar Kepala (cm)</label>
                                <input type="number" step="0.1" class="form-control" name="lingkar_kepala" value="<?php echo e($pemeriksaan->lingkar_kepala); ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Lingkar Lengan (cm)</label>
                                <input type="number" step="0.1" class="form-control" name="lingkar_lengan" value="<?php echo e($pemeriksaan->lingkar_lengan); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($pasien_type == 'remaja'): ?>
                <div class="card bg-light border-0 mb-3">
                    <div class="card-body">
                        <h6 class="text-primary fw-bold">Parameter Remaja</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Tekanan Darah</label>
                                <input type="text" class="form-control" name="tekanan_darah" value="<?php echo e($pemeriksaan->tekanan_darah); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Hemoglobin (Hb)</label>
                                <input type="number" step="0.1" class="form-control" name="hemoglobin" value="<?php echo e($pemeriksaan->hemoglobin); ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Lingkar Lengan</label>
                                <input type="number" step="0.1" class="form-control" name="lingkar_lengan" value="<?php echo e($pemeriksaan->lingkar_lengan); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($pasien_type == 'lansia'): ?>
                <div class="card bg-light border-0 mb-3">
                    <div class="card-body">
                        <h6 class="text-primary fw-bold">Parameter Lansia</h6>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Tekanan Darah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="tekanan_darah" value="<?php echo e($pemeriksaan->tekanan_darah); ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Gula Darah</label>
                                <input type="number" class="form-control" name="gula_darah" value="<?php echo e($pemeriksaan->gula_darah); ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Kolesterol</label>
                                <input type="number" class="form-control" name="kolesterol" value="<?php echo e($pemeriksaan->kolesterol); ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Asam Urat</label>
                                <input type="number" step="0.1" class="form-control" name="asam_urat" value="<?php echo e($pemeriksaan->asam_urat); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Diagnosa</label>
                    <textarea class="form-control" name="diagnosa" rows="2"><?php echo e($pemeriksaan->diagnosa); ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tindakan</label>
                    <textarea class="form-control" name="tindakan" rows="2"><?php echo e($pemeriksaan->tindakan); ?></textarea>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-warning px-5"><i class="fas fa-save me-2"></i>Update Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.kader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/pemeriksaan/edit.blade.php ENDPATH**/ ?>