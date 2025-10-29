<?php

namespace App\Services;

use App\DTOs\AssistantProfileDTO;
use App\Models\AssistantProfile;
use App\Repositories\AssistantProfileRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AssistantProfileService extends BaseService
{
    public function __construct(AssistantProfileRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get all active assistant profiles with filters
     */
    public function getActiveProfiles(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getActiveWithFilters($filters, $perPage);
    }

    /**
     * Create an assistant profile
     */
    public function createProfile(AssistantProfileDTO $dto): AssistantProfile
    {
        return DB::transaction(function () use ($dto) {
            $profile = $this->repository->create($dto->toArray());
            return $profile->load('user');
        });
    }

    /**
     * Update an assistant profile
     */
    public function updateProfile(int $id, AssistantProfileDTO $dto): bool
    {
        return DB::transaction(function () use ($id, $dto) {
            return $this->repository->update($id, $dto->toArray());
        });
    }

    /**
     * Delete an assistant profile
     */
    public function deleteProfile(int $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * Get profile by user ID
     */
    public function getByUserId(int $userId): ?AssistantProfile
    {
        return $this->repository->getByUserId($userId);
    }

    /**
     * Calculate job cost
     */
    public function calculateJobCost(int $profileId, int $hours): array
    {
        $profile = $this->repository->findOrFail($profileId);
        
        $totalCost = $hours * $profile->hourly_rate;

        return [
            'hours' => $hours,
            'hourly_rate' => $profile->hourly_rate,
            'total_cost' => round($totalCost, 2),
        ];
    }

    /**
     * Update assistant rating after job
     */
    public function updateRating(int $profileId, float $rating): bool
    {
        if ($rating < 1 || $rating > 5) {
            throw new \InvalidArgumentException('Rating must be between 1 and 5');
        }

        return $this->repository->updateRating($profileId, $rating);
    }
}
