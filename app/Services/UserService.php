<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepository;
use Illuminate\Support\Facades\Request;

class UserService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function getAllUsers(Request $request)
    {
        $filters = [
            'role' => $request->get('role'),
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : null,
            'search' => $request->get('search'),
            'sort_by' => $request->get('sort_b', 'created_at'),
            'sort_order' => $request->get('sort_order', 'desc')
        ];

        $perPage = $request->get('per_page', 15);
        return $this->userRepo->getAllUsers($filters, $perPage);
    }

    public function getUserById($id)
    {
        return $this->userRepo->findById($id);
    }

    public function updateUser($id, $request)
    {
        $data = $request->only(['name', 'email', 'role', 'is_active']);

        if ($request->has('password') && $request->password) {
            $data['password'] = $request->password;
        }

        return $this->userRepo->updateUser($id, $data);
    }

    public function deleteUser($id)
    {
        if (!$this->userRepo->canDelete($id, auth()->id())) {
            return false;
        }

        return $this->userRepo->deleteUser($id);
    }

    public function toggleUserStatus($id)
    {
        return $this->userRepo->toggleStatus($id);
    }

    public function getUserStats()
    {
        return $this->userRepo->getUserStatistics();
    }

    public function searchUsers($search)
    {
        return $this->userRepo->searchUsers($search);
    }

    public function getUserByRole($role)
    {
        return $this->userRepo->getUsersByRole($role);
    }
}
