<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => [
                'name' => $this->user->name,
            ],
            'book_id' => $this->book_id,
            'book' => [
                'title' => $this->book->title,
            ],
            'status' => $this->status,
            'reserved_at' => $this->reserved_at,
            'expires_at' => $this->expires_at,
            'issued_at' => $this->issued_at,
            'returned_at' => $this->returned_at,
        ];
    }
}
