<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\AuthRequest;
use App\Services\admin\AuthAdminService;
use App\Http\Controllers\Controller;

class AuthAdminController extends Controller
{
    private AuthAdminService $authAdminService;

    public function __construct(AuthAdminService $authAdminService)
    {
        $this->authAdminService = $authAdminService;
    }

    public function login(AuthRequest $request): JsonResponse
    {
        return $this->authAdminService->login($request);
    }

    public function logout(Request $request): JsonResponse
    {
        return $this->authAdminService->logout($request);
    }
}
