<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->getAllUsers($request);

        if (!$users) {
            return ApiResponseHelper::error('Gagal mengambil data', 404);
        }
        return ApiResponseHelper::success($users, 'Berhasil mengambil data');
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            return ApiResponseHelper::error('Gagal mengambil data', 400);
        }

        return ApiResponseHelper::success($user, 'Berhasil mengambil data');
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $user = $this->userService->updateUser($id, $request);

        if (!$user) {
            return ApiResponseHelper::error('Gagal memperbarui data', 400);
        }

        return ApiResponseHelper::success($user, 'Berhasil memperbarui data');
    }

    public function destroy($id)
    {
        $deleted = $this->userService->deleteUser($id);

        if (!$deleted) {
            return ApiResponseHelper::error('Gagal menghapus data', 400);
        }

        return ApiResponseHelper::success(null, 'Berhasil menghapus data');
    }

    public function toggleStatusUsers($id)
    {
        $user = $this->userService->toggleUserStatus($id);

        if (!$user) {
            return ApiResponseHelper::error('User tidak ditemukan', 401);
        }

        return ApiResponseHelper::success($user, 'Status user berhasil diubah');
    }

    public function statistics()
    {
        $stats = $this->userService->getUserStats();

        return ApiResponseHelper::success($stats, 'Stats user berhasil ditampilkan');
    }
}
