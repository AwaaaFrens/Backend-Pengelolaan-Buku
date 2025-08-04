<?php

namespace App\Contracts\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserInterface
{
    public function getAllUsers(array $filters = [], int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): ?User;

    public function updateUser(int $id, array $data): ?User;

    public function toggleStatus(int $id): ?User;

    public function getUserStatistics(): array;

    public function searchUsers(string $search): Collection;

    public function getUsersByRole(string $role): Collection;

    public function canDelete(int $id, int $currentIdUser): bool;
}