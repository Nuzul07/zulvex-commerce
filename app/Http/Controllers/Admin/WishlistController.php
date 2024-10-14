<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomHelpers;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/Wishlist');
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
        $wish = Wishlist::all();
        return $wish;
    }

    public function getUserWishlist(Request $request)
    {
        $wish = Wishlist::where('user_id', $request->user_id)->get();
        return $wish;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $wish = new Wishlist();
        $wish->w_code = CustomHelpers::getWishlistCode();
        $wish->p_code = $request->p_code;
        $wish->user_id = $request->user()->user_id;
        $wish->p_name = $request->p_name;
        $wish->p_type = $request->p_type;
        $wish->p_description = $request->p_description;
        $wish->p_price = $request->p_price;
        $wish->p_image = $request->p_image;
        $wish->save();
        $wishlistCount = Wishlist::count();
        return response()->json(['wishlist_count' => $wishlistCount]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $wish = Wishlist::where('user_id', $request->user_id)->first();
        $wish->delete();
        $wishlistCount = Wishlist::where('user_id', $request->user_id)->count();
        return response()->json([
            'wishlist_count' => $wishlistCount,
        ]);
    }
}
