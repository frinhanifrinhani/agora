<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use App\Services\TagService;

class TagController extends Controller
{
    private TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index(Request $request)
    {
        return $this->tagService->getAllTag($request);
    }

    public function store(TagRequest $request)
    {
        return $this->tagService->createTag($request);
    }

    public function show(string $id): JsonResponse
    {
        return $this->tagService->getTagById($id);
    }

    public function update(TagRequest $request, int $id): JsonResponse
    {
        return $this->tagService->updateTag($request, $id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->tagService->deleteTag($id);
    }
}
