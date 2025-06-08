<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\NotificationRequestController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/me', [AuthController::class, 'me'])->name('auth.me');
});

Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::patch('/user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::patch('/user/password/{user}', [UserController::class, 'setPassword'])->name('user.setPassword');
    Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
});

Route::middleware(['auth:api', 'role:librarian'])->group(function () {
    Route::post('/book', [BookController::class, 'store'])->name('book.store');
    Route::delete('/book/{book}', [BookController::class, 'destroy'])->name('book.destroy');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservation.index');
    Route::get('/reservation/{reservation}', [ReservationController::class, 'show'])->name('reservation.show');
});

Route::middleware(['auth:api', 'role:user'])->group(function () {
    Route::post('/reservation', [ReservationController::class, 'reserve'])->name('reservation.reserve');
    Route::get('/user/{user}/reservations', [UserController::class, 'reservations'])->name('user.reservations');
    Route::get('/book/{book}/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/comment', [CommentController::class, 'store'])->name('comment.store');
    Route::post('/notifyRequest', [NotificationRequestController::class, 'store'])->name('notification.store');
    Route::delete('/notifyRequest', [NotificationRequestController::class, 'destroy'])->name('notification.destroy');
});

Route::middleware(['auth:api', 'role:user,librarian'])->group(function () {
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/book/{book}', [BookController::class, 'show'])->name('book.show');
    Route::patch('/reservation/{id}/status', [ReservationController::class, 'updateStatus'])->name('reservation.status');
});
