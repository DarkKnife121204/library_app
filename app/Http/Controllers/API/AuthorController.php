<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\ShowRequest;
use App\Http\Requests\Author\StoreRequest;
use App\Http\Requests\Author\UpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use App\Models\Book;

class AuthorController extends Controller
{
    public function index()
    {
        return AuthorResource::collection(Author::all());
    }

    public function show(ShowRequest $request)
    {
        $validated = $request->validated();
        return new AuthorResource($validated);
    }
    public function store(StoreRequest $request)
    {
        $validate = $request->validated();
        $author = Author::create($validate);
        return new AuthorResource($author);
    }
    public function update(UpdateRequest $request, Author $author)
    {
        $validate = $request->validated();
        $author->update($validate);
        $author->fresh();
        return new AuthorResource($author);
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return response()->json([
            'message' => 'Worker deleted successfully'
        ]);
    }

    public function books(Author $author)
    {
        return response()->json($author->books);
    }
}
