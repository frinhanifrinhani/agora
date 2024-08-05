<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\NewsCommentRequest;
use App\Services\NewsCommentService;

class NewsCommentController extends Controller
{
    private NewsCommentService $newsService;

    public function __construct(NewsCommentService $newsService)
    {
        $this->newsService = $newsService;
    }


    public function stores(NewsCommentRequest $request, int $id)
    {
        return $this->newsService->createNewsComments($request, $id);
    }

    // public function show(string $id): JsonResponse
    // {
    //     return $this->newsService->getNewsCommentsById($id);
    // }

    // public function update(NewsCommentRequest $request, int $id): JsonResponse
    // {
    //     return $this->newsService->updateNewsComments($request, $id);
    // }

    // public function destroy(int $id): JsonResponse
    // {
    //     return $this->newsService->deleteNewsComments($id);
    // }
}
