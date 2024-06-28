<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        return $this->categoryService->getAllCategories($request);
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        return $this->categoryService->createCategory($request);
    }

    public function show(string $id): JsonResponse
    {
        return $this->categoryService->getCategoryById($id);
    }

    public function update(CategoryRequest $request, string $id): JsonResponse
    {
        return $this->categoryService->updateCategory($request,$id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->categoryService->deleteCategory($id);
    }
}
