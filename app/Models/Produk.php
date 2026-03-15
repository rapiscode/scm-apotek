<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produks';

    protected $fillable = [
        'tipe_produk',
        'nama_produk',
        'nama_pabrik',
        'sku',
        'barcode',
        'pajak',
        'satuan_utama',
        'harga_beli',
        'harga_jual',
        'stok',
        'stok_minimal',
        'stok_maksimal',
        'rak_penyimpanan',
        'status_penjualan',
        'catatan',
    ];

    public function penyesuaianStoks()
    {
        return $this->hasMany(PenyesuaianStok::class, 'produk_id');
    }

    public function stokOpname()
    {
        return $this->hasOne(\App\Models\StokOpname::class, 'produk_id');
    }

    public function gudangs()
    {
        return $this->belongsToMany(\App\Models\Gudang::class, 'gudang_produks')
            ->withPivot('stok')
            ->withTimestamps();
    }

}