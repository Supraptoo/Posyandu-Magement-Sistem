

<?php $__env->startSection('title', 'Laporan Balita'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-baby me-2"></i>Laporan Balita
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
            <form action="<?php echo e(route('kader.laporan.balita')); ?>" method="GET">
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

    <!-- Statistik Card -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Total Balita
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($balitas->count()); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-baby fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Laki-laki
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($balitas->where('jenis_kelamin', 'L')->count()); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-male fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Perempuan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($balitas->where('jenis_kelamin', 'P')->count()); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-female fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Kunjungan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?php echo e($balitas->sum(function($balita) { return $balita->kunjungans->count(); })); ?>

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow">
        <div class="card-header bg-danger text-white">
            <h6 class="m-0 font-weight-bold">
                <i class="fas fa-file-alt me-2"></i>Laporan Data Balita
                <small class="float-end">
                    Periode: <?php echo e(\Carbon\Carbon::parse($start_date)->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::parse($end_date)->format('d/m/Y')); ?>

                </small>
            </h6>
        </div>
        <div class="card-body">
            <?php if($balitas->count() > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-danger">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Balita</th>
                            <th>NIK</th>
                            <th>TTL</th>
                            <th>Usia</th>
                            <th>JK</th>
                            <th>Nama Ibu</th>
                            <th>BB/TB Terakhir</th>
                            <th>Tanggal Kunjungan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $balitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $balita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $usia_bulan = $balita->tanggal_lahir->diffInMonths(now());
                            $usia_tahun = floor($usia_bulan / 12);
                            $sisa_bulan = $usia_bulan % 12;
                            
                            $kunjungan_terakhir = $balita->kunjungans->first();
                            $pemeriksaan_terakhir = $kunjungan_terakhir ? $kunjungan_terakhir->pemeriksaan : null;
                        ?>
                        <tr>
                            <td class="text-center"><?php echo e($index + 1); ?></td>
                            <td><?php echo e($balita->kode_balita); ?></td>
                            <td>
                                <strong><?php echo e($balita->nama_lengkap); ?></strong><br>
                                <small class="text-muted"><?php echo e($balita->nik); ?></small>
                            </td>
                            <td><?php echo e($balita->nik); ?></td>
                            <td>
                                <?php echo e($balita->tempat_lahir); ?>,<br>
                                <?php echo e($balita->tanggal_lahir->format('d/m/Y')); ?>

                            </td>
                            <td class="text-center">
                                <?php if($usia_tahun > 0): ?>
                                    <?php echo e($usia_tahun); ?> thn <?php echo e($sisa_bulan); ?> bln
                                <?php else: ?>
                                    <?php echo e($sisa_bulan); ?> bln
                                <?php endif; ?>
                            </td>
                            <td class="text-center"><?php echo e($balita->jenis_kelamin == 'L' ? 'L' : 'P'); ?></td>
                            <td><?php echo e($balita->nama_ibu); ?></td>
                            <td class="text-center">
                                <?php if($pemeriksaan_terakhir && $pemeriksaan_terakhir->berat_badan && $pemeriksaan_terakhir->tinggi_badan): ?>
                                    <?php echo e($pemeriksaan_terakhir->berat_badan); ?> kg / <?php echo e($pemeriksaan_terakhir->tinggi_badan); ?> cm
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($kunjungan_terakhir): ?>
                                    <?php echo e($kunjungan_terakhir->tanggal_kunjungan->format('d/m/Y')); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Export Options -->
            <div class="mt-4 text-center">
                <form action="<?php echo e(route('kader.laporan.generate', 'balita')); ?>" method="GET" class="d-inline">
                    <input type="hidden" name="start_date" value="<?php echo e($start_date); ?>">
                    <input type="hidden" name="end_date" value="<?php echo e($end_date); ?>">
                    <input type="hidden" name="format" value="pdf">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </button>
                </form>
                
                <form action="<?php echo e(route('kader.laporan.generate', 'balita')); ?>" method="GET" class="d-inline ms-2">
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
                Tidak ada data balita dalam periode yang dipilih.
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Summary Charts -->
    <?php if($balitas->count() > 0): ?>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-pie me-2"></i>Distribusi Usia Balita
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="ageChart" height="150"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar me-2"></i>Distribusi Jenis Kelamin
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="genderChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php $__env->startPush('scripts'); ?>
<?php if($balitas->count() > 0): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Age distribution chart
    const ageGroups = {
        '0-6 bulan': 0,
        '7-12 bulan': 0,
        '1-2 tahun': 0,
        '2-3 tahun': 0,
        '3-4 tahun': 0,
        '4-5 tahun': 0
    };
    
    <?php $__currentLoopData = $balitas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $balita): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $usia_bulan = $balita->tanggal_lahir->diffInMonths(now());
            $usia_tahun = floor($usia_bulan / 12);
        ?>
        
        <?php if($usia_bulan <= 6): ?>
            ageGroups['0-6 bulan']++;
        <?php elseif($usia_bulan <= 12): ?>
            ageGroups['7-12 bulan']++;
        <?php elseif($usia_tahun <= 2): ?>
            ageGroups['1-2 tahun']++;
        <?php elseif($usia_tahun <= 3): ?>
            ageGroups['2-3 tahun']++;
        <?php elseif($usia_tahun <= 4): ?>
            ageGroups['3-4 tahun']++;
        <?php elseif($usia_tahun <= 5): ?>
            ageGroups['4-5 tahun']++;
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    // Age chart
    const ageCtx = document.getElementById('ageChart').getContext('2d');
    new Chart(ageCtx, {
        type: 'pie',
        data: {
            labels: Object.keys(ageGroups),
            datasets: [{
                data: Object.values(ageGroups),
                backgroundColor: ['#e74a3b', '#f6c23e', '#1cc88a', '#36b9cc', '#4e73df', '#6c757d'],
                borderColor: ['#e74a3b', '#f6c23e', '#1cc88a', '#36b9cc', '#4e73df', '#6c757d'],
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
    
    // Gender chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'bar',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                label: 'Jumlah',
                data: [
                    <?php echo e($balitas->where('jenis_kelamin', 'L')->count()); ?>,
                    <?php echo e($balitas->where('jenis_kelamin', 'P')->count()); ?>

                ],
                backgroundColor: ['#4e73df', '#e74a3b'],
                borderColor: ['#4e73df', '#e74a3b'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
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
        background-color: #e74a3b !important;
        -webkit-print-color-adjust: exact;
    }
    .table-danger {
        background-color: #f8d7da !important;
        -webkit-print-color-adjust: exact;
    }
    .btn, .card.shadow {
        display: none;
    }
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.kader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/laporan/balita.blade.php ENDPATH**/ ?>