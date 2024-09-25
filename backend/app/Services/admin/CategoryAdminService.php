<?php

namespace App\Services\admin;

use App\Helpers\MakeAlias;
use App\Constants\Entities;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryAdminService
{

    use MakeAlias;

    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories($request)
    {
        return $this->categoryRepository->paginate($request->limit, $request->page);
    }

    public function createCategory($request): JsonResponse
    {
        try {
            $categoryData = $request->validated();

            $categoryAlias = $this->stringToAlias($categoryData['name']);

            $categoryData['alias'] = $categoryAlias;

            DB::beginTransaction();

            $category = $this->categoryRepository->create($categoryData);

            DB::commit();
            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.saved',
                            [
                                'model' => ucfirst(Entities::CATEGORY)
                            ]
                        )
                    ],
                    'data' => [
                        'category' => $category
                    ]
                ],
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollBack();

            if ($e->getCode() == 23505) {
                return response()->json(
                    [
                        'error' => [
                            'message' =>
                            __(
                                'messages.erro.duplicateError',
                                [
                                    'model' =>  ucfirst(Entities::CATEGORY)
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

    public function getCategoryById($id): JsonResponse
    {
        try {
            $category = $this->categoryRepository->findOrFailByAttribute('id', $id);

            return response()->json(
                [
                    'data' => $category
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
                                'model' => ucfirst(Entities::CATEGORY),
                            ]
                        )
                    ]
                ],
                Response::HTTP_BAD_REQUEST
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

    public function updateCategory($request, $id): JsonResponse
    {
        try {

            $categoryData = $request->validated();

            $categoryAlias = $this->stringToAlias($categoryData['name']);

            $categoryData['alias'] = $categoryAlias;

            DB::beginTransaction();

            $categoryResponse = $this->categoryRepository->update($categoryData, $id);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.updated',
                            [
                                'model' => ucfirst(Entities::CATEGORY)
                            ]
                        )
                    ],
                    'data' => [
                        'category' => $categoryResponse
                    ]
                ],
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollBack();

            if ($e->getCode() == 23505) {
                return response()->json(
                    [
                        'error' => [
                            'message' =>
                            __(
                                'messages.erro.duplicateError',
                                [
                                    'model' =>  ucfirst(Entities::CATEGORY)
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

    public function deleteCategory($id): JsonResponse
    {
        try {
            $this->categoryRepository->delete($id);

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.deleted',
                            [
                                'model' => ucfirst(Entities::CATEGORY)
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
                                'model' => ucfirst(Entities::CATEGORY),
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

    public function publishCategory($id): JsonResponse
    {
        try {

            $categoryData['status'] = 1;

            DB::beginTransaction();

            $categoryResponse = $this->categoryRepository->update($categoryData, $id);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.publish',
                            [
                                'model' => ucfirst(Entities::CATEGORY)
                            ]
                        )
                    ],
                    'data' => [
                        'category' => $categoryResponse
                    ]
                ],
                Response::HTTP_CREATED
            );

        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'error' => [
                        'message' =>
                        __(
                            'messages.erro.notFound',
                            [
                                'model' => ucfirst(Entities::CATEGORY),
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
                    'error' => [$e->getMessage()]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function unpublishCategory($id): JsonResponse
    {
        try {

            $categoryData['status'] = 0;

            DB::beginTransaction();

            $categoryResponse = $this->categoryRepository->update($categoryData, $id);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.unpublish',
                            [
                                'model' => ucfirst(Entities::CATEGORY)
                            ]
                        )
                    ],
                    'data' => [
                        'category' => $categoryResponse
                    ]
                ],
                Response::HTTP_CREATED
            );

        } catch (ModelNotFoundException $e) {
            return response()->json(
                [
                    'error' => [
                        'message' =>
                        __(
                            'messages.erro.notFound',
                            [
                                'model' => ucfirst(Entities::CATEGORY),
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
                    'error' => [$e->getMessage()]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
