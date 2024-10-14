<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AllController extends Controller
{
    public function indexProduct()
    {
        return Inertia::render('User/Product/Index');
    }

    public function indexAbout()
    {
        return Inertia::render('User/About');
    }

    public function indexContact()
    {
        return Inertia::render('User/Contact');
    }

    public function indexAccount()
    {
        return Inertia::render('User/Account');
    }

    public function getCounter(Request $request)
    {
        $userid = $request->user() ? $request->user()->user_id : null;
        $wish = $userid ? Wishlist::where('user_id', $userid)->count() : 0;
        $cart = $userid ? Cart::where('user_id', $userid)->count() : 0;
        return response()->json(['wishlist_count' => $wish, 'cart_count' => $cart]);
    }
}
