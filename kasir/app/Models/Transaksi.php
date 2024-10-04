<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'kuantitas',
        'harga',
        'total_harga',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}