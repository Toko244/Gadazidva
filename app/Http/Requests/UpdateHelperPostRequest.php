<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHelperPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->id === $this->route('helperPost')->driver_id;
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'location_address' => ['sometimes', 'string', 'max:255'],
            'location_city' => ['sometimes', 'string', 'max:255'],
            'required_date' => ['sometimes', 'date', 'after_or_equal:today'],
            'duration_hours' => ['nullable', 'integer', 'min:1'],
            'helpers_needed' => ['sometimes', 'integer', 'min:1', 'max:10'],
            'offered_rate' => ['nullable', 'numeric', 'min:0'],
            'requirements' => ['nullable', 'string'],
            'status' => ['sometimes', 'in:pending,active,filled,completed,cancelled'],
        ];
    }
}
