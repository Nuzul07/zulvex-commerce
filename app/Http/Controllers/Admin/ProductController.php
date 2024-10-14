<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CustomHelpers;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
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
            // dfdf
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
        $prd->created_at = Carbon::now();
        $prd->updated_at = Carbon::now();

        // Handling file uploads
        if ($request->has('image') && is_array($request->image)) {
            $images = [];
            $seq = 1;

            foreach ($request->image as $image) {
                // Get the original file name and store the file
                $imgName = sprintf('%s-%s.%s', $p_code, $seq++ ,$image->getClientOriginalExtension());
                $image->storeAs(sprintf('public/picture/productPhoto/%s', $p_code), $imgName); // Store in storage/public/images

                // Store the file name (or the path) in an array
                $images[] = $imgName;
            }

            // Save the array of filenames as a JSON-encoded string in the `image` column
            $prd->image = json_encode($images);
        }




        // if (is_array($request->image)) {
        //     foreach ($request->image as $index => $item) {
        //         if ($request->hasFile("image.$index")) {
        //             $img = $request->file("image.$index");
        //             $uniqueId = uniqid();
        //             $imgName = $img->getClientOriginalName().$uniqueId;
        //             $img->storeAs(sprintf('public/picture/productPhoto/%s', $p_code), $imgName);
        //             $prd->image = $imgName;
        //         }
        //     }
        // }
        $prd->save();
        return back();
    }

    public function update(Request $request)
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
            // dfdf
        ], $alert);

        $prd = Product::where('p_code', $request->p_code)->first();
        $prd->name = $request->name;
        $prd->color = $request->color;
        $prd->price = $request->price;
        $prd->phone_type = $request->phone_type;
        $prd->stock = $request->stock;
        $prd->title = $request->title;
        $prd->desctiption = $request->desctiption;
         
    }
}
