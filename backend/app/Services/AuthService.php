<?php

namespace App\Services;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Repositories\NewsRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{

    public function login($request): JsonResponse
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

                $token = $request->user()->createToken('token')->plainTextToken;

                //$request->session()->regenerate();
                return response()->json(
                    [
                        'message' => 'Login realizado com suscesso!',
                        'user' => $user,
                        'token' =>  $token
                    ],
                    Response::HTTP_OK
                )->withCookie(cookie('agora_cookies', $token, 720));
            }

            return response()->json(
                [
                    'errors' => 'E-mail e/ou senha incorreto(s).'
                ],
                Response::HTTP_UNAUTHORIZED
            );
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->toArray();
            return response()->json(
                [
                    'errors' => $errors
                ],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
    }

    public function logout()
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
                    'error' => $e->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }
}
