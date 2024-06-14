<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private UserRepository $userRepository;
    private AuthService $authService;

    public function __construct(UserRepository $userRepository, AuthService $authService)
    {
        $this->userRepository = $userRepository;
        $this->authService = $authService;
    }

    public function login(Request $request): JsonResponse
    {
        return $this->authService->login($request);
    }

    public function logout(Request $request): JsonResponse
    {
        return $this->authService->logout($request);
    }
}
