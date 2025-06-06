<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {
        $validated = $request->validated();

        User::create($validated);

        return response()->json(['message' => 'Пользователь успешно зарегистрирован'], 201);
    }

    public function login(AuthLoginRequest $request)
    {
        $validated = $request->validated();

        if (!$token = JWTAuth::attempt($validated)) {
            return response()->json(['error' => 'Неверные данные для входа'], 401);
        }

        return response()->json(['message' => 'Вход выполнен успешно'], 200)->cookie('token', $token, 60*24);
    }

    public function logout(Request $request)
    {
        try {
            $token = $request->cookie('token');

            if ($token) {
                JWTAuth::setToken($token)->invalidate();
            }

            return response()->json(['message' => 'Выход выполнен успешно'], 200)
                ->cookie('token', '', -1);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка при выходе'], 500);
        }
    }

    public function me()
    {
        return response()->json(auth()->user());
    }
}
