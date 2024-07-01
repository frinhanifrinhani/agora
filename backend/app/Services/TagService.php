<?php

namespace App\Services;

use App\Helpers\StringToUrl;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\TagRepository;

class TagService
{
    private TagRepository $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTag($request)
    {
        return $this->tagRepository->paginate($request->limit,$request->page);
    }

    public function createTag($request): JsonResponse
    {
        try {
            $tagData = $request->validated();

            $stringToUrl = new StringToUrl();
            $tag = $stringToUrl->stringToUrl($tagData['name']);

            $tagData['tag'] = $tag;

            DB::beginTransaction();

            $tag = $this->tagRepository->create($tagData);

            DB::commit();
            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.saved',
                            [
                                'model' => 'Tag'
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
                                    'model' => 'Tag'
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
            $tag = Tag::findOrFail($id);

            return response()->json(
                [
                    'data' => $tag
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

    public function updateTag($request, $id)
    {
        try {

            $tagData = $request->validated();

            $stringToUrl = new StringToUrl();
            $tag = $stringToUrl->stringToUrl($tagData['name']);

            $tagData['tag'] = $tag;

            DB::beginTransaction();

            $tagResponse = $this->tagRepository->update($tagData,$id);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.updated',
                            [
                                'model' => 'Tag'
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
                                    'model' => 'Tag'
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
                                'model' => 'Tag'
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
