<?php

namespace App\Http\Controllers;

use App\Contracts\AuthServiceInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\LoginRequest;
use Illuminate\Validation\ValidationException;

class AuthenticantionController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $user = $this->authService->login($credentials);
            if ($user) {
                $token = $this->authService->createToken($user);
                $data = ['user' => $user, 'token' => $token];

                return ResponseHelper::success(true, 'Login Successfully', $data, $code = 200);
            }
        } catch (ValidationException $e) {
            // Invalid credentials or other validation errors
            return ResponseHelper::error(false, 'Invalid credentials', 401);
        } catch (\Exception $e) {
            // Other unexpected errors
            return ResponseHelper::error(false, 'Unable to login, please try again', 500);
        }
    }

    public function logout()
    {
        $this->authService->logout();

        return ResponseHelper::success(true, 'logged out successfully', null, 200);
    }
}
