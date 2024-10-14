<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $auth = Auth::user();

        if ($auth->role == 1) {
            return redirect()->route('adminDashboard');
        }
        else {
            return redirect()->route('userDashboard');
        }
    }
}
