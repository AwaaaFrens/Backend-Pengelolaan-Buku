<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository // bikin kelas abstrak yang nanti akakn diisi oleh repository yang menggunakan ini
{
    /**
    * Handle model initialization.
    *
    * @var Model $model
    */
    public Model $model; // menyediakan properti kosong dengan tipe Eloquent/Model
}
