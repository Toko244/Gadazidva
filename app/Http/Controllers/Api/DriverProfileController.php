<?php

namespace App\Http\Controllers\Api;

use App\DTOs\DriverProfileDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDriverProfileRequest;
use App\Http\Requests\UpdateDriverProfileRequest;
use App\Http\Resources\DriverProfileResource;
use App\Models\DriverProfile;
use App\Services\DriverProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverProfileController extends Controller
{
    public function __construct(private readonly DriverProfileService $service) {}

    /**
     * Display a listing of active driver profiles
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'vehicle_type_id',
            'city',
            'min_rating',
            'max_rate',
            'is_available',
        ]);

        $profiles = $this->service->getActiveProfiles($filters, $request->get('per_page', 15));
        // dd($profiles);
        return response()->json([
            'data' => DriverProfileResource::collection($profiles),
            'meta' => [
                'total' => $profiles->total(),
                'current_page' => $profiles->currentPage(),
                'last_page' => $profiles->lastPage(),
                'per_page' => $profiles->perPage(),
            ],
        ]);
    }

    /**
     * Store a newly created driver profile
     */
    public function store(StoreDriverProfileRequest $request): JsonResponse
    {
        // Check if user already has a driver profile
        $existing = $this->service->getByUserId($request->user()->id);
        if ($existing) {
            return response()->json([
                'message' => __('messages.driver_profile.already_exists'),
            ], 422);
        }

        $dto = DriverProfileDTO::fromRequest(array_merge(
            $request->validated(),
            ['user_id' => $request->user()->id]
        ));

        $profile = $this->service->createProfile($dto);

        return response()->json([
            'message' => __('messages.driver_profile.created'),
            'data' => new DriverProfileResource($profile),
        ], 201);
    }

    /**
     * Display the specified driver profile
     */
    public function show(DriverProfile $driverProfile): JsonResponse
    {
        $driverProfile->load(['user', 'vehicleType', 'images']);

        return response()->json([
            'data' => new DriverProfileResource($driverProfile),
        ]);
    }

    /**
     * Update the specified driver profile
     */
    public function update(UpdateDriverProfileRequest $request, DriverProfile $driverProfile): JsonResponse
    {
        $dto = DriverProfileDTO::fromRequest(array_merge(
            $driverProfile->toArray(),
            $request->validated(),
            ['user_id' => $driverProfile->user_id]
        ));

        $this->service->updateProfile($driverProfile->id, $dto);

        return response()->json([
            'message' => __('messages.driver_profile.updated'),
        ]);
    }

    /**
     * Remove the specified driver profile
     */
    public function destroy(Request $request, DriverProfile $driverProfile): JsonResponse
    {
        // Check authorization
        if ($request->user()->id !== $driverProfile->user_id) {
            return response()->json(['message' => __('messages.driver_profile.unauthorized')], 403);
        }

        $this->service->deleteProfile($driverProfile->id);

        return response()->json([
            'message' => __('messages.driver_profile.deleted'),
        ]);
    }

    /**
     * Get the authenticated driver's profile
     */
    public function myProfile(Request $request): JsonResponse
    {
        $profile = $this->service->getByUserId($request->user()->id);

        if (!$profile) {
            return response()->json([
                'message' => __('messages.driver_profile.not_found'),
            ], 404);
        }

        return response()->json([
            'data' => new DriverProfileResource($profile),
        ]);
    }

    /**
     * Calculate trip cost
     */
    public function calculateCost(Request $request, DriverProfile $driverProfile): JsonResponse
    {
        $request->validate([
            'distance' => ['required', 'numeric', 'min:0'],
        ]);

        $cost = $this->service->calculateTripCost(
            $driverProfile->id,
            $request->distance
        );

        return response()->json([
            'data' => $cost,
        ]);
    }
}
