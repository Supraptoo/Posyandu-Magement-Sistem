<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanRemajaExport implements FromCollection, WithHeadings, WithMapping
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
            'Kode Remaja',
            'Nama Lengkap',
            'NIK',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Usia',
            'Jenis Kelamin',
            'Alamat',
            'Sekolah',
            'Kelas',
            'Nama Orang Tua',
            'Telepon Orang Tua',
            'Berat Badan Terakhir (kg)',
            'Tinggi Badan Terakhir (cm)',
            'Tekanan Darah Terakhir',
            'Tanggal Kunjungan Terakhir',
            'Tanggal Daftar'
        ];
    }

    public function map($remaja): array
    {
        $usia_tahun = $remaja->tanggal_lahir->diffInYears(now());
        
        $kunjungan_terakhir = $remaja->kunjungans->first();
        $pemeriksaan_terakhir = $kunjungan_terakhir ? $kunjungan_terakhir->pemeriksaan : null;
        
        return [
            $remaja->kode_remaja,
            $remaja->nama_lengkap,
            $remaja->nik,
            $remaja->tempat_lahir,
            $remaja->tanggal_lahir->format('d/m/Y'),
            $usia_tahun . ' tahun',
            $remaja->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            $remaja->alamat,
            $remaja->sekolah,
            $remaja->kelas,
            $remaja->nama_ortu,
            $remaja->telepon_ortu,
            $pemeriksaan_terakhir ? $pemeriksaan_terakhir->berat_badan : '-',
            $pemeriksaan_terakhir ? $pemeriksaan_terakhir->tinggi_badan : '-',
            $pemeriksaan_terakhir ? $pemeriksaan_terakhir->tekanan_darah : '-',
            $kunjungan_terakhir ? $kunjungan_terakhir->tanggal_kunjungan->format('d/m/Y') : '-',
            $remaja->created_at->format('d/m/Y')
        ];
    }
}