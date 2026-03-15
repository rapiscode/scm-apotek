<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    protected $table = 'gudangs';

    protected $fillable = [
        'nama_gudang',
        'status',
    ];

    public function produkGudangs()
    {
        return $this->hasMany(\App\Models\GudangProduk::class, 'gudang_id');
    }

    public function produks()
    {
        return $this->belongsToMany(\App\Models\Produk::class, 'gudang_produks')
            ->withPivot('stok')
            ->withTimestamps();
    }

}