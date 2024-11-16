<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'user_id'=>$this->user_id,
            'book_id'=>$this->book_id,
            'rented_at'=>$this->rented_at,
            'due_date'=>$this->due_date,
            'return_at'=>$this->return_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
