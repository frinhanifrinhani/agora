<?php

namespace App\Services;

use App\Helpers\MakeAlias;
use App\Constants\Entities;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CommentService
{
    use MakeAlias;
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

            $this->compareComment($commentData, $request);

            $commentsResponse = $this->commentRepository->create($commentData);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.saved',
                            [
                                'model' => ucfirst(Entities::COMMENT),
                            ]
                        )
                    ],
                    'data' => [
                        'comment' => $commentsResponse
                    ]
                ],
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollBack();
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

    public function updateComments($request, $id)
    {

        try {
            DB::beginTransaction();

            $commentData = $request->validated();

            $comment = $this->commentRepository->findOrFail($id);

            if ($comment->user_id != auth()->id()) {
                return response()->json(
                    [
                        'error' => [
                            'message' => 'Este comentário pertence a outro usuário.'
                        ]
                    ],
                    Response::HTTP_FORBIDDEN
                );
            }

            $this->compareComment($commentData, $request);

            $commentsResponse = $this->commentRepository->update($commentData, $id);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.updated',
                            [
                                'model' => ucfirst(Entities::COMMENT),
                            ]
                        )
                    ],
                    'data' => [
                        'comment' => $commentsResponse
                    ]
                ],
                Response::HTTP_CREATED
            );
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json(
                [
                    'error' => [
                        'message' =>
                        __(
                            'messages.erro.notFound',
                            [
                                'model' => ucfirst(Entities::COMMENT),
                            ]
                        )
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Exception $e) {
            DB::rollBack();
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

    private function compareComment($commentData, $request)
    {
        $userComments = $this->commentRepository->findByAttributes([
            'user_id' => auth()->id(),
            'news_id' => $request->news_id
        ]);

        $commentData = $this->stringToAlias($commentData['description']);


        foreach ($userComments as $userComment) {

            if ($this->stringToAlias($userComment['description']) == $commentData) {
                throw new HttpException(Response::HTTP_BAD_REQUEST, 'Você já fez este comentário.');
            }
        }
    }

    public function deleteComments($id)
    {
        try {

            $comment = $this->commentRepository->findOrFail($id);

            if ($comment->user_id != auth()->id()) {
                return response()->json(
                    [
                        'error' => [
                            'message' => 'Este comentário pertence a outro usuário.'
                        ]
                    ],
                    Response::HTTP_FORBIDDEN
                );
            }

            $this->commentRepository->delete($id);

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.deleted',
                            [
                                'model' => ucfirst(Entities::COMMENT),
                            ]
                        )
                    ]
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
                                'model' => ucfirst(Entities::COMMENT),
                            ]
                        )
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        } catch (\Exception $e) {

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
