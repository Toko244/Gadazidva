<?php

namespace App\Http\Controllers\Api;

use App\DTOs\HelperPostDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHelperPostRequest;
use App\Http\Requests\UpdateHelperPostRequest;
use App\Http\Resources\HelperPostResource;
use App\Models\HelperPost;
use App\Services\HelperPostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HelperPostController extends Controller
{
    public function __construct(private readonly HelperPostService $service) {}

    /**
     * Display a listing of active helper posts
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'location_city',
            'required_date_from',
            'required_date_to',
            'min_rate',
            'helpers_needed',
        ]);

        $posts = $this->service->getActivePosts($filters, $request->get('per_page', 15));

        return response()->json([
            'data' => HelperPostResource::collection($posts),
            'meta' => [
                'total' => $posts->total(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
            ],
        ]);
    }

    /**
     * Store a newly created helper post
     */
    public function store(StoreHelperPostRequest $request): JsonResponse
    {
        $dto = HelperPostDTO::fromRequest(array_merge(
            $request->validated(),
            ['driver_id' => $request->user()->id]
        ));

        $post = $this->service->createPost($dto);

        return response()->json([
            'message' => __('messages.helper_post.created'),
            'data' => new HelperPostResource($post),
        ], 201);
    }

    /**
     * Display the specified helper post
     */
    public function show(HelperPost $helperPost): JsonResponse
    {
        $helperPost->load('driver');

        return response()->json([
            'data' => new HelperPostResource($helperPost),
        ]);
    }

    /**
     * Update the specified helper post
     */
    public function update(UpdateHelperPostRequest $request, HelperPost $helperPost): JsonResponse
    {
        $dto = HelperPostDTO::fromRequest(array_merge(
            $helperPost->toArray(),
            $request->validated(),
            ['driver_id' => $helperPost->driver_id]
        ));

        $this->service->updatePost($helperPost->id, $dto);

        return response()->json([
            'message' => __('messages.helper_post.updated'),
        ]);
    }

    /**
     * Remove the specified helper post
     */
    public function destroy(Request $request, HelperPost $helperPost): JsonResponse
    {
        if ($request->user()->id !== $helperPost->driver_id) {
            return response()->json(['message' => __('messages.helper_post.unauthorized')], 403);
        }

        $this->service->deletePost($helperPost->id);

        return response()->json([
            'message' => __('messages.helper_post.deleted'),
        ]);
    }

    /**
     * Get posts by authenticated driver
     */
    public function myPosts(Request $request): JsonResponse
    {
        $posts = $this->service->getDriverPosts($request->user()->id);

        return response()->json([
            'data' => HelperPostResource::collection($posts),
        ]);
    }

    /**
     * Mark post as filled
     */
    public function markAsFilled(Request $request, HelperPost $helperPost): JsonResponse
    {
        if ($request->user()->id !== $helperPost->driver_id) {
            return response()->json(['message' => __('messages.helper_post.unauthorized')], 403);
        }

        $this->service->markAsFilled($helperPost->id);

        return response()->json([
            'message' => __('messages.helper_post.marked_filled'),
        ]);
    }

    /**
     * Mark post as completed
     */
    public function markAsCompleted(Request $request, HelperPost $helperPost): JsonResponse
    {
        if ($request->user()->id !== $helperPost->driver_id) {
            return response()->json(['message' => __('messages.helper_post.unauthorized')], 403);
        }

        $this->service->markAsCompleted($helperPost->id);

        return response()->json([
            'message' => __('messages.helper_post.marked_completed'),
        ]);
    }
}
