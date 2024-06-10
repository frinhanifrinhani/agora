<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Repositories\NoticiaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\NoticiaRequest;

class NoticiaController extends Controller
{
    private NoticiaRepository $noticiaRepository;

    public function __construct(NoticiaRepository $noticiaRepository)
    {
        $this->noticiaRepository = $noticiaRepository;
    }

    public function index(Request $request)
    {
        return $this->noticiaRepository->searchPaginate($request->filtros, $request->limit, $request->sort);
    }

    public function store(NoticiaRequest $request)
    {

        try {
            DB::beginTransaction();

            $noticiaData = $request->validated();

            $noticiaData['status'] = true;

            $noticia = $this->noticiaRepository->create($noticiaData);

            DB::commit();
            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.saved',
                            [
                                'model' => 'Noticia'
                            ]
                        )
                    ],
                    'object' => [
                        'noticia' => $noticia
                    ]
                ],
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {

            if ($e->getCode() == 23505) {
                return response()->json(
                    [
                        'error' => [
                            'message' =>
                            __(
                                'messages.erro.duplicateError',
                                [
                                    'model' => 'Noticia'
                                ]
                            )
                        ]
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            return response()->json(
                [
                    'error' => [$e->getMessage()]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            $noticia = Noticia::findOrFail($id);

            return response()->json(
                [
                    'object' => $noticia
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
    public function update(NoticiaRequest $request, int $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $noticia = $this->noticiaRepository->findOrFail($id);

            $this->noticiaRepository->update($request->validated(), $noticia->id);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.updated',
                            [
                                'model' => 'Noticia'
                            ]
                        )
                    ],
                    'object' => [
                        'noticia' => $noticia
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

    public function destroy(int $id): JsonResponse
    {
        try {

            $this->noticiaRepository->delete($id);

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.deleted',
                            [
                                'model' => 'Noticia'
                            ]
                        )
                    ]
                ],
                Response::HTTP_OK
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
}
