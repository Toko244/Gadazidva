<?php

namespace App\Services;

use App\DTOs\ServicePostDTO;
use App\Models\ServicePost;
use App\Repositories\ServicePostRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ServicePostService extends BaseService
{
    public function __construct(ServicePostRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get all active service posts with filters
     */
    public function getActivePosts(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getActiveWithFilters($filters, $perPage);
    }

    /**
     * Create a new service post
     */
    public function createPost(ServicePostDTO $dto): ServicePost
    {
        return DB::transaction(function () use ($dto) {
            $post = $this->repository->create($dto->toArray());

            // Handle image uploads if provided
            if (!empty($dto->images)) {
                $this->handleImageUploads($post, $dto->images);
            }

            return $post->load(['cargoType', 'images']);
        });
    }

    /**
     * Update a service post
     */
    public function updatePost(int $id, ServicePostDTO $dto): bool
    {
        return DB::transaction(function () use ($id, $dto) {
            $updated = $this->repository->update($id, $dto->toArray());

            // Handle new image uploads if provided
            if (!empty($dto->images)) {
                $post = $this->repository->find($id);
                $this->handleImageUploads($post, $dto->images);
            }

            return $updated;
        });
    }

    /**
     * Delete a service post
     */
    public function deletePost(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $post = $this->repository->findOrFail($id);
            
            // Delete associated images from storage
            foreach ($post->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            return $this->repository->delete($id);
        });
    }

    /**
     * Get posts by user
     */
    public function getUserPosts(int $userId)
    {
        return $this->repository->getByUser($userId);
    }

    /**
     * Handle image uploads for a post
     */
    protected function handleImageUploads(ServicePost $post, array $images): void
    {
        foreach ($images as $index => $image) {
            if ($image instanceof \Illuminate\Http\UploadedFile) {
                $path = $image->store('service-posts', 'public');
                
                $post->images()->create([
                    'image_path' => $path,
                    'image_name' => $image->getClientOriginalName(),
                    'order' => $index,
                    'is_primary' => $index === 0,
                ]);
            }
        }
    }

    /**
     * Calculate estimated price based on distance
     */
    public function calculateEstimatedPrice(float $distance, float $ratePerKm, float $fixedRate = 0): float
    {
        return ($distance * $ratePerKm) + $fixedRate;
    }
}
