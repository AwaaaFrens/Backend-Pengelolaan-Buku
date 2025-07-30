<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponseHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authservice;

    public function __construct(AuthService $authService)
    {
        $this->authservice = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authservice->register($request);

        return ApiResponseHelper::success($result, 'Registrasi berhasil');
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authservice->login($request);

        if (!$result) {
            return ApiResponseHelper::error('Email atau Password salah', 401);
        }

        return ApiResponseHelper::success($result, 'Berhasil Login');
    }
}
