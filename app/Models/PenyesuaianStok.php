<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenyesuaianStok extends Model
{
    protected $table = 'penyesuaian_stoks';

    protected $fillable = [
        'produk_id',
        'tanggal',
        'stok_fisik',
        'catatan'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class,'produk_id');
    }
}