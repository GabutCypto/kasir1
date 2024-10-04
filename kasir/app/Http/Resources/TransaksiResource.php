<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransaksiResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'produk' => new ProdukResource($this->produk),
            'kuantitas' => $this->kuantitas,
            'harga' => $this->harga,
            'total_harga' => $this->total_harga,
            'dibuat_pada' => $this->created_at,
            'diupdate_pada' => $this->updated_at,
        ];
    }
}