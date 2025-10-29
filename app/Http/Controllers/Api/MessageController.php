<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Get all conversations for authenticated user
     */
    public function getConversations(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $conversations = Conversation::where('user1_id', $userId)
            ->orWhere('user2_id', $userId)
            ->with(['user1', 'user2', 'lastMessage'])
            ->latest('updated_at')
            ->get();

        return response()->json(['data' => $conversations]);
    }

    /**
     * Get or create conversation between two users
     */
    public function getOrCreateConversation(Request $request): JsonResponse
    {
        $request->validate([
            'other_user_id' => ['required', 'exists:users,id'],
        ]);

        $userId = $request->user()->id;
        $otherUserId = $request->other_user_id;

        if ($userId == $otherUserId) {
            return response()->json(['message' => __('messages.message.unauthorized')], 422);
        }

        // Check if conversation already exists (in either direction)
        $conversation = Conversation::where(function ($query) use ($userId, $otherUserId) {
            $query->where('user1_id', $userId)->where('user2_id', $otherUserId);
        })->orWhere(function ($query) use ($userId, $otherUserId) {
            $query->where('user1_id', $otherUserId)->where('user2_id', $userId);
        })->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'user1_id' => min($userId, $otherUserId),
                'user2_id' => max($userId, $otherUserId),
            ]);
        }

        $conversation->load(['user1', 'user2', 'messages']);

        return response()->json(['data' => $conversation]);
    }

    /**
     * Send a message
     */
    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'conversation_id' => ['required', 'exists:conversations,id'],
            'content' => ['required', 'string', 'max:5000'],
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);
        $senderId = $request->user()->id;

        // Determine receiver
        $receiverId = $conversation->user1_id == $senderId 
            ? $conversation->user2_id 
            : $conversation->user1_id;

        $message = DB::transaction(function () use ($conversation, $senderId, $receiverId, $request) {
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'content' => $request->content,
            ]);

            $conversation->update([
                'last_message_id' => $message->id,
                'updated_at' => now(),
            ]);

            return $message->load(['sender', 'receiver']);
        });

        return response()->json([
            'message' => __('messages.message.sent'),
            'data' => $message,
        ], 201);
    }

    /**
     * Get messages for a conversation
     */
    public function getMessages(Request $request, Conversation $conversation): JsonResponse
    {
        $userId = $request->user()->id;

        // Check if user is part of conversation
        if ($conversation->user1_id != $userId && $conversation->user2_id != $userId) {
            return response()->json(['message' => __('messages.message.unauthorized')], 403);
        }

        $messages = $conversation->messages()
            ->with(['sender', 'receiver'])
            ->latest()
            ->paginate(50);

        return response()->json([
            'data' => $messages->items(),
            'meta' => [
                'total' => $messages->total(),
                'current_page' => $messages->currentPage(),
            ],
        ]);
    }

    /**
     * Mark message as read
     */
    public function markAsRead(Request $request, Message $message): JsonResponse
    {
        if ($message->receiver_id != $request->user()->id) {
            return response()->json(['message' => __('messages.message.unauthorized')], 403);
        }

        $message->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return response()->json(['message' => __('messages.message.marked_read')]);
    }

    /**
     * Get unread messages count
     */
    public function getUnreadCount(Request $request): JsonResponse
    {
        $count = Message::where('receiver_id', $request->user()->id)
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $count]);
    }
}
