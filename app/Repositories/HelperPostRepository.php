<?php

namespace App\Repositories;

use App\Models\HelperPost;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class HelperPostRepository extends BaseRepository
{
    public function __construct(HelperPost $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active helper posts with filters
     */
    public function getActiveWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery()
            ->with(['driver'])
            ->active();

        if (isset($filters['location_city'])) {
            $query->where('location_city', 'like', "%{$filters['location_city']}%");
        }

        if (isset($filters['required_date_from'])) {
            $query->where('required_date', '>=', $filters['required_date_from']);
        }

        if (isset($filters['required_date_to'])) {
            $query->where('required_date', '<=', $filters['required_date_to']);
        }

        if (isset($filters['min_rate'])) {
            $query->where('offered_rate', '>=', $filters['min_rate']);
        }

        if (isset($filters['helpers_needed'])) {
            $query->where('helpers_needed', '>=', $filters['helpers_needed']);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get helper posts by driver
     */
    public function getByDriver(int $driverId): Collection
    {
        return $this->model->where('driver_id', $driverId)
            ->latest()
            ->get();
    }
}
