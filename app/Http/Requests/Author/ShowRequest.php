<?php

namespace App\Http\Requests\Author;

use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id'=>['required','integer']
        ];
    }
    public function messages(): array
    {
        return [
            'id.required' => ['Это поле обязательное'],
            'id.integer' => ['Это поле должно быть числом'],
        ];
    }
}
