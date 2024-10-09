<?php

namespace App\Services\admin;

use App\Helpers\MakeAlias;
use App\Constants\Entities;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\TagRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TagAdminService
{
    use MakeAlias;

    private TagRepository $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTag($request)
    {
        return $this->tagRepository->paginate($request->limit, $request->page);
    }


    public function tagsToChoice()
    {
        $tagResponse = $this->tagRepository->all();

        return response()->json(
            [
                'data' => $tagResponse,
                'total' => $tagResponse->count()
            ],
            Response::HTTP_OK
        );
    }

    public function createTag($request): JsonResponse
    {
        try {
            $tagData = $request->validated();

            $tagAlias = $this->stringToAlias($tagData['name']);

            $tagData['alias'] = $tagAlias;

            DB::beginTransaction();

            $tag = $this->tagRepository->create($tagData);

            DB::commit();
            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.saved',
                            [
                                'model' => ucfirst(Entities::TAG),
                            ]
                        )
                    ],
                    'data' => [
                        'tag' => $tag
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
                                    'model' => ucfirst(Entities::TAG),
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

    public function getTagById($id)
    {

        try {
            $tag = $this->tagRepository->findOrFail($id);

            return response()->json(
                [
                    'data' => $tag
                ],
                Response::HTTP_OK
            );
        } catch (ModelNotFoundException  $e) {
            return response()->json(
                [
                    'error' => [
                        'message' =>
                        __(
                            'messages.erro.notFound',
                            [
                                'model' => ucfirst(Entities::TAG),
                            ]
                        )
                    ]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function updateTag($request, $id)
    {
        try {

            $tagData = $request->validated();

            $tagAlias = $this->stringToAlias($tagData['name']);

            $tagData['alias'] = $tagAlias;

            DB::beginTransaction();

            $tagResponse = $this->tagRepository->update($tagData, $id);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.updated',
                            [
                                'model' => ucfirst(Entities::TAG),
                            ]
                        )
                    ],
                    'data' => [
                        'tag' => $tagResponse
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
                                    'model' => ucfirst(Entities::TAG),
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

    public function deleteTag($id)
    {
        try {

            $this->tagRepository->delete($id);

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.deleted',
                            [
                                'model' => ucfirst(Entities::TAG),
                            ]
                        )
                    ]
                ],
                Response::HTTP_OK
            );
        } catch (ModelNotFoundException  $e) {
            return response()->json(
                [
                    'error' => [
                        'message' =>
                        __(
                            'messages.erro.notFound',
                            [
                                'model' => ucfirst(Entities::TAG),
                            ]
                        )
                    ]
                ],
                Response::HTTP_BAD_REQUEST
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
