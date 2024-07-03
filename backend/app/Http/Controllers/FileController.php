<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
use App\Services\FileService;

class FileController extends Controller
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function images(FileRequest $request)
    {
        return $this->fileService->createFile($request,'image');
    }

    public function files(FileRequest $request)
    {
        return $this->fileService->createFile($request,'file');
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->fileService->deleteFile($id);
    }

}
