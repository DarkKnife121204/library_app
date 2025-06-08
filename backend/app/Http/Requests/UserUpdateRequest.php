<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required','string'],
            'email' => ['required','email'],
            'role' => ['required','string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name is string',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'role.required' => 'Role is required',
            'role.string' => 'Role is string',
        ];
    }
}
