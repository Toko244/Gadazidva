<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServicePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cargo_type_id' => ['required', 'exists:cargo_types,id'],
            'title' => ['required', 'string', 'max:255'],
            'origin_address' => ['required', 'string', 'max:255'],
            'origin_city' => ['required', 'string', 'max:255'],
            'origin_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'origin_longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'destination_address' => ['required', 'string', 'max:255'],
            'destination_city' => ['required', 'string', 'max:255'],
            'destination_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'destination_longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'loading_date' => ['required', 'date', 'after_or_equal:today'],
            'cargo_weight' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'contact_phone' => ['required', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'images' => ['nullable', 'array', 'max:5'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg', 'max:5120'], // 5MB max per image
        ];
    }
}
