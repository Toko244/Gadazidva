<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->id === $this->route('driverProfile')->user_id;
    }

    public function rules(): array
    {
        return [
            'vehicle_type_id' => ['sometimes', 'exists:vehicle_types,id'],
            'vehicle_make' => ['nullable', 'string', 'max:255'],
            'vehicle_model' => ['nullable', 'string', 'max:255'],
            'vehicle_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'vehicle_plate_number' => ['nullable', 'string', 'max:255'],
            'vehicle_color' => ['nullable', 'string', 'max:255'],
            'vehicle_capacity' => ['nullable', 'numeric', 'min:0'],
            'bio' => ['nullable', 'string'],
            'base_rate_per_km' => ['sometimes', 'numeric', 'min:0'],
            'base_rate_fixed' => ['sometimes', 'numeric', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
