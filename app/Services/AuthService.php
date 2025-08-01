<?php

namespace App\Services;

use App\Contracts\Repositories\AuthRepository;
use App\Enum\UserRoleEnum;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $authrepo;

    public function __construct(AuthRepository $authrepo)
    {
        $this->authrepo = $authrepo;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authrepo->createUser([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->assignRole(UserRoleEnum::Member->value);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authrepo->findByEmail($request->email);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return null;
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => new UserResource($user),
            'token' => $token
        ];
    }

    public function logout($user)
    {
        $user->tokens()->delete();
    }
}
