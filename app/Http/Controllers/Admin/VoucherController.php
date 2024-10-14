<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomHelpers;
use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VoucherController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/MasterData/Voucher');
    }

    public function getAll()
    {
        $vcr = Voucher::all();
        return $vcr;
    }

    public function store(Request $request)
    {
        $alert = [
            'name.required' => 'Nama voucher harus diisi',
            'amount.required' => 'Nominal voucher harus diisi',
            'amount.numeric' => 'Nominal voucher harus berupa angka',
            'expires_date.required' => 'Expires Date harus diisi'
        ];

        $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric',
            'expires_date' => 'required|date'
        ], $alert);

        $v_code = CustomHelpers::getVoucherCode();
        $vcr = new Voucher();
        $vcr->v_code = $v_code;
        $vcr->name = $request->name;
        $vcr->amount = $request->amount;
        $vcr->expires_date = $request->expires_date;
        $vcr->save();
        return back();
    }

    public function update(Request $request)
    {
        $alert = [
            'name.required' => 'Nama voucher harus diisi',
            'amount.required' => 'Nominal voucher harus diisi',
            'amount.numeric' => 'Nominal voucher harus berupa angka',
            'expires_date.required' => 'Expires Date harus diisi'
        ];

        $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric',
            'expires_date' => 'required|date'
        ], $alert);

        $vcr = Voucher::where('v_code', $request->v_code)->first();
        $vcr->name = $request->name;
        $vcr->amount = $request->amount;
        $vcr->update();
        return back();
    }
}
