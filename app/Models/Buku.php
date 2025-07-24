<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $guarded = [];
    protected $casts = ['genre' => 'array'];
    protected $hidden = ['created_at'];
}
