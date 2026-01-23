<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TemplateImportBalitaExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
        // Return array kosong untuk template
        return [];
    }

    public function headings(): array
    {
        return [
            'Nama Lengkap',
            'NIK',
            'Tempat Lahir',
            'Tanggal Lahir (YYYY-MM-DD)',
            'Jenis Kelamin (L/P)',
            'Nama Ibu',
            'Nama Ayah',
            'Alamat',
            'Berat Lahir (kg)',
            'Panjang Lahir (cm)'
        ];
    }

    public function title(): string
    {
        return 'Template Import Balita';
    }
}