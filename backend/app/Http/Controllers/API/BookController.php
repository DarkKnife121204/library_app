<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookStoreRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return BookResource::collection(Book::all());
    }
    public function show(Book $book): BookResource
    {
        return BookResource::make($book);
    }
    public function store(BookStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $book = Book::create($validated);

        return response()->json([
            'message' => 'Книга успешно создана',
            'data' => new BookResource($book)
        ], 201);
    }

    public function destroy(Book $book): JsonResponse
    {
        $book->delete();

        return response()->json([
            'message' => 'Книга успешно удалена'
        ], 200);
    }
}
