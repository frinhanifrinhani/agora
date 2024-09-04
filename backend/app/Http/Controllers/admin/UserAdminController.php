<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\UserRequest;
use App\Services\admin\UserAdminService;
use App\Http\Controllers\Controller;

class UserAdminController extends Controller
{
    private UserAdminService $userAdminService;

    public function __construct(UserAdminService $userAdminService)
    {
        $this->userAdminService = $userAdminService;
    }

    public function index(Request $request)
    {
        return $this->userAdminService->getAllUsers($request);
    }

    public function store(UserRequest $request): JsonResponse
    {
        return $this->userAdminService->createUser($request);
    }

    public function show(string $id): JsonResponse
    {
        return $this->userAdminService->getUserById($id);
    }

    public function update(UserRequest $request, string $id): JsonResponse
    {
        return $this->userAdminService->updateUser($request,$id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->userAdminService->deleteUser($id);
    }
}
