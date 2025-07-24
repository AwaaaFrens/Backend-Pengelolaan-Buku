<?php

namespace App\Contracts\Interfaces\Eloquent;

interface DeleteInterface
{
    public function delete(int|string $id): mixed;
}
