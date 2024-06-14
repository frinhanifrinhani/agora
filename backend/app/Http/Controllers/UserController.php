<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        return $this->userService->getAllUsers($request);
    }

    public function store(UserRequest $request): JsonResponse
    {
        return $this->userService->createUser($request);
    }

    public function show(string $id): JsonResponse
    {
        return $this->userService->getUserById($id);
    }

    public function update(UserRequest $request, string $id): JsonResponse
    {
        return $this->userService->updateUser($request,$id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->userService->deleteUser($id);
    }
}
