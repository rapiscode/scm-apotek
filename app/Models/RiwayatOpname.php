<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatOpname extends Model
{
    protected $fillable = [
        'kode_opname',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'catatan',
    ];

    public function detailOpnames()
    {
        return $this->hasMany(\App\Models\StokOpname::class, 'riwayat_opname_id');
    }
}