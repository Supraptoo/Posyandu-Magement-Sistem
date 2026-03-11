<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan_Posyandu_{{ ucfirst($jenis) }}_{{ $periode->format('M_Y') }}</title>
    
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt; 
            color: #000;
            line-height: 1.3;
            margin: 0;
            padding: 0;
        }

        /* Kop Surat */
        .kop-surat {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 2px;
        }
        .kop-surat-inner {
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            margin-bottom: 15px;
        }
        .kop-surat h1 { font-size: 14pt; text-transform: uppercase; font-weight: normal; margin: 0 0 2px 0; }
        .kop-surat h2 { font-size: 18pt; text-transform: uppercase; font-weight: bold; margin: 0 0 4px 0; }
        .kop-surat p { font-size: 11pt; font-style: italic; margin: 0; }

        /* Judul Laporan */
        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
        }
        .judul-laporan h3 { font-size: 14pt; text-decoration: underline; margin: 0 0 5px 0; text-transform: uppercase; }
        .judul-laporan p { font-size: 11pt; font-weight: bold; margin: 0; }

        /* Tabel Ringkasan */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .summary-table td {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
            width: 50%;
        }
        .summary-title {
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
            display: block;
        }

        /* Tabel Data Utama */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 10pt;
        }
        .main-table th, .main-table td {
            border: 1px solid #000;
            padding: 6px 4px;
            vertical-align: top;
        }
        .main-table th {
            background-color: #e5e7eb;
            text-align: center;
            font-weight: bold;
            padding: 8px 4px;
        }

        /* Tabel Tanda Tangan */
        .footer-table {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .footer-table td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
            border: none;
            padding: 0;
        }
        
        .ttd-box {
            height: 80px; /* Ruang untuk tanda tangan */
            margin: 10px 0;
        }
        
        .ttd-img {
            max-height: 75px;
            max-width: 180px;
        }
    </style>
</head>
<body>

    <div class="kop-surat">
        <div class="kop-surat-inner">
            <h1>PEMERINTAH KABUPATEN PEKALONGAN</h1>
            <h2>POSYANDU DESA BANTAR KULON</h2>
            <p>Jalan Raya Utama Bantar Kulon, Kecamatan Lebakbarang, Kab. Pekalongan, Jawa Tengah 51193</p>
        </div>
    </div>

    <div class="judul-laporan">
        <h3>LAPORAN HASIL PEMERIKSAAN KESEHATAN WARGA</h3>
        <p>KATEGORI: {{ strtoupper($judulJenis) }} | PERIODE: {{ strtoupper($periode->translatedFormat('F Y')) }}</p>
    </div>

    <table class="summary-table">
        <tr>
            <td>
                <span class="summary-title">Rekapitulasi Kunjungan</span>
                <table width="100%" style="border: none;">
                    <tr><td style="border: none; padding: 2px;">Total Diperiksa: {{ $stats['total'] }} Pasien</td><td style="border: none; padding: 2px;">Remaja: {{ $stats['remaja'] }} Orang</td></tr>
                    <tr><td style="border: none; padding: 2px;">Balita: {{ $stats['balita'] }} Anak</td><td style="border: none; padding: 2px;">Lansia: {{ $stats['lansia'] }} Orang</td></tr>
                </table>
            </td>
            <td>
                <span class="summary-title">Indikator Klinis Kritis</span>
                <table width="100%" style="border: none;">
                    <tr><td style="border: none; padding: 2px;">Kondisi Normal: {{ $stats['normal'] }} Pasien</td><td style="border: none; padding: 2px;">Risiko Obesitas: {{ $stats['obesitas'] }} Pasien</td></tr>
                    <tr><td style="border: none; padding: 2px;">Risiko Stunting: {{ $stats['stunting'] }} Anak</td><td style="border: none; padding: 2px;">Kasus Hipertensi: {{ $stats['hipertensi'] }} Lansia</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 3%;">No.</th>
                <th style="width: 9%;">Tgl Periksa</th>
                <th style="width: 17%;">Nama Pasien</th>
                @if($jenis == 'semua') <th style="width: 8%;">Kategori</th> @endif
                <th style="width: 13%;">Hasil Fisik</th>
                <th style="width: 10%;">Status Klinis</th>
                <th style="width: 20%;">Diagnosa Bidan</th>
                <th style="width: 20%;">Tindakan / Resep</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pemeriksaans as $i => $item)
            <tr>
                <td style="text-align: center;">{{ $i + 1 }}</td>
                <td style="text-align: center;">{{ $item->tanggal_periksa?->format('d/m/Y') }}</td>
                <td><strong>{{ $item->nama_pasien }}</strong></td>
                @if($jenis == 'semua') <td style="text-align: center; text-transform: capitalize;">{{ $item->kategori_pasien }}</td> @endif
                <td>
                    BB: {{ $item->berat_badan ?? '-' }} kg<br>
                    TB: {{ $item->tinggi_badan ?? '-' }} cm
                    @if($item->tekanan_darah) <br>TD: {{ $item->tekanan_darah }} @endif
                </td>
                <td style="text-align: center; text-transform: uppercase;">{{ $item->status_gizi ?? '-' }}</td>
                <td>{{ $item->diagnosa ?? '-' }}</td>
                <td>{{ $item->tindakan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ $jenis == 'semua' ? '8' : '7' }}" style="text-align: center; padding: 20px; font-style: italic;">
                    Belum ada riwayat pemeriksaan yang telah diverifikasi pada periode ini.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table class="footer-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Kepala Desa Bantar Kulon</strong><br>
                <div class="ttd-box">
                    @php
                        $kadesPath = public_path('uploads/ttd/ttd_kades.png');
                    @endphp
                    @if(file_exists($kadesPath))
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($kadesPath)) }}" class="ttd-img">
                    @endif
                </div>
                <span style="text-decoration: underline; font-weight: bold;">( .......................................... )</span><br>
                NIP. ........................................
            </td>
            <td>
                Kajen, {{ now()->translatedFormat('d F Y') }}<br>
                <strong>Bidan Desa / Validator Medis</strong><br>
                <div class="ttd-box">
                    @php
                        $bidanPath = public_path('uploads/ttd/ttd_bidan.png');
                    @endphp
                    @if(file_exists($bidanPath))
                        <img src="data:image/png;base64,{{ base64_encode(file_get_contents($bidanPath)) }}" class="ttd-img">
                    @endif
                </div>
                <span style="text-decoration: underline; font-weight: bold;">( {{ Auth::user()->name ?? 'Bidan Posyandu' }} )</span><br>
                NIP. ........................................
            </td>
        </tr>
    </table>

</body>
</html>