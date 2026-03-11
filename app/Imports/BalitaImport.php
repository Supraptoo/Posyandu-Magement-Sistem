<?php

namespace App\Imports;

use App\Models\Balita;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BalitaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Lewati jika baris NIK kosong
        if (!isset($row['nik']) || empty($row['nik'])) {
            return null;
        }

        return Balita::updateOrCreate(
            ['nik' => $row['nik']], // Cek keunikan NIK
            [
                'nama_lengkap'  => $row['nama_lengkap'],
                'tempat_lahir'  => $row['tempat_lahir'] ?? '-',
                'tanggal_lahir' => $row['tanggal_lahir'], // Format: YYYY-MM-DD
                'jenis_kelamin' => strtoupper($row['jenis_kelamin'] ?? 'P'),
                'berat_badan_lahir'  => $row['berat_badan_lahir'] ?? 0,
                'tinggi_badan_lahir' => $row['tinggi_badan_lahir'] ?? 0,
                'nama_ayah'     => $row['nama_ayah'] ?? null,
                'nama_ibu'      => $row['nama_ibu'] ?? null,
                'telepon_ortu'  => $row['telepon_ortu'] ?? null,
                'alamat'        => $row['alamat'] ?? 'Desa Bantar Kulon',
            ]
        );
    }
}