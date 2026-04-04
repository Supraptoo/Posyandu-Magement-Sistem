<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Medis {{ $periode->format('M Y') }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 11px; margin: 0; padding: 20px; }
        
        /* Kop Surat */
        .kop-surat { width: 100%; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center; }
        .kop-surat h1 { margin: 0; font-size: 20px; color: #0284c7; text-transform: uppercase; letter-spacing: 1px; }
        .kop-surat h2 { margin: 5px 0 0 0; font-size: 14px; font-weight: normal; color: #555; }
        .kop-surat p { margin: 5px 0 0 0; font-size: 10px; color: #777; }
        
        /* Judul Laporan */
        .judul-laporan { text-align: center; margin-bottom: 20px; }
        .judul-laporan h3 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .judul-laporan p { margin: 5px 0 0 0; font-weight: bold; color: #0284c7; }

        /* Tabel Utama */
        table.data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table.data-table th, table.data-table td { border: 1px solid #cbd5e1; padding: 8px 6px; text-align: left; vertical-align: top; }
        table.data-table th { background-color: #f1f5f9; font-weight: bold; font-size: 10px; text-transform: uppercase; text-align: center; }
        table.data-table tbody tr:nth-child(even) { background-color: #f8fafc; }
        
        .text-center { text-align: center !important; }
        .badge-alert { color: #e11d48; font-weight: bold; }

        /* Footer Tanda Tangan */
        .footer-ttd { width: 100%; margin-top: 40px; }
        .ttd-box { float: right; width: 250px; text-align: center; }
        .ttd-box p { margin: 0 0 5px 0; }
        .ttd-space { height: 70px; }
        .ttd-nama { font-weight: bold; text-decoration: underline; margin-bottom: 2px; }
        
        /* Utility */
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h1>SISTEM INFORMASI POSYANDU TERPADU</h1>
        <h2>Pusat Pelayanan Kesehatan Ibu, Anak, dan Lansia Tingkat Desa</h2>
        <p>Laporan Resmi Dicetak Oleh Sistem MedisCare | Tanggal Cetak: {{ now()->translatedFormat('d F Y H:i') }}</p>
    </div>

    <div class="judul-laporan">
        <h3>REKAPITULASI HASIL PELAYANAN KLINIS</h3>
        <p>Kategori: {{ strtoupper($judulJenis) }} | Periode: {{ $periode->translatedFormat('F Y') }}</p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="10%">Tanggal</th>
                <th width="15%">Nama Pasien</th>
                <th width="8%">Kategori</th>
                <th width="20%">Hasil Ukur Fisik (Antropometri)</th>
                <th width="24%">Diagnosa Bidan</th>
                <th width="20%">Tindakan / Resep</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemeriksaans as $index => $pem)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($pem->tanggal_periksa)->format('d/m/Y') }}</td>
                <td>
                    <strong>{{ $pem->balita->nama_lengkap ?? $pem->remaja->nama_lengkap ?? $pem->lansia->nama_lengkap ?? 'Ibu Hamil' }}</strong>
                </td>
                <td class="text-center">{{ ucfirst(str_replace('_', ' ', $pem->kategori_pasien)) }}</td>
                <td>
                    BB: {{ $pem->berat_badan ?? '-' }} kg<br>
                    TB: {{ $pem->tinggi_badan ?? '-' }} cm<br>
                    @if($pem->tekanan_darah)
                        Tensi: <span class="{{ intval(explode('/', $pem->tekanan_darah)[0]) >= 140 ? 'badge-alert' : '' }}">{{ $pem->tekanan_darah }}</span><br>
                    @endif
                    @if($pem->status_gizi)
                        Gizi: <span class="{{ in_array(strtolower($pem->status_gizi), ['stunting', 'buruk']) ? 'badge-alert' : '' }}">{{ $pem->status_gizi }}</span>
                    @endif
                </td>
                <td>{{ $pem->diagnosa ?? '-' }}</td>
                <td>{{ $pem->tindakan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px;">Tidak ada data pemeriksaan yang tervalidasi pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-ttd clearfix">
        <div class="ttd-box">
            <p>Mengetahui & Memvalidasi,</p>
            <p>Bidan Desa Pemeriksa</p>
            <div class="ttd-space"></div>
            <p class="ttd-nama">{{ Auth::user()->name ?? 'Bidan Posyandu' }}</p>
            <p>Sistem NIP/NRP. ......................</p>
        </div>
    </div>

</body>
</html>