<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomHelpers;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Product');
    }

    public function getAll()
    {
        $prd = Product::all();
        return $prd;
    }

    public function store(Request $request)
    {
        $alert = [
            'name.required' => 'Nama harus diisi !',
            'title.required' => 'Judul harus diisi !',
            'color.required' => 'Warna harus diisi !',
            'price.required' => 'Harga harus diisi !',
            'phone_type.required' => 'Tipe handphone harus diisi !',
            'description.required' => 'Deskripsi harus diisi !',
            'image.required' => 'Foto Produk harus diupload !',
            'image.mimes' => 'Foto Produk harus berupa JPG, JPEG, dan PNG !',
            'image.max' => 'Foto Produk maksimal berukuran 2MB !',
        ];

        $request->validate([
            'name' => 'required|string',
            'title' => 'required|string',
            'color' => 'required|string',
            'price' => 'required|numeric',
            'phone_type' => 'required|string',
            'description' => 'required|string',
            'image.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
                function ($attribute, $value, $fail) {
                    $mimeType = $value->getMimeType();
                    $originalExtension = strtolower($value->getClientOriginalExtension());

                    if ($mimeType === 'image/jpeg' && $originalExtension === 'jfif') {
                        $fail('Each file must be of type JPG, JPEG, or PNG.');
                    }
                }
            ],
        ], $alert);

        $p_code = CustomHelpers::getProductCode();
        $prd = new Product();
        $prd->p_code = $p_code;
        $prd->name = $request->name;
        $prd->title = $request->title;
        $prd->color = $request->color;
        $prd->price = $request->price;
        $prd->phone_type = $request->phone_type;
        $prd->stock = $request->stock;
        $prd->description = $request->description;
        $prd->image = $request->image;
    }
}
