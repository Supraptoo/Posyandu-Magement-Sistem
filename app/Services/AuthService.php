<?php
?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function authenticate(\, \)
    {
        if (\ === 'email') {
            return User::where('email', \['email'])->first();
        } else {
            return User::where('nik', \['nik'])->first();
        }
    }
}
