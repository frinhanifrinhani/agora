<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{

    public function login($request): JsonResponse
    {
        try {

            $credentials = $request->validated();

            if (Auth::guard('web')->attempt($credentials)) {
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

    public function logout(Request $request)
    {
        try {

            if (Auth::check()) {

                $request->user()->currentAccessToken()->delete();

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
