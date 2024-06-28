<?php

namespace App\Services;

use App\Repositories\NewsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\News;

class NewsService
{
    private NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function getAllNews($request)
    {
        return $this->newsRepository->paginate($request->limit,$request->page);
    }

    public function createNews($request): JsonResponse
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
                    'data' => [
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

    public function getNewsById($id)
    {

        try {
            $news = News::findOrFail($id);

            return response()->json(
                [
                    'data' => $news
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

    public function updateNews($request, $id)
    {

        try {
            DB::beginTransaction();

            $newsResponse = $this->newsRepository->update($request->validated(),$id);

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
                    'data' => [
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

    public function deleteNews($id)
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
