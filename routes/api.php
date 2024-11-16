<?php

use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\RentalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('authors',[AuthorController::class,'index']);

Route::get('authors/{author}',[AuthorController::class,'show']);

Route::post('authors',[AuthorController::class,'store']);

Route::patch('authors/{author}',[AuthorController::class,'update']);

Route::delete('authors/{author}',[AuthorController::class,'destroy']);

Route::get('books',[BookController::class,'index']);

Route::get('books/{book}',[BookController::class,'show']);

Route::post('books',[BookController::class,'store']);

Route::patch('books/{book}',[BookController::class,'update']);

Route::delete('books/{book}',[BookController::class,'destroy']);

Route::get('rentals',[RentalController::class,'index']);

Route::post('rentals',[RentalController::class,'store']);

Route::patch('rentals/{rental}',[RentalController::class,'update']);
