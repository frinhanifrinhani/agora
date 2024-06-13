<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

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
