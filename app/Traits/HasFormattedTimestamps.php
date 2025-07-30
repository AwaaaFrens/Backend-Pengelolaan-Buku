<?php

namespace App\Traits;

use Carbon\Carbon;

trait HasFormattedTimestamps
{
    public function getCreatedAtAttribute($value) // ambil kolom CreatedAt
    {
        return Carbon::parse($value)
        ->setTimezone('Asia/Jakarta')
        ->translatedFormat('l, d-F-Y H:i');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)
        ->setTimezone('Asia/Jakarta')
        ->translatedFormat('l, d-F-Y H:i');
    }

    public function getDeletedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)
        ->setTimezone('Asia/Jakarta')
        ->translatedFormat('l, d-F-Y H:i') : null;
    }
}
