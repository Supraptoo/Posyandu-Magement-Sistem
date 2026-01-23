<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TemplateImportRemajaExport implements FromArray, WithHeadings, WithTitle
{
    public function array(): array
    {
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
            'Alamat',
            'Sekolah',
            'Kelas',
            'Nama Orang Tua',
            'Telepon Orang Tua'
        ];
    }

    public function title(): string
    {
        return 'Template Import Remaja';
    }
}