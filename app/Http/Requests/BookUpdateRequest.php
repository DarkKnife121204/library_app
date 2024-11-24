<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'author_id' => ['required', 'integer'],
            'published_at' => ['required', 'date'],
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Это поле обязательно',
            'title.string' => 'Это поле должно быть строкой',
            'author_id.required' => 'Это поле обязательно',
            'author_id.integer' => 'Это поле должно быть числом',
            'published_at.required' => 'Это поле обязательно',
            'published_at.date' => 'Это поле должно быть датой',
        ];
    }
}
