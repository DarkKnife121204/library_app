<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStoreRequest;
use App\Models\comment;

class CommentController extends Controller
{
    public function show($bookId)
    {
        $comments = Comment::with('user')
            ->where('book_id', $bookId)
            ->orderByDesc('created_at')
            ->get();

        return response()->json($comments);
    }


    public function store(CommentStoreRequest $request)
    {
        $validated = $request->validated();
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'book_id' => $validated['book_id'],
            'rating' => $validated['rating'],
            'content'    => $validated['content'],
        ]);

        return response()->json([
            'message' => 'Комментарий добавлен',
            'data'    => $comment
        ], 201);
    }
}
