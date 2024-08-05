<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Services\CommentService;

class CommentController extends Controller
{
    private CommentService $newsService;

    public function __construct(CommentService $newsService)
    {
        $this->newsService = $newsService;
    }


    public function stores(CommentRequest $request, int $id)
    {
        return $this->newsService->createComments($request, $id);
    }

    // public function show(string $id): JsonResponse
    // {
    //     return $this->newsService->getCommentsById($id);
    // }

    // public function update(CommentRequest $request, int $id): JsonResponse
    // {
    //     return $this->newsService->updateComments($request, $id);
    // }

    // public function destroy(int $id): JsonResponse
    // {
    //     return $this->newsService->deleteComments($id);
    // }
}
