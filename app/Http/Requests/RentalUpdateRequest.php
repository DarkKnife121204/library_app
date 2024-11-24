<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RentalUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'return_at' => ['required','date'],
        ];
    }
    public function messages(): array
    {
        return [
            'return_at.required' => ['Это поле обязательное'],
            'return_at.date' => ['Это поле должно быть датой'],
        ];
    }
}
