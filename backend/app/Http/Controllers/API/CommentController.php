<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentController extends Controller
{
    public function show($bookId): AnonymousResourceCollection
    {
        $comments = Comment::with('user')
            ->where('book_id', $bookId)
            ->orderByDesc('created_at')
            ->get();

        return CommentResource::collection($comments);
    }


    public function store(CommentStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'book_id' => $validated['book_id'],
            'rating' => $validated['rating'],
            'content' => $validated['content'],
        ]);

        return response()->json([
            'message' => 'Комментарий добавлен',
            'data' => new CommentResource($comment)
        ], 201);
    }
}
