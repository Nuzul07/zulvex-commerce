<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomHelpers;
use App\Models\Payment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Admin/Transaction/Payment');
    }

    public function getAll()
    {
        $pay = Payment::all();
        return $pay;
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
            'no_invoice.required' => 'No Invoice harus diisi',
            'buyer.required' => 'Buyer harus diisi',
            'total.required' => 'Total harus diisi',
            'payment_type.required' => 'Payment Type harus diisi',
        ];

        $request->validate([
            'no_invoice' => 'required|string',
            'buyer' => 'required|string',
            'total' => 'required|numeric',
            'payment_type' => 'required|string',
        ], $alert);

        $payment_code = CustomHelpers::getPaymentCode();
        $pay = new Payment();
        $pay->payment_code = $payment_code;
        $pay->no_invoice = $request->no_invoice;
        $pay->user_id = $request->user()->user_id;
        $pay->total = $request->total;
        $pay->payment_type = $request->payment_type;
        $pay->save();
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
