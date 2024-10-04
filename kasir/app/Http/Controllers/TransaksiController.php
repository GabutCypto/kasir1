<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransaksiResource;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TransaksiController extends Controller
{
    public function index()
    {
        return TransaksiResource::collection(Transaksi::with('produk')->get());
    }

    public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'produk_id' => 'required|exists:produks,id',
        'kuantitas' => 'required|integer',
    ]);

    // Ambil produk berdasarkan ID
    $produk = Produk::findOrFail($validated['produk_id']);
    
    // Cek apakah stok cukup
    if ($produk->stok < $validated['kuantitas']) {
        return response()->json(['error' => 'Stok tidak cukup'], 400);
    }

    // Hitung total harga
    $total_harga = $produk->harga * $validated['kuantitas'];

    // Buat transaksi
    $transaksi = Transaksi::create([
        'produk_id' => $validated['produk_id'],
        'kuantitas' => $validated['kuantitas'],
        'harga' => $produk->harga,
        'total_harga' => $total_harga,
    ]);

    // Kurangi stok produk
    $produk->stok -= $validated['kuantitas'];
    $produk->save();

    return new TransaksiResource($transaksi);
}


    public function show($id)
    {
        return new TransaksiResource(Transaksi::with('produk')->findOrFail($id));
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
        return response()->json(null, 204);
    }
}