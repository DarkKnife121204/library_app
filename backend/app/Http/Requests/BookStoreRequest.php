<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required','string'],
            'author' => ['required','string'],
            'is_available' => ['required','boolean'],
            'genre' => ['required','string'],
            'publisher' => ['required','string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.string' => 'Title must be string',
            'author.required' => 'Author is required',
            'author.string' => 'Author must be string',
            'is_available.required' => 'Is available is required',
            'is_available.boolean' => 'Is available must be boolean',
            'genre.required' => 'Genre is required',
            'genre.string' => 'Genre must be string',
            'publisher.required' => 'Publisher is required',
            'publisher.string' => 'Publisher must be string',
        ];
    }
}
