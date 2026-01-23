<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kunjungan - {{ $start_date }} s/d {{ $end_date }}</title>
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
            background-color: #36b9cc;
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
        
        .stats-box {
            display: inline-block;
            width: 48%;
            margin: 1%;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KUNJUNGAN POSYANDU</h1>
        <h2>Posyandu Sehat Bahagia</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}</p>
    </div>
    
    <div class="info">
        <table>
            <tr>
                <td width="30%">
                    <strong>Tanggal Cetak:</strong><br>
                    {{ $tanggal_cetak->format('d/m/Y H:i') }}
                </td>
                <td width="40%">
                    <strong>Total Kunjungan:</strong><br>
                    {{ $stats['total'] }} Kunjungan
                </td>
                <td width="30%">
                    <strong>Jenis Kunjungan:</strong><br>
                    Pemeriksaan: {{ $stats['pemeriksaan'] ?? 0 }}<br>
                    Imunisasi: {{ $stats['imunisasi'] ?? 0 }}<br>
                    Konsultasi: {{ $stats['konsultasi'] ?? 0 }}
                </td>
            </tr>
        </table>
    </div>
    
    <div class="summary">
        <h4>STATISTIK KUNJUNGAN</h4>
        <div class="stats-box">
            <strong>Balita:</strong> {{ $stats['balita'] }}<br>
            <strong>Remaja:</strong> {{ $stats['remaja'] }}<br>
            <strong>Lansia:</strong> {{ $stats['lansia'] }}
        </div>
        <div class="stats-box">
            <strong>Total:</strong> {{ $stats['total'] }}<br>
            <strong>Pemeriksaan:</strong> {{ $stats['pemeriksaan'] ?? 0 }}<br>
            <strong>Imunisasi:</strong> {{ $stats['imunisasi'] ?? 0 }}
        </div>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Pasien</th>
                <th>Jenis Pasien</th>
                <th>Jenis Kunjungan</th>
                <th>Keluhan</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kunjungans as $index => $kunjungan)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $kunjungan->tanggal_kunjungan->format('d/m/Y') }}</td>
                <td>{{ $kunjungan->pasien->nama_lengkap ?? '-' }}</td>
                <td class="text-center">
                    @if($kunjungan->pasien_type == 'App\Models\Balita')
                        Balita
                    @elseif($kunjungan->pasien_type == 'App\Models\Remaja')
                        Remaja
                    @else
                        Lansia
                    @endif
                </td>
                <td class="text-center">{{ ucfirst($kunjungan->jenis_kunjungan) }}</td>
                <td>{{ $kunjungan->keluhan ?? '-' }}</td>
                <td>{{ $kunjungan->petugas->profile->full_name ?? 'Sistem' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Laporan ini dicetak secara otomatis oleh Sistem Informasi Posyandu</p>
        <p>&copy; {{ date('Y') }} Posyandu Sehat Bahagia. Semua hak dilindungi.</p>
    </div>
</body>
</html>