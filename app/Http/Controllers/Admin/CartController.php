<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomHelpers;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/Cart');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getAll()
    {
        $cart = Cart::all();
        return $cart;
    }

    public function getUserCart(Request $request)
    {
        $cart = Cart::with('product')->where('user_id', $request->user()->user_id)->get();
        return $cart;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cart = new Cart();
        $cart->c_code = CustomHelpers::getCartCode();
        $cart->p_code = $request->p_code;
        $cart->user_id = $request->user()->user_id;
        $cart->quantity = $request->quantity;
        $cart->save();
        $cartCount = Cart::count();
        return response()->json(['cart_count' => $cartCount]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateExist(Request $request)
    {
        $cart = Cart::where('user_id', $request->user_id)->where('p_code', $request->p_code)->first();
        $cart->quantity = $cart->quantity + $request->quantity;
        $cart->update();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $cart = Cart::where('user_id', $request->user_id)->first();
        $cart->delete();
        $cartCount = Cart::where('user_id', $request->user_id)->count();
        return response()->json([
            'cart_count' => $cartCount
        ]);
    }
}
