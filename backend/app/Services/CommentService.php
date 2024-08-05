<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\CommentRepository;


class CommentService
{
    private CommentRepository $commentRepository;
    protected $request;

    public function __construct(
        CommentRepository $commentRepository,
        Request $request
    ) {
        $this->commentRepository = $commentRepository;
        $this->request = $request;
    }

    public function createComments($request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $commentData = $request->validated();

            $commentData['news_id'] = $id;
            $commentData['user_id'] =  auth()->id();

            $commentsResponse = $this->commentRepository->create($commentData);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.saved',
                            [
                                'model' => 'Comments'
                            ]
                        )
                    ],
                    'data' => [
                        'comments' => $commentsResponse
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

    // public function getCommentsById($id)
    // {
    //     try {
    //         $comments = $this->commentRepository
    //             ->findByAttributeWhitRelation('id', $id)
    //             ->with('commentSchedule')
    //             ->with('tag')
    //             ->firstOrFail();

    //         return response()->json(
    //             [
    //                 'data' => $comments
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

    // public function updateComments($request, $id)
    // {

    //     try {
    //         $commentsData = $this->handlerComment($request);
    //         DB::beginTransaction();

    //         $commentsResponse = $this->commentRepository->update($commentsData, $id);

    //         if ($request->has('schedule')) {
    //              $schedule = $request->input('schedule');
    //              $commentsResponse->syncCommentSchedule($schedule);
    //         }

    //         $commentsResponse->tag()->sync($commentsData['tags']);

    //         DB::commit();

    //         return response()->json(
    //             [
    //                 'success' => [
    //                     'message' => __(
    //                         'messages.updated',
    //                         [
    //                             'model' => 'Comments'
    //                         ]
    //                     )
    //                 ],
    //                 'data' => [
    //                     'comments' => $commentsResponse
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

    // public function deleteComments($id)
    // {
    //     try {

    //         $this->commentRepository->delete($id);

    //         return response()->json(
    //             [
    //                 'success' => [
    //                     'message' => __(
    //                         'messages.deleted',
    //                         [
    //                             'model' => 'Comments'
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
