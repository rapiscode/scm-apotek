<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = [
        'no_struk',
        'tanggal',
        'pelanggan',
        'total_penjualan',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }
}