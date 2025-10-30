<?php

namespace App\Http\Controllers\Api;

use App\DTOs\CommentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(private readonly CommentService $service) {}

    /**
     * Display a listing of comments for a specific service post.
     */
    public function index(Request $request, int $servicePostId): JsonResponse
    {
        $comments = $this->service->getCommentsByPost($servicePostId, $request->get('per_page', 15));

        return response()->json([
            'data' => CommentResource::collection($comments),
            'meta' => [
                'total' => $comments->total(),
                'current_page' => $comments->currentPage(),
                'per_page' => $comments->perPage(),
                'last_page' => $comments->lastPage(),
            ],
        ]);
    }

    /**
     * Store a newly created comment in storage.
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        $dto = CommentDTO::fromRequest(array_merge(
            $request->validated(),
            ['user_id' => $request->user()->id]
        ));

        $comment = $this->service->createComment($dto);

        return response()->json([
            'message' => 'Comment created successfully.',
            'data' => new CommentResource($comment),
        ], 201);
    }

    /**
     * Display the specified comment.
     */
    public function show(Comment $comment): JsonResponse
    {
        $comment->load(['user', 'servicePost']);

        return response()->json([
            'data' => new CommentResource($comment),
        ]);
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment): JsonResponse
    {
        $dto = CommentDTO::fromRequest(array_merge(
            [
                'user_id' => $comment->user_id,
                'service_post_id' => $comment->service_post_id,
            ],
            $request->validated()
        ));

        $this->service->updateComment($comment->id, $dto);

        return response()->json([
            'message' => 'Comment updated successfully.',
        ]);
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Request $request, Comment $comment): JsonResponse
    {
        if ($request->user()->id !== $comment->user_id) {
            return response()->json([
                'message' => 'Unauthorized to delete this comment.',
            ], 403);
        }

        $this->service->deleteComment($comment->id);

        return response()->json([
            'message' => 'Comment deleted successfully.',
        ]);
    }
}
