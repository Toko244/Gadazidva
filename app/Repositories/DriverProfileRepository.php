<?php

namespace App\Repositories;

use App\Models\DriverProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class DriverProfileRepository extends BaseRepository
{
    public function __construct(DriverProfile $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active driver profiles with filters
     */
    public function getActiveWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery()
            ->with(['user', 'vehicleType', 'images'])
            ->whereHas('user', function ($q) {
                $q->where('is_available', true);
                $q->where('email_verified_at', '!=', null);
                $q->where('approved', true);
            });


        if (isset($filters['vehicle_type_id'])) {
            $query->where('vehicle_type_id', $filters['vehicle_type_id']);
        }

        if (isset($filters['city'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('city', 'like', "%{$filters['city']}%");
            });
        }

        if (isset($filters['min_rating'])) {
            $query->where('rating', '>=', $filters['min_rating']);
        }

        if (isset($filters['max_rate'])) {
            $query->where('base_rate_per_km', '<=', $filters['max_rate']);
        }

        if (isset($filters['is_available'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('is_available', $filters['is_available']);
            });
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get driver profile by user ID
     */
    public function getByUserId(int $userId): ?DriverProfile
    {
        return $this->model->where('user_id', $userId)
            ->with(['user', 'vehicleType', 'images'])
            ->first();
    }

    /**
     * Update driver rating
     */
    public function updateRating(int $id, float $newRating): bool
    {
        $profile = $this->findOrFail($id);

        // Calculate new average rating
        $totalRatings = $profile->total_trips;
        $currentTotal = $profile->rating * $totalRatings;
        $newTotal = $currentTotal + $newRating;
        $newAverage = $newTotal / ($totalRatings + 1);

        return $profile->update([
            'rating' => round($newAverage, 2),
            'total_trips' => $totalRatings + 1,
        ]);
    }
}
