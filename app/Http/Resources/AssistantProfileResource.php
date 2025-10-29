<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssistantProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'bio' => $this->bio,
            'skills' => $this->skills,
            'years_of_experience' => $this->years_of_experience,
            'hourly_rate' => $this->hourly_rate,
            'rating' => $this->rating,
            'total_jobs' => $this->total_jobs,
            'has_own_tools' => $this->has_own_tools,
            'is_verified' => $this->is_verified,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
