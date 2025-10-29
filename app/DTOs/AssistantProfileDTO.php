<?php

namespace App\DTOs;

class AssistantProfileDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly ?string $bio,
        public readonly ?string $skills,
        public readonly int $yearsOfExperience = 0,
        public readonly float $hourlyRate = 0.0,
        public readonly bool $hasOwnTools = false,
        public readonly bool $isActive = true,
    ) {}

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'bio' => $this->bio,
            'skills' => $this->skills,
            'years_of_experience' => $this->yearsOfExperience,
            'hourly_rate' => $this->hourlyRate,
            'has_own_tools' => $this->hasOwnTools,
            'is_active' => $this->isActive,
        ];
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            userId: $data['user_id'],
            bio: $data['bio'] ?? null,
            skills: $data['skills'] ?? null,
            yearsOfExperience: $data['years_of_experience'] ?? 0,
            hourlyRate: $data['hourly_rate'] ?? 0.0,
            hasOwnTools: $data['has_own_tools'] ?? false,
            isActive: $data['is_active'] ?? true,
        );
    }
}
