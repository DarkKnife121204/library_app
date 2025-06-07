<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{user}', [UserController::class, 'show']);
    Route::post('/user', [UserController::class, 'store']);
    Route::post('/user/{user}', [UserController::class, 'update']);
    Route::delete('/user/{user}', [UserController::class, 'destroy']);
});

Route::middleware(['auth:api', 'role:librarian'])->group(function () {
    Route::post('/book', [BookController::class, 'store']);
    Route::delete('/book/{book}', [BookController::class, 'destroy']);
    Route::get('/reservation', [ReservationController::class, 'index']);
    Route::get('/reservation/{reservation}', [ReservationController::class, 'show']);
});

Route::middleware(['auth:api', 'role:user'])->group(function () {
    Route::get('/book', [BookController::class, 'index']);
    Route::get('/book/{book}', [BookController::class, 'show']);
    Route::post('/reservation', [ReservationController::class, 'reserve']);
    Route::get('/book/{book}/comment', [CommentController::class, 'show']);
    Route::post('/comment', [CommentController::class, 'store']);
});

Route::middleware(['auth:api', 'role:user,librarian'])->group(function () {
    Route::patch('/reservation/{id}/status', [ReservationController::class, 'updateStatus']);
});
