<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Helpers\ApiResponseHelper;
use App\Helpers\PaginateHelper;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

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
        
        $userResource = UserResource::collection($users);
        $formattedUser = PaginateHelper::format($userResource);
        
        return ApiResponseHelper::success($formattedUser, 'Berhasil mengambil data');
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

    public function search(Request $request)
    {
        $search = $request->get('q', '');
        $users = $this->userService->searchUsers($search);
        $userResource = UserResource::collection($users);
        $formattedUser = PaginateHelper::format($userResource->collection);

        return ApiResponseHelper::success($formattedUser, 'Hasil pencarian user');
    }

    public function getByRole($role)
    {
        $users = $this->userService->getUserByRole($role);
        $userResource = UserResource::collection($users);
        $formattedUser = PaginateHelper::format($userResource->collection);

        return ApiResponseHelper::success($formattedUser, "Data user dengan role {$role}");
    }

    public function promoteUser(Request $request, $id)
    {
        try {
            $currentId = auth()->id();
    
            if ($id == $currentId) {
                return ApiResponseHelper::error('Tidak dapat mengubah role sendiri', 403);
            }
    
            $user = $this->userService->promoteToAdmin($id);
    
            if (!$user) {
                return ApiResponseHelper::error('Tidak menemukan User', 404);
            }
    
            return ApiResponseHelper::success(
                new UserResource($user),
                'User berhasil menjadi Admin'
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::error($e->getMessage(), 500);
        }
    }

    public function demoteUser(Request $request, $id)
    {
        try {
            $currentId = auth()->id();
    
            if ($id == $currentId) {
                return ApiResponseHelper::error('Tidak dapat mengubah role sendiri', 403);
            }
    
            $user = $this->userService->demoteToMember($id);
    
            if (!$user) {
                return ApiResponseHelper::error('Tidak menemukan User', 404);
            }
    
            return ApiResponseHelper::success(
                new UserResource($user),
                'User kembali menjadi Member'
            );
        } catch (\Exception $e) {
            return ApiResponseHelper::error($e->getMessage(), 500);
        }
    }
}
