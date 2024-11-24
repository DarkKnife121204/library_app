<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Author\StoreRequest;
use App\Http\Requests\Author\UpdateRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AuthorController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return AuthorResource::collection(Author::all());
    }

    public function show(Author $author): AuthorResource
    {
        return AuthorResource::make($author);
    }
    public function store(StoreRequest $request) : AuthorResource
    {
        $validated = $request->validated();
        $author = Author::create($validated);
        return new AuthorResource($author);
    }
    public function update(UpdateRequest $request, Author $author): AuthorResource
    {
        $validated = $request->validated();
        $author->update($validated);
        return new AuthorResource($author);
    }

    public function destroy(Author $author): JsonResponse
    {
        $author->delete();
        return response()->json([
            'message' => 'Worker deleted successfully'
        ]);
    }

    public function books(Author $author): JsonResponse
    {
        return response()->json($author->books);
    }
}
