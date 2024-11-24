<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalStoreRequest extends FormRequest
{
    public function rules(): array
{
    return [
        'user_id' => ['required','integer'],
        'book_id' => ['required','integer'],
        'rented_at' => ['required','date'],
        'due_date' => ['required','date'],
    ];
}
    public function messages(): array
    {
        return [
            'user_id.required' => ['Это поле обязательное'],
            'user_id.string' => ['Это поле должно быть числом'],
            'book_id.required' => ['Это поле обязательное'],
            'book_id.integer' => ['Это поле должно быть числом'],
            'rented_at.required' => ['Это поле обязательное'],
            'rented_at.date' => ['Это поле должно быть датой'],
            'due_date.required' => ['Это поле обязательное'],
            'due_date.date' => ['Это поле должно быть датой'],
        ];
    }
}
