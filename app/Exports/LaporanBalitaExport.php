<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class LaporanBalitaExport implements FromCollection, WithHeadings, WithMapping
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
            'Kode Balita',
            'Nama Lengkap',
            'NIK',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Usia',
            'Jenis Kelamin',
            'Nama Ibu',
            'Nama Ayah',
            'Alamat',
            'Berat Lahir (kg)',
            'Panjang Lahir (cm)',
            'Berat Badan Terakhir (kg)',
            'Tinggi Badan Terakhir (cm)',
            'Tanggal Kunjungan Terakhir',
            'Tanggal Daftar'
        ];
    }

    public function map($balita): array
    {
        $usia_bulan = $balita->tanggal_lahir->diffInMonths(now());
        $usia_tahun = floor($usia_bulan / 12);
        $sisa_bulan = $usia_bulan % 12;
        
        $kunjungan_terakhir = $balita->kunjungans->first();
        $pemeriksaan_terakhir = $kunjungan_terakhir ? $kunjungan_terakhir->pemeriksaan : null;
        
        return [
            $balita->kode_balita,
            $balita->nama_lengkap,
            $balita->nik,
            $balita->tempat_lahir,
            $balita->tanggal_lahir->format('d/m/Y'),
            $usia_tahun > 0 ? $usia_tahun . ' thn ' . $sisa_bulan . ' bln' : $sisa_bulan . ' bln',
            $balita->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            $balita->nama_ibu,
            $balita->nama_ayah,
            $balita->alamat,
            $balita->berat_lahir,
            $balita->panjang_lahir,
            $pemeriksaan_terakhir ? $pemeriksaan_terakhir->berat_badan : '-',
            $pemeriksaan_terakhir ? $pemeriksaan_terakhir->tinggi_badan : '-',
            $kunjungan_terakhir ? $kunjungan_terakhir->tanggal_kunjungan->format('d/m/Y') : '-',
            $balita->created_at->format('d/m/Y')
        ];
    }
}