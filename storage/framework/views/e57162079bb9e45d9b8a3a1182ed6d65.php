

<?php $__env->startSection('title', 'Edit Data Remaja'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Data Remaja</h1>
        <p class="text-muted mb-0">Perbarui informasi data remaja</p>
    </div>
    <a href="<?php echo e(route('kader.data.remaja.show', $remaja->id)); ?>" class="btn btn-light text-primary fw-bold shadow-sm rounded-pill px-4">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<form action="<?php echo e(route('kader.data.remaja.update', $remaja->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-md mb-4 rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-warning"><i class="fas fa-edit me-2"></i>Informasi Pribadi</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-lg bg-light border-0" name="nama_lengkap" value="<?php echo e(old('nama_lengkap', $remaja->nama_lengkap)); ?>" required>
                            <?php $__errorArgs = ['nama_lengkap'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">NIK</label>
                            <input type="number" class="form-control bg-light border-0" name="nik" value="<?php echo e(old('nik', $remaja->nik)); ?>" required>
                            <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Jenis Kelamin</label>
                            <select class="form-select bg-light border-0" name="jenis_kelamin" required>
                                <option value="L" <?php echo e(old('jenis_kelamin', $remaja->jenis_kelamin) == 'L' ? 'selected' : ''); ?>>Laki-laki</option>
                                <option value="P" <?php echo e(old('jenis_kelamin', $remaja->jenis_kelamin) == 'P' ? 'selected' : ''); ?>>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Tempat Lahir</label>
                            <input type="text" class="form-control bg-light border-0" name="tempat_lahir" value="<?php echo e(old('tempat_lahir', $remaja->tempat_lahir)); ?>" required>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase text-muted">Tanggal Lahir</label>
                            <input type="date" class="form-control bg-light border-0" id="tanggal_lahir" name="tanggal_lahir" value="<?php echo e(old('tanggal_lahir', $remaja->tanggal_lahir->format('Y-m-d'))); ?>" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase text-muted">Alamat Lengkap</label>
                            <textarea class="form-control bg-light border-0" name="alamat" rows="3" required><?php echo e(old('alamat', $remaja->alamat)); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-md mb-4 rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-info"><i class="fas fa-school me-2"></i>Data Pendidikan</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Nama Sekolah</label>
                        <input type="text" class="form-control bg-light border-0" name="sekolah" value="<?php echo e(old('sekolah', $remaja->sekolah)); ?>" required>
                        <?php $__errorArgs = ['sekolah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Kelas</label>
                        <input type="text" class="form-control bg-light border-0" name="kelas" value="<?php echo e(old('kelas', $remaja->kelas)); ?>" required>
                        <?php $__errorArgs = ['kelas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-md mb-4 rounded-4">
                <div class="card-header bg-white border-bottom-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-secondary"><i class="fas fa-user-friends me-2"></i>Data Orang Tua</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Nama Orang Tua</label>
                        <input type="text" class="form-control bg-light border-0" name="nama_ortu" value="<?php echo e(old('nama_ortu', $remaja->nama_ortu)); ?>">
                        <?php $__errorArgs = ['nama_ortu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Telepon Orang Tua</label>
                        <input type="text" class="form-control bg-light border-0" name="telepon_ortu" value="<?php echo e(old('telepon_ortu', $remaja->telepon_ortu)); ?>">
                        <?php $__errorArgs = ['telepon_ortu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <?php if($orangtua && $orangtua->count() > 0): ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold small text-uppercase text-muted">Akun Pendaftar</label>
                        <select class="form-select bg-light border-0" name="created_by">
                            <option value="">-- Pilih Akun --</option>
                            <?php $__currentLoopData = $orangtua; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ortu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($ortu['id']); ?>" <?php echo e(old('created_by', $remaja->created_by) == $ortu['id'] ? 'selected' : ''); ?>>
                                <?php echo e($ortu['nama']); ?> (<?php echo e($ortu['nik']); ?>)
                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php else: ?>
                    <input type="hidden" name="created_by" value="<?php echo e(Auth::id()); ?>">
                    <?php endif; ?>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-warning text-white rounded-pill py-2 fw-bold shadow-sm">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('tanggal_lahir').max = new Date().toISOString().split('T')[0];
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.kader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/data/remaja/edit.blade.php ENDPATH**/ ?>