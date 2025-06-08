<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookStoreRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Book::query();

        if ($request->has('author')) {
            $query->where('author', 'like', '%' . $request->author . '%');
        }
        if ($request->has('genre')) {
            $query->where('genre', 'like', '%' . $request->genre . '%');
        }
        if ($request->has('publisher')) {
            $query->where('publisher', 'like', '%' . $request->publisher . '%');
        }

        return response()->json([
            'data' => $query->get(),
        ]);
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
