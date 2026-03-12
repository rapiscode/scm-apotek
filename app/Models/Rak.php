<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    protected $table = 'raks';

    protected $fillable = [
        'nama_rak',
        'status',
    ];
}