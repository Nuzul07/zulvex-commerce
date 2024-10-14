<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomHelpers;
use App\Models\Review;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Review');
    }

    public function getAll()
    {
        $rev = Review::all();
        return $rev;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $alert = [
            'rate.required' => 'Rating harus diisi',
            'description.required' => 'Description harus diisi',
        ];

        $request->validate([
            'rate' => 'required|string',
            'description' => 'required|string',
        ], $alert);

        $r_code = CustomHelpers::getReviewCode();
        $rev = new Review();
        $rev->r_code = $r_code;
        $rev->p_code = $request->p_code;
        $rev->user_id = $request->user()->user_id;
        $rev->rate = $request->rate;
        $rev->description = $request->description;
        $rev->save();
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
