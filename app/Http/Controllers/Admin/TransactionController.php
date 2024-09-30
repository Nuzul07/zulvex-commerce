<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function orderIndex()
    {
        return Inertia::render('Admin/Transaction/Order');
    }
}
