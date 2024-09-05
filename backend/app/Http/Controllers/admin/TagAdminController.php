<?php

namespace App\Http\Controllers\admin;


use App\Services\admin\TagAdminService;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class TagAdminController extends Controller
{
    private TagAdminService $tagService;

    public function __construct(TagAdminService $tagService)
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
