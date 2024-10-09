<?php

namespace App\Http\Controllers\admin;


use App\Services\admin\TagAdminService;
use Illuminate\Http\Request;
use App\Http\Requests\TagRequest;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class TagAdminController extends Controller
{
    private TagAdminService $tagAdminService;

    public function __construct(TagAdminService $tagAdminService)
    {
        $this->tagAdminService = $tagAdminService;
    }

    public function index(Request $request)
    {
        return $this->tagAdminService->getAllTag($request);
    }

    public function tagsToChoice()
    {
        return $this->tagAdminService->tagsToChoice();
    }

    public function store(TagRequest $request)
    {
        return $this->tagAdminService->createTag($request);
    }

    public function show(string $id): JsonResponse
    {
        return $this->tagAdminService->getTagById($id);
    }

    public function update(TagRequest $request, int $id): JsonResponse
    {
        return $this->tagAdminService->updateTag($request, $id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->tagAdminService->deleteTag($id);
    }
}
