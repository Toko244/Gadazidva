<?php

namespace App\Services;

use App\DTOs\HelperPostDTO;
use App\Models\HelperPost;
use App\Repositories\HelperPostRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class HelperPostService extends BaseService
{
    public function __construct(HelperPostRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get all active helper posts with filters
     */
    public function getActivePosts(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getActiveWithFilters($filters, $perPage);
    }

    /**
     * Create a new helper post
     */
    public function createPost(HelperPostDTO $dto): HelperPost
    {
        return DB::transaction(function () use ($dto) {
            $post = $this->repository->create($dto->toArray());
            return $post->load('driver');
        });
    }

    /**
     * Update a helper post
     */
    public function updatePost(int $id, HelperPostDTO $dto): bool
    {
        return DB::transaction(function () use ($id, $dto) {
            return $this->repository->update($id, $dto->toArray());
        });
    }

    /**
     * Delete a helper post
     */
    public function deletePost(int $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Get posts by driver
     */
    public function getDriverPosts(int $driverId)
    {
        return $this->repository->getByDriver($driverId);
    }

    /**
     * Mark post as filled
     */
    public function markAsFilled(int $id): bool
    {
        return $this->repository->update($id, ['status' => 'filled']);
    }

    /**
     * Mark post as completed
     */
    public function markAsCompleted(int $id): bool
    {
        return $this->repository->update($id, ['status' => 'completed']);
    }
}
