<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rater' => new UserResource($this->whenLoaded('rater')),
            'rated' => new UserResource($this->whenLoaded('rated')),
            'rateable_type' => $this->rateable_type,
            'rateable_id' => $this->rateable_id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
