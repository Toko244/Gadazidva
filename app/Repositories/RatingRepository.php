<?php

namespace App\Repositories;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Collection;

class RatingRepository extends BaseRepository
{
    public function __construct(Rating $model)
    {
        parent::__construct($model);
    }

    /**
     * Get ratings for a specific entity
     */
    public function getForEntity(string $type, int $id): Collection
    {
        return $this->model->where('rateable_type', $type)
            ->where('rateable_id', $id)
            ->with(['rater', 'rated'])
            ->latest()
            ->get();
    }

    /**
     * Get ratings by a specific user
     */
    public function getByRater(int $raterId): Collection
    {
        return $this->model->where('rater_id', $raterId)
            ->with(['rated', 'rateable'])
            ->latest()
            ->get();
    }

    /**
     * Get ratings received by a specific user
     */
    public function getByRated(int $ratedId): Collection
    {
        return $this->model->where('rated_id', $ratedId)
            ->with(['rater', 'rateable'])
            ->latest()
            ->get();
    }

    /**
     * Check if rating exists
     */
    public function exists(int $raterId, int $ratedId, string $type, int $id): bool
    {
        return $this->model->where('rater_id', $raterId)
            ->where('rated_id', $ratedId)
            ->where('rateable_type', $type)
            ->where('rateable_id', $id)
            ->exists();
    }

    /**
     * Calculate average rating for an entity
     */
    public function getAverageRating(string $type, int $id): float
    {
        return $this->model->where('rateable_type', $type)
            ->where('rateable_id', $id)
            ->avg('rating') ?? 0.0;
    }
}
