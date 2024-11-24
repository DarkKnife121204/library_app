<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
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
    public function store(StoreRequest $request): BookResource
    {
        $validated = $request->validated();
        $author = Book::create($validated);
        return new BookResource($author);
    }

    public function update(UpdateRequest $request, Book $book): BookResource
    {
        $validated = $request->validated();
        $book->update($validated);
        return new BookResource($book);
    }

    public function destroy(Book $book): JsonResponse
    {
        $book->delete();
        return response()->json([
            'message' => 'Worker deleted successfully'
        ]);
    }

    public function author(Book $book): JsonResponse
    {
        return response()->json($book->author);
    }

    public function rentals(Book $book): JsonResponse
    {
        return response()->json($book->rentals);
    }

    public function users(Book $book): JsonResponse
    {
        return response()->json($book->users);
    }
}
