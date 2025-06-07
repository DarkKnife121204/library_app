<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'book_id' => ['required'],
            'rating'  => ['required','integer','between:1,5'],
            'content'    => ['required','string'],
        ];
    }

    public function messages(): array
    {
        return [
            'book_id.required' => 'Book is required',
            'rating.required' => 'Rating is required',
            'rating.integer' => 'Rating must be an integer',
            'rating.between' => 'Rating must be between 1 and 5',
            'content.required' => 'Content is required',
            'content.string' => 'Content must be string',
        ];
    }
}
