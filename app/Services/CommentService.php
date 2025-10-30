<?php

namespace App\Services;

use App\DTOs\CommentDTO;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CommentService extends BaseService
{
    public function __construct(CommentRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get all comments for a specific service post with pagination
     */
    public function getCommentsByPost(int $servicePostId, int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getByServicePost($servicePostId, $perPage);
    }

    /**
     * Create a new comment
     */
    public function createComment(CommentDTO $dto): Comment
    {
        return DB::transaction(function () use ($dto) {
            $comment = $this->repository->create($dto->toArray());
            return $comment->load(['user', 'servicePost']);
        });
    }

    /**
     * Update a comment
     */
    public function updateComment(int $id, CommentDTO $dto): bool
    {
        return DB::transaction(function () use ($id, $dto) {
            return $this->repository->update($id, $dto->toArray());
        });
    }

    /**
     * Delete a comment
     */
    public function deleteComment(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            return $this->repository->delete($id);
        });
    }

    /**
     * Get a comment by ID
     */
    public function getComment(int $id): ?Comment
    {
        return $this->repository->with(['user', 'servicePost'])->find($id);
    }

    /**
     * Get comments by user
     */
    public function getUserComments(int $userId)
    {
        return $this->repository->getByUser($userId);
    }
}
