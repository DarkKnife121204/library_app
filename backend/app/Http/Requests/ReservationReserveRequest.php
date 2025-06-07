<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationReserveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'book_id' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'book_id.required' => 'Book is required.'
        ];
    }
}
