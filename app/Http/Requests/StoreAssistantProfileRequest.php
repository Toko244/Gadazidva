<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssistantProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bio' => ['nullable', 'string'],
            'skills' => ['nullable', 'string'],
            'years_of_experience' => ['required', 'integer', 'min:0', 'max:50'],
            'hourly_rate' => ['required', 'numeric', 'min:0'],
            'has_own_tools' => ['required', 'boolean'],
        ];
    }
}
