<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers($request)
    {
        return $this->userRepository->paginate($request->limit,$request->page);
    }

    public function createUser($request): JsonResponse
    {
        try {
            $userData = $request->validated();

            $userData['password'] = bcrypt($userData['password']);

            $userData['role_id'] = 1;

            DB::beginTransaction();

            $user = $this->userRepository->create($userData);

            DB::commit();
            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.saved',
                            [
                                'model' => 'User'
                            ]
                        )
                    ],
                    'data' => [
                        'user' => $user
                    ]
                ],
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e->getCode() == 23505) {
                return response()->json(
                    [
                        'error' => 'Registro duplicado, email e/ou CPF já cadastrado(s).'
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

    public function getUserById($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            return response()->json(
                [
                    'data' => $user
                ],
                Response::HTTP_OK
            );
        } catch (ModelNotFoundException $e){
            return response()->json(
                [
                    'error'=>'Usuário não encontrado.'
                ],
                Response::HTTP_BAD_REQUEST
            );

        }catch (\Exception  $e) {
            return response()->json(
                [
                    'error' => [$e->getMessage()]
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function updateUser($request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $userResponse = $this->userRepository->update($request->validated(), $id);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.updated',
                            [
                                'model' => 'User'
                            ]
                        )
                    ],
                    'data' => [
                        'user' => $userResponse
                    ]
                ],
                Response::HTTP_CREATED
            );
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e->getCode() == 23505) {
                return response()->json(
                    [
                        'error' => 'Registro duplicado, email e/ou CPF já cadastrado(s).'
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

    public function deleteUser($id): JsonResponse
    {
        try {
            $this->userRepository->delete($id);

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.deleted',
                            [
                                'model' => 'User'
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
