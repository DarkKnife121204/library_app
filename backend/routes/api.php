<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/admin', fn() => response()->json(['msg' => 'Админка']));
});

Route::middleware(['auth:api', 'role:librarian'])->group(function () {
    Route::get('/librarian', fn() => response()->json(['msg' => 'Библиотекарь']));
});

Route::middleware(['auth:api', 'role:user'])->group(function () {
    Route::get('/user', fn() => response()->json(['msg' => 'Профиль пользователя']));
});
