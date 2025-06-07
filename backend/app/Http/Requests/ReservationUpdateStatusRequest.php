<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationUpdateStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required','in:reserved,issued,returned,cancelled']
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status is required.',
            'status.in' => 'Acceptable statuses: reserved, issued, returned, cancelled.'
        ];
    }
}
