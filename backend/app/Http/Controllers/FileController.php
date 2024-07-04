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

    public function files(Request $request)
    {
        return $this->fileService->getAllFiles($request,'file');
    }

    public function images(Request $request)
    {
        return $this->fileService->getAllFiles($request,'image');
    }

    public function creteImage(FileRequest $request)
    {
        return $this->fileService->createFile($request,'image');
    }

    public function creteFile(FileRequest $request)
    {
        return $this->fileService->createFile($request,'file');
    }

    public function show(int $id)
    {
        return $this->fileService->getFileById($id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->fileService->deleteFile($id);
    }

}
