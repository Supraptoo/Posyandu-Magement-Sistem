<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Imunisasi - {{ $start_date }} s/d {{ $end_date }}</title>
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
            background-color: #1cc88a;
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
        <h1>LAPORAN IMUNISASI</h1>
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
                    <strong>Total Data:</strong><br>
                    {{ $data->count() }} Imunisasi
                </td>
                <td width="30%">
                    <strong>Periode:</strong><br>
                    {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }}<br>
                    s/d<br>
                    {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
                </td>
            </tr>
        </table>
    </div>
    
    @php
        $groupedData = $data->groupBy('jenis_imunisasi');
    @endphp
    
    @foreach($groupedData as $jenis => $imunisasis)
    <h3>{{ $jenis }} ({{ $imunisasis->count() }})</h3>
    <table class="table">
        <thead>
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
            @foreach($imunisasis as $index => $imunisasi)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $imunisasi->kunjungan->pasien->nama_lengkap ?? '-' }}</td>
                <td class="text-center">{{ $imunisasi->tanggal_imunisasi->format('d/m/Y') }}</td>
                <td>{{ $imunisasi->vaksin }}</td>
                <td class="text-center">{{ $imunisasi->dosis }}</td>
                <td>{{ $imunisasi->batch_number }}</td>
                <td class="text-center">{{ $imunisasi->expiry_date->format('d/m/Y') }}</td>
                <td>{{ $imunisasi->penyelenggara }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach
    
    <div class="summary">
        <h4>STATISTIK IMUNISASI</h4>
        <table>
            @foreach($groupedData as $jenis => $imunisasis)
            <tr>
                <td width="50%">{{ $jenis }}</td>
                <td width="50%">: {{ $imunisasis->count() }} kali imunisasi</td>
            </tr>
            @endforeach
        </table>
    </div>
    
    <div class="footer">
        <p>Laporan ini dicetak secara otomatis oleh Sistem Informasi Posyandu</p>
        <p>&copy; {{ date('Y') }} Posyandu Sehat Bahagia. Semua hak dilindungi.</p>
    </div>
</body>
</html>