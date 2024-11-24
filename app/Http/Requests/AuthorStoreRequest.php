<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required','string'],
            'bio' => ['required','string'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => ['Это поле обязательное'],
            'name.string' => ['Это поле должно быть строкой'],
            'bio.required' => ['Это поле обязательное'],
            'bio.string' => ['Это поле должно быть строкой'],
        ];
    }
}
