<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverProfileImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'url' => asset('storage/' . $this->image_path),
            'name' => $this->image_name,
            'type' => $this->type,
            'order' => $this->order,
            'is_primary' => $this->is_primary,
        ];
    }
}
