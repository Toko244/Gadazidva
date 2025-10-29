<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'avatar' => $this->avatar ? asset('storage/' . $this->avatar) : null,
            'city' => $this->city,
            'address' => $this->address,
            'is_available' => $this->is_available,
            'roles' => $this->roles->pluck('name'),
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
