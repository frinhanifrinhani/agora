<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\NewsCommentRepository;


class NewsCommentService
{
    private NewsCommentRepository $newsCommentRepository;
    protected $request;

    public function __construct(
        NewsCommentRepository $newsCommentRepository,
        Request $request
    ) {
        $this->newsCommentRepository = $newsCommentRepository;
        $this->request = $request;
    }

    public function createNewsComments($request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $newsCommentData = $request->validated();

            $newsCommentData['news_id'] = $id;
            $newsCommentData['user_id'] =  auth()->id();

            $newsCommentsResponse = $this->newsCommentRepository->create($newsCommentData);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.saved',
                            [
                                'model' => 'NewsComments'
                            ]
                        )
                    ],
                    'data' => [
                        'newsComments' => $newsCommentsResponse
                    ]
                ],
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {

            if ($e->getCode() == 23503) {
                return response()->json(
                    [
                        'error' => [
                            'message' =>
                            __(
                                'messages.erro.invalidForeignKey',
                                [
                                    'model' => 'Events'
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

    // public function getNewsCommentsById($id)
    // {
    //     try {
    //         $newsComments = $this->newsCommentRepository
    //             ->findByAttributeWhitRelation('id', $id)
    //             ->with('newsCommentSchedule')
    //             ->with('tag')
    //             ->firstOrFail();

    //         return response()->json(
    //             [
    //                 'data' => $newsComments
    //             ],
    //             Response::HTTP_OK
    //         );
    //     } catch (\Exception  $e) {
    //         return response()->json(
    //             [
    //                 'error' => [$e->getMessage()]
    //             ],
    //             Response::HTTP_BAD_REQUEST
    //         );
    //     }
    // }

    // public function updateNewsComments($request, $id)
    // {

    //     try {
    //         $newsCommentsData = $this->handlerNewsComment($request);
    //         DB::beginTransaction();

    //         $newsCommentsResponse = $this->newsCommentRepository->update($newsCommentsData, $id);

    //         if ($request->has('schedule')) {
    //              $schedule = $request->input('schedule');
    //              $newsCommentsResponse->syncNewsCommentSchedule($schedule);
    //         }

    //         $newsCommentsResponse->tag()->sync($newsCommentsData['tags']);

    //         DB::commit();

    //         return response()->json(
    //             [
    //                 'success' => [
    //                     'message' => __(
    //                         'messages.updated',
    //                         [
    //                             'model' => 'NewsComments'
    //                         ]
    //                     )
    //                 ],
    //                 'data' => [
    //                     'newsComments' => $newsCommentsResponse
    //                 ]
    //             ],
    //             Response::HTTP_CREATED
    //         );
    //     } catch (\Exception $e) {
    //         return response()->json(
    //             [
    //                 'error' => [$e->getMessage()]
    //             ],
    //             Response::HTTP_BAD_REQUEST
    //         );
    //     }
    // }

    // public function deleteNewsComments($id)
    // {
    //     try {

    //         $this->newsCommentRepository->delete($id);

    //         return response()->json(
    //             [
    //                 'success' => [
    //                     'message' => __(
    //                         'messages.deleted',
    //                         [
    //                             'model' => 'NewsComments'
    //                         ]
    //                     )
    //                 ]
    //             ],
    //             Response::HTTP_OK
    //         );
    //     } catch (\Exception $e) {
    //         return response()->json(
    //             [
    //                 'error' => [$e->getMessage()]
    //             ],
    //             Response::HTTP_BAD_REQUEST
    //         );
    //     }
    // }


}
