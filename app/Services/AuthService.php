<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    public function login(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            return Auth::user();
        }

        throw ValidationException::withMessages(['message' => 'Invalid credentials']);
    }

    public function createToken($user)
    {
        return $user->createToken('authToken')->plainTextToken;
    }

    public function logout()
    {
        Auth::logout();
    }
}
