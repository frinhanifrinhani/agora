<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\admin\CategoryAdminService;

class CategoryAdminController extends Controller
{
    private CategoryAdminService $categoryAdminService;

    public function __construct(CategoryAdminService $categoryAdminService)
    {
        $this->categoryAdminService = $categoryAdminService;
    }

    public function index(Request $request)
    {
        return $this->categoryAdminService->getAllCategories($request);
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        return $this->categoryAdminService->createCategory($request);
    }

    public function show(string $id): JsonResponse
    {
        return $this->categoryAdminService->getCategoryById($id);
    }

    public function update(CategoryRequest $request, string $id): JsonResponse
    {
        return $this->categoryAdminService->updateCategory($request,$id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->categoryAdminService->deleteCategory($id);
    }
}
