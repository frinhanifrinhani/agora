<?php

namespace App\Services;


use Carbon\Carbon;
use App\Models\News;
use App\Helpers\MakeAlias;
use App\Helpers\DateHelper;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\NewsRepository;
use Illuminate\Support\Facades\Auth;


class NewsService
{
    use MakeAlias;
    use DateHelper;

    private NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function getAllNews($request)
    {
        return $this->newsRepository->paginate($request->limit, $request->page);
    }

    public function createNews($request): JsonResponse
    {
        try {
            $newsData = $request->validated();

            if ($newsData['publicated']) {
                $newsData['publication_date'] = $this->getNow();
            }

            $newsAlias = $this->stringToAlias($newsData['title']);

            $newsData['alias'] = $newsAlias;
            $newsData['user_id'] = auth()->id();

            DB::beginTransaction();

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

            $newsData = $request->validated();

            $newsAlias = $this->stringToAlias($newsData['title']);

            $newsData['alias'] = $newsAlias;
            $newsData['user_id'] = auth()->id();

            $newsResponse = $this->newsRepository->update($newsData, $id);

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
