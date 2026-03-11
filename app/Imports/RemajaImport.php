<?php

namespace App\Imports;

use App\Models\Remaja;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RemajaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Lewati jika NIK tidak ada atau kosong
        if (!isset($row['nik']) || empty($row['nik'])) {
            return null;
        }

        // Gunakan updateOrCreate agar jika NIK sudah ada, data hanya diperbarui
        return Remaja::updateOrCreate(
            ['nik' => $row['nik']], // Kunci pengecekan unik
            [
                'nama_lengkap'  => $row['nama_lengkap'],
                'tempat_lahir'  => $row['tempat_lahir'] ?? '-',
                'tanggal_lahir' => $row['tanggal_lahir'], // Format di Excel wajib YYYY-MM-DD
                'jenis_kelamin' => strtoupper($row['jenis_kelamin'] ?? 'P'),
                'sekolah'       => $row['sekolah'] ?? null,
                'kelas'         => $row['kelas'] ?? null,
                'nama_ortu'     => $row['nama_ortu'] ?? null,
                'telepon_ortu'  => $row['telepon_ortu'] ?? null,
                'alamat'        => $row['alamat'] ?? 'Desa Bantar Kulon',
                'user_id'       => null, // Bisa dikaitkan ke user nanti melalui fitur Sync
            ]
        );
    }
}