<?php
        
namespace App\Contracts\Interfaces;
        
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

interface AuthInterface 
{
    public function register(RegisterRequest $request);
    public function login(LoginRequest $request);
}