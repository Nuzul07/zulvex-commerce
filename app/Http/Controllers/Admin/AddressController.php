<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomHelpers;
use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AddressController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/MasterData/Address');
    }

    public function getAll()
    {
        $adr = Address::all();
        return $adr;
    }

    public function getAddressUser(Request $request)
    {
        $adr = Address::where('user_id', $request->user_id)->get();
        return $adr;
    }

    public function store(Request $request)
    {
        $alert = [
            'adr_name.required' => 'Nama harus diisi',
            'adr_phone.required' => 'No Telp harus diisi',
            'adr_phone.numeric' => 'No Telp harus berupa angka',
            'province.required' => 'Provinsi harus diisi',
            'city.required' => 'Kota/Kabupaten harus diisi',
            'district.required' => 'Kecamatan harus diisi',
            'neighborhood.required' => 'Kelurahan harus diisi',
            'zipcode.required' => 'Kodepos harus diisi',
            'full_address.required' => 'Alamat Lengkap harus diisi',
            'type.required' => 'Tipe Alamat harus diisi',
        ];

        $request->validate([
            'adr_name' => 'required|string',
            'adr_phone' => 'required|numeric',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'neighborhood' => 'required|string',
            'zipcode' => 'required|numeric',
            'full_address' => 'required|string',
            'type' => 'required|numeric',
        ], $alert);

        $adr_code = CustomHelpers::getAddressCode();
        $adr = new Address();
        $adr->adr_code = $adr_code;
        $adr->user_id = $request->user()->user_id;
        $adr->adr_name = $request->adr_name;
        $adr->adr_phone = $request->adr_phone;
        $adr->province = $request->province;
        $adr->city = $request->city;
        $adr->district = $request->district;
        $adr->neighborhood = $request->neighborhood;
        $adr->zipcode = $request->zipcode;
        $adr->full_address = $request->full_address;
        $adr->type = $request->type;
        $adr->save();
        return back(); 
    }

    public function update(Request $request)
    {
        $alert = [
            'adr_name.required' => 'Nama harus diisi',
            'adr_phone.required' => 'No Telp harus diisi',
            'adr_phone.numeric' => 'No Telp harus berupa angka',
            'province.required' => 'Provinsi harus diisi',
            'city.required' => 'Kota/Kabupaten harus diisi',
            'district.required' => 'Kecamatan harus diisi',
            'neighborhood.required' => 'Kelurahan harus diisi',
            'zipcode.required' => 'Kodepos harus diisi',
            'full_address.required' => 'Alamat Lengkap harus diisi',
            'type.required' => 'Tipe Alamat harus diisi',
        ];

        $request->validate([
            'adr_name' => 'required|string',
            'adr_phone' => 'required|numeric',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'neighborhood' => 'required|string',
            'zipcode' => 'required|numeric',
            'full_address' => 'required|string',
            'type' => 'required|numeric',
        ], $alert);

        $adr = Address::where('adr_code', $request->adr_code)->first();
        $adr->user_id = $request->user()->user_id;
        $adr->adr_name = $request->adr_name;
        $adr->adr_phone = $request->adr_phone;
        $adr->province = $request->province;
        $adr->city = $request->city;
        $adr->district = $request->district;
        $adr->neighborhood = $request->neighborhood;
        $adr->zipcode = $request->zipcode;
        $adr->full_address = $request->full_address;
        $adr->type = $request->type;
        $adr->update();
        return back();
    }
}