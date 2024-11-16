<?php

use App\Http\Controllers\API\AuthorController;
use App\Http\Controllers\API\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('authors/{author}',[AuthorController::class,'show']);

Route::post('authors',[AuthorController::class,'store']);

Route::patch('authors/{author}',[AuthorController::class,'update']);

Route::delete('authors/{author}',[AuthorController::class,'destroy']);

Route::get('books/{book}',[BookController::class,'show']);

Route::post('books',[BookController::class,'store']);

Route::patch('books/{book}',[BookController::class,'update']);

Route::delete('books/{book}',[BookController::class,'destroy']);
