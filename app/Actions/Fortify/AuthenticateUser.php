<?php

namespace App\Actions\Fortify;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AuthenticateUser
{
    public function authenticate($request)
    {
        $userName = $request->post(config('fortify.username'));
        $password = $request->post('password');

        $user = Admin::where('user_name', $userName)
            ->orWhere('email', $userName)
            ->orWhere('phone_number', $userName)
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }

        return false;
    }
}
