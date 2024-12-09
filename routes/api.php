<?php

use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\RentalController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// test
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('authors', AuthorController::class);

Route::get('authors/books/{author}',[AuthorController::class,'books']);

Route::resource('books', BookController::class);

Route::get('books/author/{book}',[BookController::class,'author']);

Route::get('books/rentals/{book}',[BookController::class,'rentals']);

Route::get('books/users/{book}',[BookController::class,'users']);

Route::resource('rentals', RentalController::class);

Route::get('rentals/books/{rental}',[RentalController::class,'book']);

Route::get('user/books/{user}',[UserController::class,'books']);
