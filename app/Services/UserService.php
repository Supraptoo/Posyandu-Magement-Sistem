<?php
?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class UserService
{
    public function createUser(\, \, \)
    {
        // Generate password acak 8 karakter
        \ = Str::random(8);
        
        \ = User::create([
            'email' => \ !== 'user' ? \['email'] : null,
            'nik' => \ === 'user' ? \['nik'] : null,
            'password' => Hash::make(\),
            'role' => \,
            'created_by' => \,
        ]);
        
        return [
            'user' => \,
            'plain_password' => \
        ];
    }
    
    public function resetPassword(\)
    {
        \ = Str::random(8);
        \ = User::find(\);
        \->password = Hash::make(\);
        \->save();
        
        return \;
    }
}
