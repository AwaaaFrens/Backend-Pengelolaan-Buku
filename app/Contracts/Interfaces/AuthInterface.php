<?php
        
namespace App\Contracts\Interfaces;
        
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

interface AuthInterface 
{
    public function createUser(array $data): User;
    public function findByEmail(string $email): ?User;
}