<?php

namespace App\Contracts\Interfaces\Eloquent;

interface ShowInterface
{
    public function show(int|string $id): mixed;
}
