<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;

class BookController extends Controller
{
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
}
