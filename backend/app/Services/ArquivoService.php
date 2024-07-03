<?php

namespace App\Services;

use App\Models\Arquivo;
use App\Helpers\MakeAlias;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\ArquivoRepository;

class ArquivoService
{
    use MakeAlias;

    private ArquivoRepository $arquivoRepository;

    public function __construct(ArquivoRepository $arquivoRepository)
    {
        $this->arquivoRepository = $arquivoRepository;
    }

    public function getAllArquivo($request)
    {
        return $this->arquivoRepository->paginate($request->limit, $request->page);
    }

    public function createArquivo($request, $type): JsonResponse
    {

        try {

            $fileData = $request->validated();

            $fileData = $this->uploadArquivo($request->file('file'), $type);

            if ($fileData) {
                DB::beginTransaction();

                $arquivo = $this->arquivoRepository->create($fileData);

                DB::commit();
            }

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.saved',
                            [
                                'model' => 'Arquivo'
                            ]
                        )
                    ],
                    'data' => [
                        'arquivo' => $arquivo
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

    public function uploadArquivo($fileRequest, $type)
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
