<?php

namespace App\DTOs;

class RatingDTO
{
    public function __construct(
        public readonly int $raterId,
        public readonly int $ratedId,
        public readonly string $rateableType,
        public readonly int $rateableId,
        public readonly float $rating,
        public readonly ?string $comment,
    ) {}

    public function toArray(): array
    {
        return [
            'rater_id' => $this->raterId,
            'rated_id' => $this->ratedId,
            'rateable_type' => $this->rateableType,
            'rateable_id' => $this->rateableId,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ];
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            raterId: $data['rater_id'],
            ratedId: $data['rated_id'],
            rateableType: $data['rateable_type'],
            rateableId: $data['rateable_id'],
            rating: $data['rating'],
            comment: $data['comment'] ?? null,
        );
    }
}
