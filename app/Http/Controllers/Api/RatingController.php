<?php

namespace App\Http\Controllers\Api;

use App\DTOs\RatingDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Resources\RatingResource;
use App\Services\RatingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function __construct(private readonly RatingService $service) {}

    /**
     * Store a newly created rating
     */
    public function store(StoreRatingRequest $request): JsonResponse
    {
        try {
            $dto = RatingDTO::fromRequest(array_merge(
                $request->validated(),
                ['rater_id' => $request->user()->id]
            ));

            $rating = $this->service->createRating($dto);

            return response()->json([
                'message' => __('messages.rating.created'),
                'data' => new RatingResource($rating),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Get ratings for a specific entity
     */
    public function getEntityRatings(Request $request): JsonResponse
    {
        $request->validate([
            'type' => ['required', 'in:App\Models\DriverProfile,App\Models\AssistantProfile,App\Models\ServicePost'],
            'id' => ['required', 'integer'],
        ]);

        $ratings = $this->service->getEntityRatings($request->type, $request->id);

        return response()->json([
            'data' => RatingResource::collection($ratings),
            'average' => $this->service->getAverageRating($request->type, $request->id),
        ]);
    }

    /**
     * Get ratings given by authenticated user
     */
    public function myGivenRatings(Request $request): JsonResponse
    {
        $ratings = $this->service->getUserGivenRatings($request->user()->id);

        return response()->json([
            'data' => RatingResource::collection($ratings),
        ]);
    }

    /**
     * Get ratings received by authenticated user
     */
    public function myReceivedRatings(Request $request): JsonResponse
    {
        $ratings = $this->service->getUserReceivedRatings($request->user()->id);

        return response()->json([
            'data' => RatingResource::collection($ratings),
        ]);
    }
}
