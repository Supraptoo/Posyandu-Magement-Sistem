<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanImunisasiExport implements FromCollection, WithHeadings, WithMapping
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
            'Jenis Imunisasi',
            'Nama Pasien',
            'NIK',
            'Tanggal Imunisasi',
            'Vaksin',
            'Dosis',
            'Batch Number',
            'Expiry Date',
            'Penyelenggara',
            'Petugas',
            'Kode Kunjungan'
        ];
    }

    public function map($imunisasi): array
    {
        $pasien = $imunisasi->kunjungan->pasien;
        
        return [
            $imunisasi->jenis_imunisasi,
            $pasien->nama_lengkap ?? '-',
            $pasien->nik ?? '-',
            $imunisasi->tanggal_imunisasi->format('d/m/Y'),
            $imunisasi->vaksin,
            $imunisasi->dosis,
            $imunisasi->batch_number,
            $imunisasi->expiry_date->format('d/m/Y'),
            $imunisasi->penyelenggara,
            $imunisasi->kunjungan->petugas->profile->full_name ?? 'Sistem',
            $imunisasi->kunjungan->kode_kunjungan ?? '-'
        ];
    }
}