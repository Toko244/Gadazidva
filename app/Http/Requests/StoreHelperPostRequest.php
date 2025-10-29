<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHelperPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'location_address' => ['required', 'string', 'max:255'],
            'location_city' => ['required', 'string', 'max:255'],
            'location_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'location_longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'required_date' => ['required', 'date', 'after_or_equal:today'],
            'duration_hours' => ['nullable', 'integer', 'min:1'],
            'helpers_needed' => ['required', 'integer', 'min:1', 'max:10'],
            'offered_rate' => ['nullable', 'numeric', 'min:0'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'requirements' => ['nullable', 'string'],
        ];
    }
}
