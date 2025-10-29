<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicePostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'cargo_type' => new CargoTypeResource($this->whenLoaded('cargoType')),
            'title' => $this->title,
            'origin' => [
                'address' => $this->origin_address,
                'city' => $this->origin_city,
                'latitude' => $this->origin_latitude,
                'longitude' => $this->origin_longitude,
            ],
            'destination' => [
                'address' => $this->destination_address,
                'city' => $this->destination_city,
                'latitude' => $this->destination_latitude,
                'longitude' => $this->destination_longitude,
            ],
            'loading_date' => $this->loading_date?->toDateTimeString(),
            'cargo_weight' => $this->cargo_weight,
            'description' => $this->description,
            'contact_phone' => $this->contact_phone,
            'contact_email' => $this->contact_email,
            'status' => $this->status,
            'is_published' => $this->is_published,
            'images' => ServicePostImageResource::collection($this->whenLoaded('images')),
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }
}
