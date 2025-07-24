<?php

namespace App\Contracts\Interfaces\Eloquent;

interface UpdateInterface
{
    public function update(int|string $id, array $data): mixed;
}
