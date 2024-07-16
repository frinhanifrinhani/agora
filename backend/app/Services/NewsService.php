<?php

namespace App\Services;


use Carbon\Carbon;
use App\Models\News;
use App\Helpers\MakeAlias;
use App\Helpers\DateHelper;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\NewsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NewsService
{
    use MakeAlias;
    use DateHelper;

    private NewsRepository $newsRepository;
    protected $request;

    public function __construct(NewsRepository $newsRepository,Request $request )
    {
        $this->newsRepository = $newsRepository;
        $this->request = $request;
    }

    public function getAllNews($request)
    {
        return $this->newsRepository->paginate($request->limit, $request->page);
    }

    public function createNews($request): JsonResponse
    {
        try {

            $newsData = $this->handlerNews($request);

            DB::beginTransaction();

            $newsResponse = $this->newsRepository->create($newsData);

            $newsResponse->category()->sync($newsData['categories']);
            $newsResponse->tag()->sync($newsData['tags']);

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
                        'news' => $newsResponse
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
            $news = $this->newsRepository->findByAttributeWhitRelation('id',$id)
            ->with('category')
            ->firstOrFail();

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
            $newsData = $this->handlerNews($request);
            DB::beginTransaction();

            $newsResponse = $this->newsRepository->update($newsData, $id);

            $newsResponse->category()->sync($newsData['categories']);
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

    private function handlerNews($request)
    {
        $newsData = $request->validated();

        if ($newsData['publicated']) {
            $newsData['publication_date'] = $this->getNow();
        }

        $newsAlias = $this->stringToAlias($newsData['title']);

        $newsData['alias'] = $newsAlias;
        $this->request->isMethod('post') ? $newsData['user_id'] = auth()->id() : null;

        return $newsData;
    }
}
