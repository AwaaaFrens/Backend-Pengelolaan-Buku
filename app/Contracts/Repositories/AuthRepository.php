<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\AuthInterface;
use App\Models\User;


class AuthRepository extends BaseRepository implements AuthInterface
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function createUser(array $data): User
    {
        return $this->model->create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }
}
