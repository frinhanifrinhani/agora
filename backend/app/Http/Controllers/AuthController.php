<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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

        try {
            $user = Auth::guard('sanctum')->user();
            if ($user) {
                $user->currentAccessToken()->delete();

                return response()->json(
                    [
                        'message' => 'Logout realizado com sucesso!'
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => $e->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }
}
