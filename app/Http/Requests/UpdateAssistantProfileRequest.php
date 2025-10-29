<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssistantProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->id === $this->route('assistantProfile')->user_id;
    }

    public function rules(): array
    {
        return [
            'bio' => ['nullable', 'string'],
            'skills' => ['nullable', 'string'],
            'years_of_experience' => ['sometimes', 'integer', 'min:0', 'max:50'],
            'hourly_rate' => ['sometimes', 'numeric', 'min:0'],
            'has_own_tools' => ['sometimes', 'boolean'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
