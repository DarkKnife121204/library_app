<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::post('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::middleware(['auth:api', 'role:librarian'])->group(function () {
    Route::post('/book', [BookController::class, 'store'])->name('book.store');
    Route::delete('/book/{book}', [BookController::class, 'destroy'])->name('book.destroy');
    Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation.index');
    Route::get('/reservation/{reservation}', [ReservationController::class, 'show'])->name('reservation.show');
});

Route::middleware(['auth:api', 'role:user'])->group(function () {
    Route::get('/book', [BookController::class, 'index'])->name('book.index');
    Route::get('/book/{book}', [BookController::class, 'show'])->name('book.show');
    Route::post('/reservation', [ReservationController::class, 'reserve'])->name('reservation.reserve');
    Route::get('/book/{book}/comment', [CommentController::class, 'show'])->name('comments.show');
    Route::post('/comment', [CommentController::class, 'store'])->name('comment.store');
});

Route::middleware(['auth:api', 'role:user,librarian'])->group(function () {
    Route::patch('/reservation/{id}/status', [ReservationController::class, 'updateStatus'])->name('reservation.status');
});
