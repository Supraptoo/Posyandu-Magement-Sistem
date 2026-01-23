

<?php $__env->startSection('title', 'Laporan Imunisasi'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-syringe me-2"></i>Laporan Imunisasi
        </h1>
        <div>
            <button class="btn btn-success" onclick="window.print()">
                <i class="fas fa-print me-2"></i>Cetak
            </button>
        </div>
    </div>

    <!-- Filter -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?php echo e(route('kader.laporan.imunisasi')); ?>" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" 
                                   value="<?php echo e($start_date); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" 
                                   value="<?php echo e($end_date); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-grid gap-2" style="margin-top: 32px">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter me-2"></i>Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-file-alt me-2"></i>Laporan Imunisasi
                <small class="float-end">
                    Periode: <?php echo e(\Carbon\Carbon::parse($start_date)->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::parse($end_date)->format('d/m/Y')); ?>

                </small>
            </h6>
        </div>
        <div class="card-body">
            <?php if($imunisasis->count() > 0): ?>
                <?php $__currentLoopData = $imunisasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis => $data_imunisasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <h5 class="mb-3 text-success"><?php echo e($jenis); ?> (<?php echo e($data_imunisasi->count()); ?> data)</h5>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered">
                        <thead class="table-success">
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Imunisasi</th>
                                <th>Vaksin</th>
                                <th>Dosis</th>
                                <th>Batch Number</th>
                                <th>Expiry Date</th>
                                <th>Penyelenggara</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data_imunisasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $imunisasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <strong><?php echo e($imunisasi->kunjungan->pasien->nama_lengkap ?? '-'); ?></strong><br>
                                    <small class="text-muted">
                                        <?php if($imunisasi->kunjungan->pasien_type == 'App\Models\Balita'): ?>
                                            Balita
                                        <?php else: ?>
                                            Bayi
                                        <?php endif; ?>
                                    </small>
                                </td>
                                <td class="text-center"><?php echo e($imunisasi->tanggal_imunisasi->format('d/m/Y')); ?></td>
                                <td><?php echo e($imunisasi->vaksin); ?></td>
                                <td class="text-center"><?php echo e($imunisasi->dosis); ?></td>
                                <td><?php echo e($imunisasi->batch_number); ?></td>
                                <td class="text-center"><?php echo e($imunisasi->expiry_date->format('d/m/Y')); ?></td>
                                <td><?php echo e($imunisasi->penyelenggara); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            
            <!-- Export Options -->
            <div class="mt-4 text-center">
                <form action="<?php echo e(route('kader.laporan.generate', 'imunisasi')); ?>" method="GET" class="d-inline">
                    <input type="hidden" name="start_date" value="<?php echo e($start_date); ?>">
                    <input type="hidden" name="end_date" value="<?php echo e($end_date); ?>">
                    <input type="hidden" name="format" value="pdf">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </button>
                </form>
                
                <form action="<?php echo e(route('kader.laporan.generate', 'imunisasi')); ?>" method="GET" class="d-inline ms-2">
                    <input type="hidden" name="start_date" value="<?php echo e($start_date); ?>">
                    <input type="hidden" name="end_date" value="<?php echo e($end_date); ?>">
                    <input type="hidden" name="format" value="excel">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-file-excel me-2"></i>Export Excel
                    </button>
                </form>
            </div>
            <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>
                Tidak ada data imunisasi dalam periode yang dipilih.
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Summary -->
    <?php if($imunisasis->count() > 0): ?>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar me-2"></i>Statistik
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h2 class="font-weight-bold text-success">
                            <?php
                                $total_imunisasi = 0;
                                foreach($imunisasis as $jenis => $data) {
                                    $total_imunisasi += $data->count();
                                }
                            ?>
                            <?php echo e($total_imunisasi); ?>

                        </h2>
                        <p class="text-muted">Total Imunisasi</p>
                    </div>
                    <div class="mt-3">
                        <?php $__currentLoopData = $imunisasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis => $data_imunisasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p><i class="fas fa-syringe text-success me-2"></i> <?php echo e($jenis); ?>: 
                            <?php echo e($data_imunisasi->count()); ?>

                        </p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-pie me-2"></i>Distribusi Jenis Imunisasi
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="imunisasiChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<?php if($imunisasis->count() > 0): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Imunisasi distribution chart
    const jenisLabels = [];
    const jenisData = [];
    const jenisColors = ['#1cc88a', '#36b9cc', '#4e73df', '#f6c23e', '#e74a3b', '#fd7e14'];
    
    <?php $__currentLoopData = $imunisasis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis => $data_imunisasi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        jenisLabels.push('<?php echo e($jenis); ?>');
        jenisData.push(<?php echo e($data_imunisasi->count()); ?>);
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    const ctx = document.getElementById('imunisasiChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: jenisLabels,
            datasets: [{
                data: jenisData,
                backgroundColor: jenisColors,
                borderColor: jenisColors.map(color => color.replace('0.8', '1')),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                }
            }
        }
    });
});
</script>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<style>
@media print {
    .card-header {
        background-color: #1cc88a !important;
        -webkit-print-color-adjust: exact;
    }
    .table-success {
        background-color: #d4edda !important;
        -webkit-print-color-adjust: exact;
    }
    .btn, .card.shadow {
        display: none;
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.kader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/laporan/imunisasi.blade.php ENDPATH**/ ?>