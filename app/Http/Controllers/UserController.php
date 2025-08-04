<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
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
            return ApiResponseHelper::error('Gagal memperbarui data', 400);
        }

        return ApiResponseHelper::success($user, 'Berhasil memperbarui data');
    }

    public function update()
}
