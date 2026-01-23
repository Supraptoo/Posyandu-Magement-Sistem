<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Remaja - <?php echo e($start_date); ?> s/d <?php echo e($end_date); ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        
        .header h2 {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #666;
        }
        
        .info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        
        .info table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .info td {
            padding: 5px;
            vertical-align: top;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .table th {
            background-color: #6c757d;
            color: white;
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
            font-weight: bold;
        }
        
        .table td {
            padding: 6px;
            border: 1px solid #ddd;
        }
        
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            border-top: 1px solid #333;
            padding-top: 10px;
            font-size: 11px;
            color: #666;
        }
        
        .summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        
        .summary h4 {
            margin-top: 0;
            color: #333;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DATA REMAJA</h1>
        <h2>Posyandu Sehat Bahagia</h2>
        <p>Periode: <?php echo e(\Carbon\Carbon::parse($start_date)->format('d/m/Y')); ?> - <?php echo e(\Carbon\Carbon::parse($end_date)->format('d/m/Y')); ?></p>
    </div>
    
    <div class="info">
        <table>
            <tr>
                <td width="30%">
                    <strong>Tanggal Cetak:</strong><br>
                    <?php echo e($tanggal_cetak->format('d/m/Y H:i')); ?>

                </td>
                <td width="40%">
                    <strong>Total Data:</strong><br>
                    <?php echo e($data->count()); ?> Remaja
                </td>
                <td width="30%">
                    <strong>Jenis Kelamin:</strong><br>
                    Laki-laki: <?php echo e($data->where('jenis_kelamin', 'L')->count()); ?><br>
                    Perempuan: <?php echo e($data->where('jenis_kelamin', 'P')->count()); ?>

                </td>
            </tr>
        </table>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Remaja</th>
                <th>NIK</th>
                <th>TTL</th>
                <th>Usia</th>
                <th>Jenis Kelamin</th>
                <th>Sekolah</th>
                <th>Kelas</th>
                <th>Orang Tua</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $remaja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $usia_tahun = $remaja->tanggal_lahir->diffInYears(now());
            ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td><?php echo e($remaja->kode_remaja); ?></td>
                <td><?php echo e($remaja->nama_lengkap); ?></td>
                <td><?php echo e($remaja->nik); ?></td>
                <td>
                    <?php echo e($remaja->tempat_lahir); ?>,<br>
                    <?php echo e($remaja->tanggal_lahir->format('d/m/Y')); ?>

                </td>
                <td class="text-center"><?php echo e($usia_tahun); ?> tahun</td>
                <td class="text-center"><?php echo e($remaja->jenis_kelamin == 'L' ? 'L' : 'P'); ?></td>
                <td><?php echo e($remaja->sekolah); ?></td>
                <td class="text-center"><?php echo e($remaja->kelas); ?></td>
                <td><?php echo e($remaja->nama_ortu ?? '-'); ?></td>
                <td><?php echo e(Str::limit($remaja->alamat, 50)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    
    <div class="summary">
        <h4>STATISTIK DISTRIBUSI USIA</h4>
        <table>
            <tr>
                <td width="25%">10-12 tahun</td>
                <td width="25%">: <?php echo e($data->filter(fn($r) => $r->tanggal_lahir->diffInYears(now()) >= 10 && $r->tanggal_lahir->diffInYears(now()) <= 12)->count()); ?> remaja</td>
                <td width="25%">13-15 tahun</td>
                <td width="25%">: <?php echo e($data->filter(fn($r) => $r->tanggal_lahir->diffInYears(now()) >= 13 && $r->tanggal_lahir->diffInYears(now()) <= 15)->count()); ?> remaja</td>
            </tr>
            <tr>
                <td>16-18 tahun</td>
                <td>: <?php echo e($data->filter(fn($r) => $r->tanggal_lahir->diffInYears(now()) >= 16 && $r->tanggal_lahir->diffInYears(now()) <= 18)->count()); ?> remaja</td>
                <td>19 tahun ke atas</td>
                <td>: <?php echo e($data->filter(fn($r) => $r->tanggal_lahir->diffInYears(now()) >= 19)->count()); ?> remaja</td>
            </tr>
        </table>
    </div>
    
    <div class="footer">
        <p>Laporan ini dicetak secara otomatis oleh Sistem Informasi Posyandu</p>
        <p>&copy; <?php echo e(date('Y')); ?> Posyandu Sehat Bahagia. Semua hak dilindungi.</p>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/laporan/pdf/remaja.blade.php ENDPATH**/ ?>