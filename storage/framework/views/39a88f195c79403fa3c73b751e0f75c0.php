<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Data Dasar Posyandu - Desa Bantar Kulon</title>
    <style>
        /* PENGATURAN HALAMAN CETAK (A4) */
        @page {
            size: A4;
            margin: 2.5cm 2.5cm 2.5cm 2.5cm; /* Margin standar surat resmi */
        }

        body {
            font-family: 'Times New Roman', Times, serif; /* Font standar surat dinas */
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            background: #fff;
        }

        /* HELPER CLASSES */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .no-margin { margin: 0; }
        
        /* KOP SURAT */
        .kop-surat {
            width: 100%;
            border-bottom: 4px double #000; /* Garis ganda tebal tipis */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .kop-surat td {
            vertical-align: middle;
        }
        .logo-placeholder {
            width: 80px;
            height: 80px;
            display: block;
            margin: 0 auto;
        }
        .kop-teks h3 { margin: 0; font-size: 14pt; font-weight: normal; }
        .kop-teks h2 { margin: 0; font-size: 16pt; font-weight: bold; }
        .kop-teks p { margin: 0; font-size: 10pt; font-style: italic; }

        /* META SURAT (Nomor, Lampiran, dll) */
        .meta-surat {
            width: 100%;
            margin-bottom: 20px;
            border: none;
        }
        .meta-surat td {
            padding: 2px 0;
            vertical-align: top;
        }

        /* TABEL UTAMA */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
            font-size: 11pt; /* Font tabel sedikit lebih kecil agar muat */
        }
        .main-table th {
            border: 1px solid #000;
            background-color: #f0f0f0; /* Abu-abu muda untuk header */
            padding: 8px;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
        }
        .main-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: top;
        }

        /* BAGIAN PENJELASAN */
        .keterangan-box {
            font-size: 11pt;
            margin-top: 10px;
            text-align: justify;
        }
        .keterangan-title {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
            font-size: 12pt;
        }
        .list-ket {
            list-style-type: none;
            padding-left: 0;
            margin: 0;
        }
        .list-ket li {
            margin-bottom: 8px;
            padding-left: 15px;
            text-indent: -15px;
        }

        /* TANDA TANGAN */
        .signature-section {
            margin-top: 50px;
            width: 100%;
            page-break-inside: avoid; /* Jangan potong tanda tangan ke halaman baru */
        }
        .signature-box {
            width: 250px;
            text-align: center;
            float: right;
        }
    </style>
</head>
<body>

    <table class="kop-surat">
        <tr>
            <td width="15%" class="text-center">
                <img src="https://via.placeholder.com/80x80.png?text=LOGO" alt="Logo" class="logo-placeholder">
            </td>
            <td width="85%" class="text-center kop-teks">
                <h3 class="uppercase">Pemerintah Kabupaten [Nama Kabupaten]</h3>
                <h3 class="uppercase">Kecamatan [Nama Kecamatan]</h3>
                <h2 class="uppercase">PEMERINTAH DESA BANTAR KULON</h2>
                <p>Alamat: Jl. Raya Bantar Kulon No. 123, Kode Pos 45xxx</p>
                <p>Email: desabantarkulon@email.com | Telp: (02xx) 123456</p>
            </td>
        </tr>
    </table>

    <table class="meta-surat">
        <tr>
            <td width="15%">Nomor</td>
            <td width="2%">:</td>
            <td width="43%">440 / 056 / Ds.Btr / <?php echo e(date('Y')); ?></td>
            <td width="40%" class="text-right">Bantar Kulon, <?php echo e(date('d F Y')); ?></td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td>1 (Satu) Berkas</td>
            <td></td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td class="text-bold">Laporan Data Dasar Posyandu</td>
            <td></td>
        </tr>
    </table>

    <div style="margin-bottom: 20px;">
        Kepada Yth,<br>
        <strong>Kepala UPTD Puskesmas [Nama Kecamatan]</strong><br>
        di<br>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tempat
    </div>

    <div style="text-align: justify; margin-bottom: 15px;">
        <p>Dengan hormat,</p>
        <p style="text-indent: 30px;">
            Bersama surat ini, Pemerintah Desa Bantar Kulon menyampaikan Laporan Data Dasar Posyandu Semester <?php echo e(date('n') <= 6 ? 'I (Ganjil)' : 'II (Genap)'); ?> Tahun <?php echo e(date('Y')); ?>. Data ini disusun berdasarkan hasil monitoring dan evaluasi kader di lapangan untuk keperluan pemutakhiran data kesehatan masyarakat.
        </p>
    </div>

    <div class="text-center text-bold" style="margin-bottom: 10px;">DATA INVENTARIS POSYANDU DESA BANTAR KULON</div>
    
    <table class="main-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Nama Posyandu</th>
                <th width="20%">Wilayah Kerja</th>
                <th width="10%">Strata</th>
                <th width="15%">Sasaran</th>
                <th width="10%">Jadwal Buka</th>
                <th width="10%">Jml Kader</th>
                <th width="10%">Gedung</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td class="text-bold">Posyandu Melati I</td>
                <td>Dusun I (RW 01, RW 02)</td>
                <td class="text-center">Purnama</td>
                <td>Balita & Bumil</td>
                <td class="text-center">Tgl 05</td>
                <td class="text-center">5</td>
                <td>Milik Sendiri</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td class="text-bold">Posyandu Melati II</td>
                <td>Dusun II (RW 03, RW 04)</td>
                <td class="text-center">Purnama</td>
                <td>Balita & Bumil</td>
                <td class="text-center">Tgl 07</td>
                <td class="text-center">5</td>
                <td>Rumah Warga</td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td class="text-bold">Posyandu Cempaka</td>
                <td>Dusun III (RW 05)</td>
                <td class="text-center">Madya</td>
                <td>Balita & Bumil</td>
                <td class="text-center">Tgl 10</td>
                <td class="text-center">4</td>
                <td>Gedung RW</td>
            </tr>
            <tr>
                <td class="text-center">4</td>
                <td class="text-bold">Posyandu Kenanga</td>
                <td>Dusun IV (RW 06)</td>
                <td class="text-center">Mandiri</td>
                <td>Integrasi PAUD</td>
                <td class="text-center">Tgl 12</td>
                <td class="text-center">6</td>
                <td>Milik Sendiri</td>
            </tr>
            <tr>
                <td class="text-center">5</td>
                <td class="text-bold">Posyandu Lansia</td>
                <td>Seluruh Dusun</td>
                <td class="text-center">Purnama</td>
                <td>Lanjut Usia</td>
                <td class="text-center">Tgl 15</td>
                <td class="text-center">4</td>
                <td>Aula Desa</td>
            </tr>
            <tr>
                <td class="text-center">6</td>
                <td class="text-bold">Posyandu Remaja</td>
                <td>Seluruh Dusun</td>
                <td class="text-center">Pratama</td>
                <td>Remaja 10-18th</td>
                <td class="text-center">Minggu 3</td>
                <td class="text-center">3</td>
                <td>Sekretariat</td>
            </tr>
        </tbody>
    </table>

    <div class="keterangan-box">
        <div class="keterangan-title">Keterangan & Penjelasan Strata:</div>
        <ul class="list-ket">
            <li><strong>Pratama:</strong> Belum rutin beroperasi, jumlah kader terbatas (< 5 orang).</li>
            <li><strong>Madya:</strong> Sudah rutin bulanan, namun cakupan program utama masih rendah (< 50%).</li>
            <li><strong>Purnama:</strong> Rutin, administrasi tertib, cakupan > 50%, ada program tambahan.</li>
            <li><strong>Mandiri:</strong> Rutin, cakupan tinggi, swadaya masyarakat (Dana Sehat) > 50% KK.</li>
        </ul>
        <br>
        <p style="text-indent: 30px; margin: 0;">
            Demikian laporan ini kami sampaikan untuk menjadi bahan periksa. Atas perhatian dan kerjasamanya kami ucapkan terima kasih.
        </p>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            Mengetahui,<br>
            Kepala Desa Bantar Kulon
            <br><br><br><br><br> <span class="text-bold" style="text-decoration: underline;">[NAMA KEPALA DESA]</span><br>
            NIAP. ..............................
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html><?php /**PATH C:\xampp\htdocs\POSYANDU\posyandu-management-system\resources\views/kader/laporan/pdf/balita.blade.php ENDPATH**/ ?>