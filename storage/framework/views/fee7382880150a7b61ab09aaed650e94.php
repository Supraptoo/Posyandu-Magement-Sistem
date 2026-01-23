<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Data Remaja - Desa Bantar Kulon</title>
    <style>
        @page { size: A4 landscape; margin: 2.5cm; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; background: #fff; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .kop-surat { width: 100%; border-bottom: 4px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo-placeholder { width: 80px; height: 80px; display: block; margin: 0 auto; }
        .kop-teks h3 { margin: 0; font-size: 14pt; font-weight: normal; }
        .kop-teks h2 { margin: 0; font-size: 16pt; font-weight: bold; }
        .kop-teks p { margin: 0; font-size: 10pt; font-style: italic; }
        .meta-surat { width: 100%; margin-bottom: 20px; border: none; }
        .meta-surat td { padding: 2px 0; vertical-align: top; }
        .main-table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px; font-size: 11pt; }
        .main-table th { border: 1px solid #000; background-color: #f0f0f0; padding: 8px; text-align: center; vertical-align: middle; font-weight: bold; }
        .main-table td { border: 1px solid #000; padding: 6px 8px; vertical-align: top; }
        .signature-section { margin-top: 50px; width: 100%; page-break-inside: avoid; }
        .signature-box { width: 250px; text-align: center; float: right; }
    </style>
</head>
<body>
    <table class="kop-surat">
        <tr>
            <td width="15%" class="text-center"><img src="https://via.placeholder.com/80x80.png?text=LOGO" alt="Logo" class="logo-placeholder"></td>
            <td width="85%" class="text-center kop-teks">
                <h3 class="uppercase">Pemerintah Kabupaten [Nama Kabupaten]</h3>
                <h3 class="uppercase">Kecamatan [Nama Kecamatan]</h3>
                <h2 class="uppercase">PEMERINTAH DESA BANTAR KULON</h2>
                <p>Alamat: Jl. Raya Bantar Kulon No. 123, Kode Pos 45xxx</p>
            </td>
        </tr>
    </table>

    <table class="meta-surat">
        <tr>
            <td width="15%">Nomor</td><td width="2%">:</td><td width="43%">440 / ... / Ds.Btr / <?php echo e(date('Y')); ?></td>
            <td width="40%" class="text-right">Bantar Kulon, <?php echo e(date('d F Y')); ?></td>
        </tr>
        <tr><td>Lampiran</td><td>:</td><td>1 (Satu) Berkas</td><td></td></tr>
        <tr><td>Perihal</td><td>:</td><td class="text-bold">Laporan Data Kesehatan Remaja</td><td></td></tr>
    </table>

    <div style="margin-bottom: 20px;">
        Kepada Yth,<br><strong>Kepala Desa Bantar Kulon</strong><br>di Tempat
    </div>

    <div style="text-align: justify; margin-bottom: 15px;">
        <p style="text-indent: 30px;">Berikut kami sampaikan Laporan Data Remaja Posyandu Desa Bantar Kulon periode <?php echo e(\Carbon\Carbon::parse($start_date)->translatedFormat('d F Y')); ?> s/d <?php echo e(\Carbon\Carbon::parse($end_date)->translatedFormat('d F Y')); ?>.</p>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Remaja</th>
                <th width="15%">NIK</th>
                <th width="5%">L/P</th>
                <th width="5%">Usia</th>
                <th width="20%">Sekolah</th>
                <th width="10%">Kelas</th>
                <th width="20%">Orang Tua</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $remajas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $remaja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td><?php echo e($remaja->nama_lengkap); ?></td>
                <td class="text-center"><?php echo e($remaja->nik); ?></td>
                <td class="text-center"><?php echo e($remaja->jenis_kelamin); ?></td>
                <td class="text-center"><?php echo e($remaja->tanggal_lahir->age); ?></td>
                <td><?php echo e($remaja->sekolah); ?></td>
                <td class="text-center"><?php echo e($remaja->kelas); ?></td>
                <td><?php echo e($remaja->nama_ortu ?? '-'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($remajas->isEmpty()): ?>
            <tr><td colspan="8" class="text-center">Tidak ada data remaja pada periode ini.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="signature-section">
        <div class="signature-box">
            Mengetahui,<br>Ketua Posyandu Remaja
            <br><br><br><br><br> <span class="text-bold" style="text-decoration: underline;">[NAMA KADER]</span>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/laporan/remaja.blade.php ENDPATH**/ ?>