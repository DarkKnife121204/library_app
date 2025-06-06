<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required','email'],
            'password' => ['required','string'],
        ];
    }

    public function messages(): array
    {
        return [
          'email.required' => 'Email is required',
          'email.email' => 'Email is invalid',
          'password.required' => 'Password is required',
          'password.string' => 'Password must be a string',
        ];
    }
}
