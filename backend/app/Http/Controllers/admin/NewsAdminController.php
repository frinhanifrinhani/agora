<?php

namespace App\Http\Controllers\admin;


use Illuminate\Http\Request;
use App\Services\admin\NewsAdminService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\NewsRequest;
use App\Http\Controllers\Controller;

class NewsAdminController extends Controller
{
    private NewsAdminService $newsAdminService;

    public function __construct(NewsAdminService $newsAdminService)
    {
        $this->newsAdminService = $newsAdminService;
    }

    public function index(Request $request)
    {
        return $this->newsAdminService->getAllNews($request);
    }

    public function store(NewsRequest $request)
    {
        return $this->newsAdminService->createNews($request);
    }

    public function show(string $id): JsonResponse
    {
        return $this->newsAdminService->getNewsById($id);
    }

    public function update(NewsRequest $request, int $id): JsonResponse
    {
        return $this->newsAdminService->updateNews($request, $id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->newsAdminService->deleteNews($id);
    }

    public function publish(int $id): JsonResponse
    {
        return $this->newsAdminService->publishNews($id);
    }

    public function unpublish(int $id): JsonResponse
    {
        return $this->newsAdminService->unpublishNews($id);
    }
}
