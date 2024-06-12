<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Repositories\NewsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\NewsRequest;

class NewsController extends Controller
{
    private NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function index(Request $request)
    {
        return $this->newsRepository->searchPaginate($request->filtros, $request->limit, $request->sort);
    }

    public function store(NewsRequest $request)
    {

        try {
            DB::beginTransaction();

            $newsData = $request->validated();

            $newsData['status'] = true;

            $news = $this->newsRepository->create($newsData);

            DB::commit();
            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.saved',
                            [
                                'model' => 'News'
                            ]
                        )
                    ],
                    'object' => [
                        'news' => $news
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
                                    'model' => 'News'
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
            $news = News::findOrFail($id);

            return response()->json(
                [
                    'object' => $news
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
    public function update(NewsRequest $request, int $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $news = $this->newsRepository->findOrFail($id);

            $newsResponse = $this->newsRepository->update($request->validated(), $news->id);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.updated',
                            [
                                'model' => 'News'
                            ]
                        )
                    ],
                    'object' => [
                        'news' => $newsResponse
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

            $this->newsRepository->delete($id);

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.deleted',
                            [
                                'model' => 'News'
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
