<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
=======
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Repositories\UserRepository;
>>>>>>> d5310db57f4e7d8b1fdbe4288624df4163d0a385
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
<<<<<<< HEAD
=======
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $userData = $request->validated();

            $userData['password'] = bcrypt($userData['password']);

            $userData['role_id'] = 1;

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
                    'object' => [
                        'user' => $user
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
                                    'model' => 'User'
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
>>>>>>> d5310db57f4e7d8b1fdbe4288624df4163d0a385

    public function login(Request $request): JsonResponse
    {

        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(
                [
                    'message' => $errors
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $request->user()->createToken('token')->plainTextToken;

            //$request->session()->regenerate();
            return response()->json(
                [
                    'message' => 'Login successfully!',
                    'user' => $user,
                    'token' =>  $token
                ],
                Response::HTTP_OK
            )->withCookie(cookie('payments_cookie', $token, 720));
        }

        return response()->json(
            [
                'message' => 'Incorrect email or password.'
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json(
            [
                'message' => 'Logout successful!'
            ],
            Response::HTTP_OK
        );
    }
}
