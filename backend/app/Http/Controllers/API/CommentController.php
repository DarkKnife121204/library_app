<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\book;
use App\Models\comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{


    public function index(Book $book): JsonResponse
    {
        $comments = $book->comments()->with('user')->get();

        return response()->json([
            'data' => CommentResource::collection($comments)
        ]);
    }



    public function store(CommentStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $comment = auth()->user()->comments()->create($validated);

        return response()->json([
            'message' => 'Комментарий добавлен',
            'data' => new CommentResource($comment)
        ], 201);
    }
}
