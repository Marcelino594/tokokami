<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    Public Function index()
    {
        $products = Product::paginate(9);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'file|image|mimes:jpeg,png,jpg'
        ]);

        if($request->hasFile('foto')){
            $foto = $request->file('foto');
            Storage::disk('public')->putFileAs('product', $foto, $foto->hashName());
        }
        // Storage::storeAs('public', $foto->hashName());

        Product::create([
            'nama' => $request->nama,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'foto' => $request->hasFile('foto') ? $foto->hashName() : null
        ]);

        return redirect()->route('products.index')->with('success', 'Add Product Success');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }


    public function update(Request $request, Product $product)
    {
    $request->validate([
        'nama' => 'required',
        'harga' => 'required|numeric',
    ]);

    // Update data biasa
    $product->nama = $request->nama;
    $product->harga = $request->harga;
    $product->deskripsi = $request->deskripsi;

    // Jika ada upload gambar baru
    if ($request->hasFile('foto')) {

        // Hapus foto lama jika ada
        if ($product->foto && Storage::disk('public')->exists('product/' . $product->foto)) {
            Storage::disk('public')->delete('product/' . $product->foto);
        }

        // Simpan foto baru
        $foto = $request->file('foto');
        $fotoName = $foto->hashName();
        Storage::disk('public')->putFileAs('product', $foto, $fotoName);

        // Update nama foto di DB
        $product->foto = $fotoName;
    }

    $product->save(); // Gunakan save() karena kamu update manual field-nya

    return redirect()->route('products.index')->with('success', 'Update Product Success');
    }

}
