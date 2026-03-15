<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    protected $table = 'stok_opnames';

    protected $fillable = [
        'riwayat_opname_id',
        'produk_id',
        'stok_fisik',
        'selisih',
        'catatan',
        'waktu_opname',
    ];


    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function riwayatOpname()
    {
        return $this->belongsTo(\App\Models\RiwayatOpname::class, 'riwayat_opname_id');
    }
}