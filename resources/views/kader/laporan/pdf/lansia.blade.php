<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Lansia - {{ $start_date }} s/d {{ $end_date }}</title>
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
            background-color: #5a5c69;
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
        <h1>LAPORAN DATA LANSIA</h1>
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
                    {{ $data->count() }} Lansia
                </td>
                <td width="30%">
                    <strong>Jenis Kelamin:</strong><br>
                    Laki-laki: {{ $data->where('jenis_kelamin', 'L')->count() }}<br>
                    Perempuan: {{ $data->where('jenis_kelamin', 'P')->count() }}
                </td>
            </tr>
        </table>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Lansia</th>
                <th>NIK</th>
                <th>TTL</th>
                <th>Usia</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Penyakit Bawaan</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $lansia)
            @php
                $usia_tahun = $lansia->tanggal_lahir->diffInYears(now());
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $lansia->kode_lansia }}</td>
                <td>{{ $lansia->nama_lengkap }}</td>
                <td>{{ $lansia->nik }}</td>
                <td>
                    {{ $lansia->tempat_lahir }},<br>
                    {{ $lansia->tanggal_lahir->format('d/m/Y') }}
                </td>
                <td class="text-center">{{ $usia_tahun }} tahun</td>
                <td class="text-center">{{ $lansia->jenis_kelamin == 'L' ? 'L' : 'P' }}</td>
                <td>{{ Str::limit($lansia->alamat, 40) }}</td>
                <td>{{ $lansia->penyakit_bawaan ?? '-' }}</td>
                <td class="text-center">{{ $lansia->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="summary">
        <h4>STATISTIK DISTRIBUSI USIA</h4>
        <table>
            <tr>
                <td width="25%">60-64 tahun</td>
                <td width="25%">: {{ $data->filter(fn($l) => $l->tanggal_lahir->diffInYears(now()) >= 60 && $l->tanggal_lahir->diffInYears(now()) <= 64)->count() }} lansia</td>
                <td width="25%">65-69 tahun</td>
                <td width="25%">: {{ $data->filter(fn($l) => $l->tanggal_lahir->diffInYears(now()) >= 65 && $l->tanggal_lahir->diffInYears(now()) <= 69)->count() }} lansia</td>
            </tr>
            <tr>
                <td>70-74 tahun</td>
                <td>: {{ $data->filter(fn($l) => $l->tanggal_lahir->diffInYears(now()) >= 70 && $l->tanggal_lahir->diffInYears(now()) <= 74)->count() }} lansia</td>
                <td>75 tahun ke atas</td>
                <td>: {{ $data->filter(fn($l) => $l->tanggal_lahir->diffInYears(now()) >= 75)->count() }} lansia</td>
            </tr>
        </table>
    </div>
    
    <div class="footer">
        <p>Laporan ini dicetak secara otomatis oleh Sistem Informasi Posyandu</p>
        <p>&copy; {{ date('Y') }} Posyandu Sehat Bahagia. Semua hak dilindungi.</p>
    </div>
</body>
</html>