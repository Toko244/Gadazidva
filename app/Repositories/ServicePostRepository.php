<?php

namespace App\Repositories;

use App\Models\ServicePost;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ServicePostRepository extends BaseRepository
{
    public function __construct(ServicePost $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active service posts with filters
     */
    public function getActiveWithFilters(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->model->newQuery()
            ->with(['user', 'cargoType', 'images'])
            ->active();

        if (isset($filters['origin_city'])) {
            $query->where('origin_city', 'like', "%{$filters['origin_city']}%");
        }

        if (isset($filters['destination_city'])) {
            $query->where('destination_city', 'like', "%{$filters['destination_city']}%");
        }

        if (isset($filters['cargo_type_id'])) {
            $query->where('cargo_type_id', $filters['cargo_type_id']);
        }

        if (isset($filters['loading_date_from'])) {
            $query->where('loading_date', '>=', $filters['loading_date_from']);
        }

        if (isset($filters['loading_date_to'])) {
            $query->where('loading_date', '<=', $filters['loading_date_to']);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Get service posts by user
     */
    public function getByUser(int $userId): Collection
    {
        return $this->model->where('user_id', $userId)
            ->with(['cargoType', 'images'])
            ->latest()
            ->get();
    }
}
