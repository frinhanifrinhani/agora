<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\NewsRequest;
use App\Services\NewsService;

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

    public function newsByAlias(string $alias): JsonResponse
    {
        return $this->newsService->getNewsByAlias($alias);
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
