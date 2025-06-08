<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'book_id' => $this->book_id,
            'rating' => $this->rating,
            'content' => $this->content,
            'created_at'=>$this->created_at->format('d.m.Y H:i'),
            'user'       => [
                'name' => optional($this->user)->name,
            ],
        ];
    }
}
