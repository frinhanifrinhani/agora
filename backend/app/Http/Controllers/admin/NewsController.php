<?php

namespace App\Http\Controllers\admin;


use Illuminate\Http\Request;
use App\Services\admin\NewsService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\NewsRequest;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    private NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index(Request $request)
    {
        return $this->newsService->getAllNews($request);
    }

    public function store(NewsRequest $request)
    {
        return $this->newsService->createNews($request);
    }

    public function show(string $id): JsonResponse
    {
        return $this->newsService->getNewsById($id);
    }

    public function update(NewsRequest $request, int $id): JsonResponse
    {
        return $this->newsService->updateNews($request, $id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->newsService->deleteNews($id);
    }
}
