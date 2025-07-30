<?php

namespace App\Models;

use App\Traits\HasFormattedTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes, HasFormattedTimestamps;
    
    protected $guarded = [];
    protected $hidden = ['created_at'];

    public function bukus()
    {
        return $this->hasMany(Buku::class);
    }
}
