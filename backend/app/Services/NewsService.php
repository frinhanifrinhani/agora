<?php

namespace App\Services;


use App\Helpers\MakeAlias;
use App\Constants\Entities;
use App\Helpers\DateHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\NewsRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class NewsService
{
    use MakeAlias;
    use DateHelper;

    private NewsRepository $newsRepository;
    protected $request;

    public function __construct(NewsRepository $newsRepository, Request $request)
    {
        $this->newsRepository = $newsRepository;
        $this->request = $request;
    }

    public function getAllNews($request)
    {
        return $this->newsRepository->paginate($request->limit, $request->page,true);
    }

    public function getNewsByAlias($alias)
    {
        try {
            $news = $this->newsRepository->findByAttributeWhitRelation('alias', $alias)
                ->with('category')
                ->with('tag')
                ->with('comment')
                ->with('comment.user')
                ->firstOrFail();

            return response()->json(
                [
                    'data' => $news
                ],
                Response::HTTP_OK
            );
        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'error' => [
                        'message' =>
                        __(
                            'messages.erro.notFound',
                            [
                                'model' => ucfirst(Entities::NEWS),
                            ]
                        )
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Exception  $e) {
            return response()->json(
                [
                    'error' => [
                        'message' => $e->getMessage()
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}