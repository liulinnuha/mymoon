<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class Store extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'shipping_id' => 'nullable|exists:shippings,id',
            'images' => 'nullable|array', // Validasi gambar sebagai array
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi masing-masing gambar
        ]);

        // Simpan gambar
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $file) {
                $filename = $file->store('images', 'public');
                $image = Image::create(['filename' => $filename]);
                $images[] = $image->id;
            }
        }

        // Simpan data produk
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->discount = $request->input('discount', 0);
        $product->category_id = $request->input('category_id');
        $product->shipping_id = $request->input('shipping_id');
        $product->save();

        // Attach id gambar ke produk
        if (!empty($images)) {
            $product->images()->attach($images);
        }

        return redirect()->route('products.index');
    }
}
