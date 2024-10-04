<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProdukResource;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        return ProdukResource::collection(Produk::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
        ]);

        $produk = Produk::create($validated);
        return new ProdukResource($produk);
    }

    public function show($id)
    {
        return new ProdukResource(Produk::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|string|max:255',
            'harga' => 'sometimes|numeric',
            'stok' => 'sometimes|integer',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update($validated);
        return new ProdukResource($produk);
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return response()->json(null, 204);
    }
}