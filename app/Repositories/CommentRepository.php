<?php

namespace App\Repositories;

use App\Models\Comment;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentRepository extends BaseRepository
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    /**
     * Get comments for a specific service post with pagination
     */
    public function getByServicePost(int $servicePostId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->with(['user'])
            ->where('service_post_id', $servicePostId)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get comments by user
     */
    public function getByUser(int $userId)
    {
        return $this->model->where('user_id', $userId)
            ->with(['servicePost'])
            ->latest()
            ->get();
    }
}
