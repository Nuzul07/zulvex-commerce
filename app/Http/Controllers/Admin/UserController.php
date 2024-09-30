<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/MasterData/User');
    }

    public function getAll()
    {
        $usr = User::all();
        return $usr;
    }

    public function updateStatusAktif(Request $request)
    {
        $user = User::where('user_id', $request->user_id)->first();
        $user->status = 1;
        $user->save();
    }

    public function updateStatusNonAktif(Request $request)
    {
        $user = User::where('user_id', $request->user_id)->first();
        $user->status = 0;
        $user->save();
    }
}
