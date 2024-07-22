<?php

namespace App\Services;

use App\Models\File;
use App\Helpers\MakeAlias;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\FileRepository;
use Illuminate\Support\Facades\Storage;

class FileService
{
    use MakeAlias;

    private FileRepository $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function getAllFiles($request,$type)
    {
        return $this->fileRepository->paginate($request->limit, $request->page,$type);
    }

    public function createFile($request, $type): JsonResponse
    {

        try {

            $fileData = $request->validated();

            $fileData = $this->uploadFile($request->file('file'), $type);

            if ($fileData) {
                DB::beginTransaction();

                $file = $this->fileRepository->create($fileData);

                DB::commit();
            }

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.saved',
                            [
                                'model' => 'File'
                            ]
                        )
                    ],
                    'data' => [
                        'file' => $file
                    ]
                ],
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {

            return response()->json(
                [
                    'error' => [$e->getMessage()]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function getFileById($id)
    {

        try {
            $file = $this->fileRepository->findOrFailByAttribute('id',$id);

            return response()->json(
                [
                    'data' => $file
                ],
                Response::HTTP_OK
            );
        } catch (\Exception  $e) {
            return response()->json(
                [
                    'error' => [$e->getMessage()]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function deleteFile($id)
    {

        try {
            $file = $this->fileRepository->findOrFail($id);

            $deleted = Storage::delete($file->full_path);

            if ($deleted) {
                $this->fileRepository->delete($id);

                return response()->json(
                    [
                        'success' => [
                            'message' => __(
                                'messages.deleted',
                                [
                                    'model' => 'File'
                                ]
                            )
                        ]
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => [$e->getMessage()]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function uploadFile($fileRequest, $type)
    {

        try {

            $storagePath = 'upload/' . $type;

            $originalName = $fileRequest->getClientOriginalName();

            $fileNameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
            $originalExtension = $fileRequest->getClientOriginalExtension();

            $file = $this->stringToAlias($fileNameWithoutExtension);

            $file = $file . '-' . time() . '.' . $originalExtension;

            $path = $fileRequest->storeAs($storagePath, $file);

            if ($path) {

                $fileData = [
                    'name' => $fileNameWithoutExtension,
                    'path' => $storagePath,
                    'full_path' => $path,
                    'file' =>  $file,
                    'type' =>  $type,
                    'size' => $fileRequest->getSize(),
                    'extension' => $originalExtension,
                ];

                return $fileData;
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'error' => $e->getMessage()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
