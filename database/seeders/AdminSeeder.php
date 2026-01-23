<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah admin sudah ada agar tidak error duplicate entry
        $admin = User::where('email', 'admin@posyandu.com')->first();

        if (!$admin) {
            $user = User::create([
                'name' => 'Administrator',
                'email' => 'admin@posyandu.com',
                'password' => Hash::make('password'), // Ganti password sesuai keinginan
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);

            // Buat Profile Admin (PENTING: Karena relasi User->Profile wajib ada jika Anda akses dashboard)
            Profile::create([
                'user_id' => $user->id,
                'full_name' => 'Administrator Sistem',
                'nik' => '0000000000000000', // Dummy NIK
                'jenis_kelamin' => 'L',
                'alamat' => 'Kantor Posyandu',
                'telepon' => '081234567890',
            ]);
        }
    }
}