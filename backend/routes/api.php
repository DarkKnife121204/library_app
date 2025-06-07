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
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/user/{user}', [UserController::class, 'store']);
    Route::delete('/user/{user}', [UserController::class, 'destroy']);
    Route::post('/user/password/{user}', [UserController::class, 'password']);
    Route::post('/user/password/email/{user}', [UserController::class, 'email']);
});

Route::middleware(['auth:api', 'role:librarian'])->group(function () {
    Route::post('/book/{book}', [BookController::class, 'store']);
    Route::delete('/book/{book}', [BookController::class, 'destroy']);
    Route::patch('/book/extradition/{book}', [BookController::class, 'extradition']);
    Route::patch('/book/accept/{book}', [BookController::class, 'accept']);
    Route::get('/reservations', [ReservationController::class, 'index']);
    Route::get('/reservation/{reservation}', [ReservationController::class, 'show']);
    Route::patch('/reservation', [ReservationController::class, 'patch']);
});

Route::middleware(['auth:api', 'role:user'])->group(function () {
    Route::get('/books', [UserController::class, 'index']);
    Route::get('/book/{book}', [UserController::class, 'show']);
    Route::post('/reservation/{book}', [ReservationController::class, 'store']);
    Route::patch('/reservation/{book}', [ReservationController::class, 'update']);
    Route::post('/comment/{book}', [CommentController::class, 'update']);
});
