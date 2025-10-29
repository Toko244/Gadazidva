<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'vehicle_type' => new VehicleTypeResource($this->whenLoaded('vehicleType')),
            'vehicle' => [
                'make' => $this->vehicle_make,
                'model' => $this->vehicle_model,
                'year' => $this->vehicle_year,
                'plate_number' => $this->vehicle_plate_number,
                'color' => $this->vehicle_color,
                'capacity' => $this->vehicle_capacity,
            ],
            'bio' => $this->bio,
            'rates' => [
                'per_km' => $this->base_rate_per_km,
                'fixed' => $this->base_rate_fixed,
            ],
            'rating' => $this->rating,
            'total_trips' => $this->total_trips,
            'is_verified' => $this->is_verified,
            'is_active' => $this->is_active,
            'images' => DriverProfileImageResource::collection($this->whenLoaded('images')),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
