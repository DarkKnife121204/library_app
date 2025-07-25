<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => ['required','string'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Password is required.',
            'password.string' => 'Password is string.',
        ];
    }
}
