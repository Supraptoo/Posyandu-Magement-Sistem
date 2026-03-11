<?php

namespace App\Imports;

use App\Models\Lansia;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LansiaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Lewati jika baris NIK kosong
        if (!isset($row['nik']) || empty($row['nik'])) {
            return null;
        }

        return Lansia::updateOrCreate(
            ['nik' => $row['nik']], // Cek keunikan NIK
            [
                'nama_lengkap'  => $row['nama_lengkap'],
                'tempat_lahir'  => $row['tempat_lahir'] ?? '-',
                'tanggal_lahir' => $row['tanggal_lahir'], // Format: YYYY-MM-DD
                'jenis_kelamin' => strtoupper($row['jenis_kelamin'] ?? 'P'),
                'alamat'        => $row['alamat'] ?? 'Desa Bantar Kulon',
                'penyakit_bawaan' => $row['penyakit_bawaan'] ?? null,
                'pekerjaan'     => $row['pekerjaan'] ?? null,
                'golongan_darah' => $row['golongan_darah'] ?? null,
            ]
        );
    }
}