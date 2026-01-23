

<?php $__env->startSection('title', 'Tambah Pemeriksaan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-plus-circle me-2"></i>Tambah Pemeriksaan</h1>
        <a href="<?php echo e(route('kader.pemeriksaan.index')); ?>" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h6 class="m-0 font-weight-bold"><i class="fas fa-stethoscope me-2"></i>Formulir Pemeriksaan</h6>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('kader.pemeriksaan.store')); ?>" method="POST" id="pemeriksaanForm">
                <?php echo csrf_field(); ?>
                
                <div class="mb-4 border-bottom pb-4">
                    <h5 class="text-primary mb-3">1. Identitas Pasien</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Jenis Pasien</label>
                            <select class="form-select" name="pasien_type" id="pasien_type" onchange="changeFormType(this.value)" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="balita" <?php echo e((old('pasien_type') ?? $pasien_type) == 'balita' ? 'selected' : ''); ?>>Balita</option>
                                <option value="remaja" <?php echo e((old('pasien_type') ?? $pasien_type) == 'remaja' ? 'selected' : ''); ?>>Remaja</option>
                                <option value="lansia" <?php echo e((old('pasien_type') ?? $pasien_type) == 'lansia' ? 'selected' : ''); ?>>Lansia</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Nama Pasien</label>
                            <select class="form-select pasien-select" name="pasien_id" id="select_balita" style="display:none;">
                                <option value="">-- Cari Balita --</option>
                                <?php $__currentLoopData = $balitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($p->id); ?>" <?php echo e((old('pasien_id') ?? $pasien->id ?? '') == $p->id ? 'selected' : ''); ?>>
                                        <?php echo e($p->nama_lengkap); ?> (<?php echo e($p->nik); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select class="form-select pasien-select" name="pasien_id" id="select_remaja" style="display:none;">
                                <option value="">-- Cari Remaja --</option>
                                <?php $__currentLoopData = $remajas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($p->id); ?>" <?php echo e((old('pasien_id') ?? $pasien->id ?? '') == $p->id ? 'selected' : ''); ?>>
                                        <?php echo e($p->nama_lengkap); ?> (<?php echo e($p->nik); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <select class="form-select pasien-select" name="pasien_id" id="select_lansia" style="display:none;">
                                <option value="">-- Cari Lansia --</option>
                                <?php $__currentLoopData = $lansias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($p->id); ?>" <?php echo e((old('pasien_id') ?? $pasien->id ?? '') == $p->id ? 'selected' : ''); ?>>
                                        <?php echo e($p->nama_lengkap); ?> (<?php echo e($p->nik); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-4 border-bottom pb-4">
                    <h5 class="text-primary mb-3">2. Data Kunjungan</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Kunjungan</label>
                            <input type="date" class="form-control" name="tanggal_kunjungan" value="<?php echo e(date('Y-m-d')); ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jenis Layanan</label>
                            <select class="form-select" name="jenis_kunjungan" required>
                                <option value="pemeriksaan">Pemeriksaan Kesehatan</option>
                                <option value="imunisasi">Imunisasi</option>
                                <option value="konsultasi">Konsultasi</option>
                                <option value="umum">Kunjungan Umum</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Keluhan</label>
                            <input type="text" class="form-control" name="keluhan" placeholder="Contoh: Demam, Batuk, Pusing">
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="text-primary mb-3">3. Hasil Pemeriksaan</h5>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Berat Badan (kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="berat_badan" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tinggi Badan (cm) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="tinggi_badan" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Suhu Tubuh (°C)</label>
                            <input type="number" step="0.1" class="form-control" name="suhu_tubuh">
                        </div>
                    </div>

                    <div id="fields_balita" class="specific-fields" style="display:none;">
                        <div class="alert alert-info py-2"><small><i class="fas fa-baby me-1"></i> Parameter Khusus Balita</small></div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Lingkar Kepala (cm)</label>
                                <input type="number" step="0.1" class="form-control" name="lingkar_kepala">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Lingkar Lengan (cm)</label>
                                <input type="number" step="0.1" class="form-control" name="lingkar_lengan">
                            </div>
                        </div>
                    </div>

                    <div id="fields_remaja" class="specific-fields" style="display:none;">
                        <div class="alert alert-info py-2"><small><i class="fas fa-child me-1"></i> Parameter Khusus Remaja</small></div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label">Tekanan Darah (mmHg)</label>
                                <input type="text" class="form-control" name="tekanan_darah" placeholder="110/70">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Hemoglobin (Hb)</label>
                                <input type="number" step="0.1" class="form-control" name="hemoglobin" placeholder="g/dL">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Lingkar Lengan (cm)</label>
                                <input type="number" step="0.1" class="form-control" name="lingkar_lengan">
                            </div>
                        </div>
                    </div>

                    <div id="fields_lansia" class="specific-fields" style="display:none;">
                        <div class="alert alert-warning py-2"><small><i class="fas fa-user-clock me-1"></i> Parameter Khusus Lansia (Wajib Tensi)</small></div>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Tekanan Darah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="tekanan_darah" placeholder="130/80">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Gula Darah (mg/dL)</label>
                                <input type="number" class="form-control" name="gula_darah">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Kolesterol (mg/dL)</label>
                                <input type="number" class="form-control" name="kolesterol">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Asam Urat (mg/dL)</label>
                                <input type="number" step="0.1" class="form-control" name="asam_urat">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4 border-top pt-4">
                    <h5 class="text-primary mb-3">4. Kesimpulan & Saran</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Diagnosa / Hasil</label>
                            <textarea class="form-control" name="diagnosa" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tindakan / Pemberian Obat</label>
                            <textarea class="form-control" name="tindakan" rows="2"></textarea>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="reset" class="btn btn-light me-md-2">Reset</button>
                    <button type="submit" class="btn btn-primary px-5"><i class="fas fa-save me-2"></i>Simpan Hasil Pemeriksaan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function changeFormType(type) {
        // 1. Reset semua dropdown pasien
        document.querySelectorAll('.pasien-select').forEach(el => {
            el.style.display = 'none';
            el.disabled = true;
        });

        // 2. Reset semua field khusus
        document.querySelectorAll('.specific-fields').forEach(el => el.style.display = 'none');

        // 3. Tampilkan dropdown yang sesuai
        if (type) {
            let selectId = 'select_' + type;
            let selectEl = document.getElementById(selectId);
            if(selectEl) {
                selectEl.style.display = 'block';
                selectEl.disabled = false;
            }

            // 4. Tampilkan field khusus yang sesuai
            let fieldId = 'fields_' + type;
            let fieldEl = document.getElementById(fieldId);
            if(fieldEl) {
                fieldEl.style.display = 'block';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        let currentType = document.getElementById('pasien_type').value;
        if(currentType) {
            changeFormType(currentType);
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.kader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/pemeriksaan/create.blade.php ENDPATH**/ ?>