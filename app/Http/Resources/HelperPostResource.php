<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HelperPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'driver' => new UserResource($this->whenLoaded('driver')),
            'title' => $this->title,
            'description' => $this->description,
            'location' => [
                'address' => $this->location_address,
                'city' => $this->location_city,
                'latitude' => $this->location_latitude,
                'longitude' => $this->location_longitude,
            ],
            'required_date' => $this->required_date?->toDateTimeString(),
            'duration_hours' => $this->duration_hours,
            'helpers_needed' => $this->helpers_needed,
            'offered_rate' => $this->offered_rate,
            'contact_phone' => $this->contact_phone,
            'requirements' => $this->requirements,
            'status' => $this->status,
            'is_published' => $this->is_published,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
