<?php

namespace App\Services;

use App\DTOs\DriverProfileDTO;
use App\Models\DriverProfile;
use App\Repositories\DriverProfileRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DriverProfileService extends BaseService
{
    public function __construct(DriverProfileRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get all active driver profiles with filters
     */
    public function getActiveProfiles(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->getActiveWithFilters($filters, $perPage);
    }

    /**
     * Create a driver profile
     */
    public function createProfile(DriverProfileDTO $dto): DriverProfile
    {
        return DB::transaction(function () use ($dto) {
            $profile = $this->repository->create($dto->toArray());

            // Handle image uploads if provided
            if (!empty($dto->images)) {
                $this->handleImageUploads($profile, $dto->images);
            }

            return $profile->load(['user', 'vehicleType', 'images']);
        });
    }

    /**
     * Update a driver profile
     */
    public function updateProfile(int $id, DriverProfileDTO $dto): bool
    {
        return DB::transaction(function () use ($id, $dto) {
            $updated = $this->repository->update($id, $dto->toArray());

            // Handle new image uploads if provided
            if (!empty($dto->images)) {
                $profile = $this->repository->find($id);
                $this->handleImageUploads($profile, $dto->images);
            }

            return $updated;
        });
    }

    /**
     * Delete a driver profile
     */
    public function deleteProfile(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $profile = $this->repository->findOrFail($id);

            // Delete associated images from storage
            foreach ($profile->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            return $this->repository->delete($id);
        });
    }

    /**
     * Get profile by user ID
     */
    public function getByUserId(int $userId): ?DriverProfile
    {
        return $this->repository->getByUserId($userId);
    }

    /**
     * Handle image uploads for a profile
     */
    protected function handleImageUploads(DriverProfile $profile, array $images): void
    {
        foreach ($images as $index => $imageData) {
            if (isset($imageData['file']) && $imageData['file'] instanceof \Illuminate\Http\UploadedFile) {
                $path = $imageData['file']->store('driver-profiles', 'public');

                $profile->images()->create([
                    'image_path' => $path,
                    'image_name' => $imageData['file']->getClientOriginalName(),
                    'type' => $imageData['type'] ?? 'vehicle_exterior',
                    'order' => $index,
                    'is_primary' => $index === 0,
                ]);
            }
        }
    }

    /**
     * Calculate estimated trip cost
     */
    public function calculateTripCost(int $profileId, float $distance): array
    {
        $profile = $this->repository->findOrFail($profileId);

        $distanceCost = $distance * $profile->base_rate_per_km;
        $totalCost = $distanceCost + $profile->base_rate_fixed;

        return [
            'distance' => $distance,
            'rate_per_km' => $profile->base_rate_per_km,
            'fixed_rate' => $profile->base_rate_fixed,
            'distance_cost' => round($distanceCost, 2),
            'total_cost' => round($totalCost, 2),
        ];
    }

    /**
     * Update driver rating after trip
     */
    public function updateRating(int $profileId, float $rating): bool
    {
        if ($rating < 1 || $rating > 5) {
            throw new \InvalidArgumentException('Rating must be between 1 and 5');
        }

        return $this->repository->updateRating($profileId, $rating);
    }
}
