<?php

namespace App\Contracts;

interface AuthServiceInterface
{
    public function login(array $credentials);

    public function createToken($user);

    public function logout();
}
