<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $prd = $request->products;
        return Inertia::render('User/Checkout', [ 'products' => $prd ]);
    }

    public function store()
    {
        //
    }

}
