<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\User;

class BookController extends Controller
{
    public function index()
    {
        return BookResource::collection(Book::all());
    }

    public function show(Book $book)
    {
        return BookResource::make($book);
    }
    public function store(StoreRequest $request)
    {
        $validate = $request->validated();
        $author = Book::create($validate);
        return new BookResource($author);
    }

    public function update(UpdateRequest $request, Book $book)
    {
        $validate = $request->validated();
        $book->update($validate);
        $book->fresh();
        return new BookResource($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
            'message' => 'Worker deleted successfully'
        ]);
    }

    public function author(Book $book)
    {
        return response()->json($book->author);
    }

    public function rentals(Book $book)
    {
        return response()->json($book->rentals);
    }

    public function users(Book $book)
    {
        return response()->json($book->users);
    }
}
