<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\CommentRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;


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

    public function createComments($request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $commentData = $request->validated();

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

    public function updateComments($request, $id)
    {

        try {
            DB::beginTransaction();

            $commentData = $request->validated();

            $comment = $this->commentRepository->findByAttribute('id', $id);

            if($comment->user_id != auth()->id()){
                throw new HttpException(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    'Este comentário pertence a outro usuário.'
                );
            }

            $commentsResponse = $this->commentRepository->update($commentData, $id);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.updated',
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
            return response()->json(
                [
                    'error' => [$e->getMessage()]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function deleteComments($id)
    {
        try {

            $comment = $this->commentRepository->findByAttribute('id', $id);

            if($comment->user_id != auth()->id()){
                throw new HttpException(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    'Este comentário pertence a outro usuário.'
                );
            }

            $this->commentRepository->delete($id);

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.deleted',
                            [
                                'model' => 'Comments'
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
