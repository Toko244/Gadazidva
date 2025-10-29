<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rated_id' => ['required', 'exists:users,id'],
            'rateable_type' => ['required', 'in:App\Models\DriverProfile,App\Models\AssistantProfile,App\Models\ServicePost'],
            'rateable_id' => ['required', 'integer'],
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
