<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use App\Repositories\UsuarioRepository;
use App\Http\Requests\UsuarioRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsuarioController extends Controller
{
    private UsuarioRepository $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function index(Request $request)
    {
        return $this->usuarioRepository->searchPaginate($request->filtros, $request->limit, $request->sort);
    }

    public function store(UsuarioRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $usuarioData = $request->validated();

            $usuarioData['role_id'] = 1;

            $usuario = $this->usuarioRepository->create($usuarioData);

            DB::commit();
            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.saved',
                            [
                                'model' => 'Usuario'
                            ]
                        )
                    ],
                    'object' => [
                        'usuario' => $usuario
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
                                    'model' => 'Usuario'
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

    public function show(string $id): JsonResponse
    {
        try {
            $usuario = Usuario::findOrFail($id);

            return response()->json(
                [
                    'object' => $usuario
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

    public function update(UsuarioRequest $request, string $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $usuario = $this->usuarioRepository->findOrFail($id);

            $usuarioResponse = $this->usuarioRepository->update($request->validated(), $usuario->id);

            DB::commit();

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.updated',
                            [
                                'model' => 'Usuario'
                            ]
                        )
                    ],
                    'object' => [
                        'usuario' => $usuarioResponse
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

    public function destroy(int $id): JsonResponse
    {
        try {

            $this->usuarioRepository->delete($id);

            return response()->json(
                [
                    'success' => [
                        'message' => __(
                            'messages.deleted',
                            [
                                'model' => 'Usuario'
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
