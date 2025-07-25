<?php

namespace App\Contracts\Interfaces\Eloquent;

interface GetInterface
{
    public function get(?string $genre = null, ?string $author = null): mixed;
}
