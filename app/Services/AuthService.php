<?php

namespace App\Services;

use App\Contracts\Repositories\AuthRepository;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthService
{
    protected $authrepo;

    public function __construct(AuthRepository $authrepo)
    {
        $this->authrepo = $authrepo;
    }

    public function register(RegisterRequest $request)
    {
        return $this->authrepo->register($request);
    }

    public function login(LoginRequest $request)
    {
        return $this->authrepo->login($request);
    }
}
