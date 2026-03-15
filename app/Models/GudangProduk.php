<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GudangProduk extends Model
{
    protected $fillable = [
        'gudang_id',
        'produk_id',
        'stok',
    ];

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
