<?php

use App\Http\Controllers\API\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('authors/{author}',[AuthorController::class,'show']);

Route::post('authors',[AuthorController::class,'store']);

Route::patch('authors/{author}',[AuthorController::class,'update']);

Route::delete('authors/{author}',[AuthorController::class,'destroy']);
