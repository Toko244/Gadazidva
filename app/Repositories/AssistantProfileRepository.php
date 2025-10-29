<?php

namespace App\Repositories;

use App\Models\AssistantProfile;
use Illuminate\Pagination\LengthAwarePaginator;

class AssistantProfileRepository extends BaseRepository
{
    public function __construct(AssistantProfile $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active assistant profiles with filters
     */
    public function getActiveWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery()
            ->with('user')
            ->active()
            ->verified();

        if (isset($filters['city'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('city', 'like', "%{$filters['city']}%");
            });
        }

        if (isset($filters['min_rating'])) {
            $query->where('rating', '>=', $filters['min_rating']);
        }

        if (isset($filters['max_hourly_rate'])) {
            $query->where('hourly_rate', '<=', $filters['max_hourly_rate']);
        }

        if (isset($filters['has_own_tools'])) {
            $query->where('has_own_tools', $filters['has_own_tools']);
        }

        if (isset($filters['is_available'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('is_available', $filters['is_available']);
            });
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get assistant profile by user ID
     */
    public function getByUserId(int $userId): ?AssistantProfile
    {
        return $this->model->where('user_id', $userId)
            ->with('user')
            ->first();
    }

    /**
     * Update assistant rating
     */
    public function updateRating(int $id, float $newRating): bool
    {
        $profile = $this->findOrFail($id);
        
        $totalJobs = $profile->total_jobs;
        $currentTotal = $profile->rating * $totalJobs;
        $newTotal = $currentTotal + $newRating;
        $newAverage = $newTotal / ($totalJobs + 1);

        return $profile->update([
            'rating' => round($newAverage, 2),
            'total_jobs' => $totalJobs + 1,
        ]);
    }
}
