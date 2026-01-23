<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class TemplateImportLansiaExport implements FromArray, WithHeadings, WithTitle
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
            'Penyakit Bawaan'
        ];
    }

    public function title(): string
    {
        return 'Template Import Lansia';
    }
}