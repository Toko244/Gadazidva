<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServicePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->id === $this->route('servicePost')->user_id;
    }

    public function rules(): array
    {
        return [
            'cargo_type_id' => ['sometimes', 'exists:cargo_types,id'],
            'title' => ['sometimes', 'string', 'max:255'],
            'origin_address' => ['sometimes', 'string', 'max:255'],
            'origin_city' => ['sometimes', 'string', 'max:255'],
            'destination_address' => ['sometimes', 'string', 'max:255'],
            'destination_city' => ['sometimes', 'string', 'max:255'],
            'loading_date' => ['sometimes', 'date', 'after_or_equal:today'],
            'cargo_weight' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['sometimes', 'in:pending,active,completed,cancelled'],
        ];
    }
}
