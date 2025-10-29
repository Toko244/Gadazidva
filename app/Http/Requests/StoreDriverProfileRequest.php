<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vehicle_type_id' => ['required', 'exists:vehicle_types,id'],
            'vehicle_make' => ['nullable', 'string', 'max:255'],
            'vehicle_model' => ['nullable', 'string', 'max:255'],
            'vehicle_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'vehicle_plate_number' => ['nullable', 'string', 'max:255'],
            'vehicle_color' => ['nullable', 'string', 'max:255'],
            'vehicle_capacity' => ['nullable', 'numeric', 'min:0'],
            'bio' => ['nullable', 'string'],
            'base_rate_per_km' => ['required', 'numeric', 'min:0'],
            'base_rate_fixed' => ['required', 'numeric', 'min:0'],
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg', 'max:5120'],
        ];
    }
}
