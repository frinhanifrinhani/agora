<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\AuthRequest;
use App\Services\admin\AuthService;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthRequest $request): JsonResponse
    {
        return $this->authService->login($request);
    }

    public function logout(Request $request): JsonResponse
    {
        return $this->authService->logout($request);
    }
}
