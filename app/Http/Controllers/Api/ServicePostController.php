<?php

namespace App\Http\Controllers\Api;

use App\DTOs\ServicePostDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServicePostRequest;
use App\Http\Requests\UpdateServicePostRequest;
use App\Http\Resources\ServicePostResource;
use App\Models\ServicePost;
use App\Services\ServicePostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServicePostController extends Controller
{
    public function __construct(private readonly ServicePostService $service) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['origin_city', 'destination_city', 'cargo_type_id', 'loading_date_from', 'loading_date_to']);
        $posts = $this->service->getActivePosts($filters, $request->get('per_page', 15));

        return response()->json([
            'data' => ServicePostResource::collection($posts),
            'meta' => ['total' => $posts->total(), 'current_page' => $posts->currentPage()],
        ]);
    }

    public function store(StoreServicePostRequest $request): JsonResponse
    {
        $dto = ServicePostDTO::fromRequest(array_merge($request->validated(), ['user_id' => $request->user()->id]));
        $post = $this->service->createPost($dto);

        return response()->json(['message' => __('messages.service_post.created'), 'data' => new ServicePostResource($post)], 201);
    }

    public function show(ServicePost $servicePost): JsonResponse
    {
        $servicePost->load(['user', 'cargoType', 'images']);
        return response()->json(['data' => new ServicePostResource($servicePost)]);
    }

    public function update(UpdateServicePostRequest $request, ServicePost $servicePost): JsonResponse
    {
        $dto = ServicePostDTO::fromRequest(array_merge($servicePost->toArray(), $request->validated(), ['user_id' => $servicePost->user_id]));
        $this->service->updatePost($servicePost->id, $dto);

        return response()->json(['message' => __('messages.service_post.updated')]);
    }

    public function destroy(Request $request, ServicePost $servicePost): JsonResponse
    {
        if ($request->user()->id !== $servicePost->user_id) {
            return response()->json(['message' => __('messages.service_post.unauthorized')], 403);
        }

        $this->service->deletePost($servicePost->id);
        return response()->json(['message' => __('messages.service_post.deleted')]);
    }

    public function myPosts(Request $request): JsonResponse
    {
        $posts = $this->service->getUserPosts($request->user()->id);
        return response()->json(['data' => ServicePostResource::collection($posts)]);
    }
}
