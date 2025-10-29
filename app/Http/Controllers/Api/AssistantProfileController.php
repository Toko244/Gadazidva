<?php

namespace App\Http\Controllers\Api;

use App\DTOs\AssistantProfileDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssistantProfileRequest;
use App\Http\Requests\UpdateAssistantProfileRequest;
use App\Http\Resources\AssistantProfileResource;
use App\Models\AssistantProfile;
use App\Services\AssistantProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssistantProfileController extends Controller
{
    public function __construct(private readonly AssistantProfileService $service) {}

    /**
     * Display a listing of active assistant profiles
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'city',
            'min_rating',
            'max_hourly_rate',
            'has_own_tools',
            'is_available',
        ]);

        $profiles = $this->service->getActiveProfiles($filters, $request->get('per_page', 15));

        return response()->json([
            'data' => AssistantProfileResource::collection($profiles),
            'meta' => [
                'total' => $profiles->total(),
                'current_page' => $profiles->currentPage(),
                'last_page' => $profiles->lastPage(),
                'per_page' => $profiles->perPage(),
            ],
        ]);
    }

    /**
     * Store a newly created assistant profile
     */
    public function store(StoreAssistantProfileRequest $request): JsonResponse
    {
        // Check if user already has an assistant profile
        $existing = $this->service->getByUserId($request->user()->id);
        if ($existing) {
            return response()->json([
                'message' => __('messages.assistant_profile.already_exists'),
            ], 422);
        }

        $dto = AssistantProfileDTO::fromRequest(array_merge(
            $request->validated(),
            ['user_id' => $request->user()->id]
        ));

        $profile = $this->service->createProfile($dto);

        return response()->json([
            'message' => __('messages.assistant_profile.created'),
            'data' => new AssistantProfileResource($profile),
        ], 201);
    }

    /**
     * Display the specified assistant profile
     */
    public function show(AssistantProfile $assistantProfile): JsonResponse
    {
        $assistantProfile->load('user');

        return response()->json([
            'data' => new AssistantProfileResource($assistantProfile),
        ]);
    }

    /**
     * Update the specified assistant profile
     */
    public function update(UpdateAssistantProfileRequest $request, AssistantProfile $assistantProfile): JsonResponse
    {
        $dto = AssistantProfileDTO::fromRequest(array_merge(
            $assistantProfile->toArray(),
            $request->validated(),
            ['user_id' => $assistantProfile->user_id]
        ));

        $this->service->updateProfile($assistantProfile->id, $dto);

        return response()->json([
            'message' => __('messages.assistant_profile.updated'),
        ]);
    }

    /**
     * Remove the specified assistant profile
     */
    public function destroy(Request $request, AssistantProfile $assistantProfile): JsonResponse
    {
        if ($request->user()->id !== $assistantProfile->user_id) {
            return response()->json(['message' => __('messages.assistant_profile.unauthorized')], 403);
        }

        $this->service->deleteProfile($assistantProfile->id);

        return response()->json([
            'message' => __('messages.assistant_profile.deleted'),
        ]);
    }

    /**
     * Get the authenticated assistant's profile
     */
    public function myProfile(Request $request): JsonResponse
    {
        $profile = $this->service->getByUserId($request->user()->id);

        if (!$profile) {
            return response()->json([
                'message' => __('messages.assistant_profile.not_found'),
            ], 404);
        }

        return response()->json([
            'data' => new AssistantProfileResource($profile),
        ]);
    }

    /**
     * Calculate job cost
     */
    public function calculateCost(Request $request, AssistantProfile $assistantProfile): JsonResponse
    {
        $request->validate([
            'hours' => ['required', 'integer', 'min:1'],
        ]);

        $cost = $this->service->calculateJobCost(
            $assistantProfile->id,
            $request->hours
        );

        return response()->json([
            'data' => $cost,
        ]);
    }
}
