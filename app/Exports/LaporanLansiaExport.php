<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanLansiaExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;
    protected $start_date;
    protected $end_date;

    public function __construct($data, $start_date, $end_date)
    {
        $this->data = $data;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Kode Lansia',
            'Nama Lengkap',
            'NIK',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Usia',
            'Jenis Kelamin',
            'Alamat',
            'Penyakit Bawaan',
            'Berat Badan Terakhir (kg)',
            'Tinggi Badan Terakhir (cm)',
            'Tekanan Darah Terakhir',
            'Gula Darah Terakhir',
            'Kolesterol Terakhir',
            'Tanggal Kunjungan Terakhir',
            'Tanggal Daftar'
        ];
    }

    public function map($lansia): array
    {
        $usia_tahun = $lansia->tanggal_lahir->diffInYears(now());
        
        $kunjungan_terakhir = $lansia->kunjungans->first();
        $pemeriksaan_terakhir = $kunjungan_terakhir ? $kunjungan_terakhir->pemeriksaan : null;
        
        return [
            $lansia->kode_lansia,
            $lansia->nama_lengkap,
            $lansia->nik,
            $lansia->tempat_lahir,
            $lansia->tanggal_lahir->format('d/m/Y'),
            $usia_tahun . ' tahun',
            $lansia->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            $lansia->alamat,
            $lansia->penyakit_bawaan ?? '-',
            $pemeriksaan_terakhir ? $pemeriksaan_terakhir->berat_badan : '-',
            $pemeriksaan_terakhir ? $pemeriksaan_terakhir->tinggi_badan : '-',
            $pemeriksaan_terakhir ? $pemeriksaan_terakhir->tekanan_darah : '-',
            $pemeriksaan_terakhir ? $pemeriksaan_terakhir->gula_darah : '-',
            $pemeriksaan_terakhir ? $pemeriksaan_terakhir->kolesterol : '-',
            $kunjungan_terakhir ? $kunjungan_terakhir->tanggal_kunjungan->format('d/m/Y') : '-',
            $lansia->created_at->format('d/m/Y')
        ];
    }
}