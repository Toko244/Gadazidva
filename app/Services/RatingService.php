<?php

namespace App\Services;

use App\DTOs\RatingDTO;
use App\Models\Rating;
use App\Repositories\RatingRepository;
use App\Services\DriverProfileService;
use App\Services\AssistantProfileService;
use Illuminate\Support\Facades\DB;

class RatingService extends BaseService
{
    public function __construct(
        RatingRepository $repository,
        private readonly DriverProfileService $driverProfileService,
        private readonly AssistantProfileService $assistantProfileService
    ) {
        parent::__construct($repository);
    }

    /**
     * Create a new rating
     */
    public function createRating(RatingDTO $dto): Rating
    {
        // Check if rating already exists
        if ($this->repository->exists($dto->raterId, $dto->ratedId, $dto->rateableType, $dto->rateableId)) {
            throw new \Exception('Rating already exists for this transaction');
        }

        return DB::transaction(function () use ($dto) {
            $rating = $this->repository->create($dto->toArray());

            // Update the profile rating based on type
            $this->updateProfileRating($dto->rateableType, $dto->rateableId, $dto->rating);

            return $rating->load(['rater', 'rated']);
        });
    }

    /**
     * Get ratings for an entity
     */
    public function getEntityRatings(string $type, int $id)
    {
        return $this->repository->getForEntity($type, $id);
    }

    /**
     * Get ratings given by a user
     */
    public function getUserGivenRatings(int $userId)
    {
        return $this->repository->getByRater($userId);
    }

    /**
     * Get ratings received by a user
     */
    public function getUserReceivedRatings(int $userId)
    {
        return $this->repository->getByRated($userId);
    }

    /**
     * Get average rating for an entity
     */
    public function getAverageRating(string $type, int $id): float
    {
        return round($this->repository->getAverageRating($type, $id), 2);
    }

    /**
     * Update profile rating based on entity type
     */
    protected function updateProfileRating(string $type, int $id, float $rating): void
    {
        switch ($type) {
            case 'App\Models\DriverProfile':
                $this->driverProfileService->updateRating($id, $rating);
                break;
            case 'App\Models\AssistantProfile':
                $this->assistantProfileService->updateRating($id, $rating);
                break;
        }
    }
}
