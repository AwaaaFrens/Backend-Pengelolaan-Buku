<?php

namespace App\Models;

use App\Traits\HasFormattedTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use SoftDeletes, HasFormattedTimestamps;
    
    protected $guarded = [];
    protected $casts = ['genre' => 'array'];

    public function authors()
    {
        return $this->belongsTo(Author::class);
    }
}
