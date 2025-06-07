<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationReserveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'book_id' => ['required', 'integer', 'exists:books,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'book_id.required' => 'Book is required.',
            'book_id.integer' => 'Book is required.',
            'book_id.exists' => 'Book is book_id.',
        ];
    }
}
