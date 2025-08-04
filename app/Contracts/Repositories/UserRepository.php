<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserInterface
{
    public function __construct(User $User)
    {
        $this->model = $User;
    }

    public function getAllUsers(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (isset($filters['is_active']) && $filters['is_active'] !== null) {
            $query->where('is_active', $filters['is_active']);
        }

        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Sort
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    public function findById(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function updateUser(int $id, array $data): ?User
    {
        $user = $this->model->findById($id);

        if (!$user) {
            return null;
        }

        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);
        return $user->fresh($data);
    }

    public function deleteUser(int $id): bool
    {
        $user = $this->model->findById($id);

        if (!$user) {
            return false;
        }

        if ($user->id === auth()->id()) {
            return false;
        }

        return $user->delete();
    }

    public function toggleStatus(int $id): ?User
    {
        $user = $this->findById($id);

        if (!$user) {
            return null;
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        return $user->fresh();
    }

    /**
     * Get user statistics
     */
    public function getUserStatistics(): array
    {
        return [
            'total_users' => $this->model->count(),
            'active_users' => $this->model->where('is_active', true)->count(),
            'inactive_users' => $this->model->where('is_active', false)->count(),
            'admin_count' => $this->model->where('role', 'admin')->count(),
            'member_count' => $this->model->where('role', 'member')->count(),
            'recent_registrations' => $this->model->where('created_at', '>=', now()->subDays(7))->count(),
            'users_this_month' => $this->model->whereMonth('created_at', now()->month)->count(),
            'users_today' => $this->model->whereDate('created_at', now()->toDateString())->count()
        ];
    }

    /**
     * Search users by name or email
     */
    public function searchUsers(string $search): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where(function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->get();
    }

    /**
     * Get users by role  
     */
    public function getUsersByRole(string $role): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('role', $role)->get();
    }

    /**
     * Check if user can be deleted
     */
    public function canDelete(int $id, int $currentUserId): bool
    {
        if ($id === $currentUserId) {
            return false;
        }

        $user = $this->findById($id);

        if (!$user) {
            return false;
        }

        return true;
    }
}
