<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ServicePostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\DriverProfileController;
use App\Http\Controllers\Api\HelperPostController;
use App\Http\Controllers\Api\AssistantProfileController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\DistanceController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Get active service posts (visible to drivers)
Route::get('/service-posts', [ServicePostController::class, 'index']);
Route::get('/service-posts/{servicePost}', [ServicePostController::class, 'show']);

// Get comments for service posts (public)
Route::get('/service-posts/{servicePostId}/comments', [CommentController::class, 'index']);
Route::get('/comments/{comment}', [CommentController::class, 'show']);

// Get active driver profiles (visible to users)
Route::get('/driver-profiles', [DriverProfileController::class, 'index']);
Route::get('/driver-profiles/{driverProfile}', [DriverProfileController::class, 'show']);
Route::get('/driver-profiles/{driverProfile}/calculate-cost', [DriverProfileController::class, 'calculateCost']);

// Get active assistant profiles (visible to drivers and users)
Route::get('/assistant-profiles', [AssistantProfileController::class, 'index']);
Route::get('/assistant-profiles/{assistantProfile}', [AssistantProfileController::class, 'show']);
Route::get('/assistant-profiles/{assistantProfile}/calculate-cost', [AssistantProfileController::class, 'calculateCost']);

// Distance calculator (public utility)
Route::post('/distance/calculate', [DistanceController::class, 'calculate']);
Route::post('/distance/estimate', [DistanceController::class, 'estimate']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // User service posts (only users can create)
    Route::middleware('role:user')->group(function () {
        Route::post('/service-posts', [ServicePostController::class, 'store']);
        Route::get('/my-service-posts', [ServicePostController::class, 'myPosts']);
    });

    // Service post management (owner only)
    Route::put('/service-posts/{servicePost}', [ServicePostController::class, 'update']);
    Route::delete('/service-posts/{servicePost}', [ServicePostController::class, 'destroy']);

    // Comment management (all authenticated users can comment)
    Route::post('/comments', [CommentController::class, 'store']);
    Route::put('/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

    // Driver profile management (only drivers can create)
    Route::middleware('role:driver')->group(function () {
        Route::post('/driver-profiles', [DriverProfileController::class, 'store']);
        Route::get('/my-driver-profile', [DriverProfileController::class, 'myProfile']);
    });

    // Driver profile updates (owner only)
    Route::put('/driver-profiles/{driverProfile}', [DriverProfileController::class, 'update']);
    Route::delete('/driver-profiles/{driverProfile}', [DriverProfileController::class, 'destroy']);

    // Driver helper posts (only drivers can create)
    Route::middleware('role:driver')->group(function () {
        Route::post('/helper-posts', [HelperPostController::class, 'store']);
        Route::get('/my-helper-posts', [HelperPostController::class, 'myPosts']);
        Route::post('/helper-posts/{helperPost}/mark-filled', [HelperPostController::class, 'markAsFilled']);
        Route::post('/helper-posts/{helperPost}/mark-completed', [HelperPostController::class, 'markAsCompleted']);
    });

    // Helper post updates (owner only)
    Route::put('/helper-posts/{helperPost}', [HelperPostController::class, 'update']);
    Route::delete('/helper-posts/{helperPost}', [HelperPostController::class, 'destroy']);

    // Assistant profile management (only assistants can create)
    Route::middleware('role:assistant')->group(function () {
        Route::post('/assistant-profiles', [AssistantProfileController::class, 'store']);
        Route::get('/my-assistant-profile', [AssistantProfileController::class, 'myProfile']);
    });

    // Assistant profile updates (owner only)
    Route::put('/assistant-profiles/{assistantProfile}', [AssistantProfileController::class, 'update']);
    Route::delete('/assistant-profiles/{assistantProfile}', [AssistantProfileController::class, 'destroy']);

    // Rating system (all authenticated users can rate)
    Route::post('/ratings', [RatingController::class, 'store']);
    Route::get('/ratings/entity', [RatingController::class, 'getEntityRatings']);
    Route::get('/my-given-ratings', [RatingController::class, 'myGivenRatings']);
    Route::get('/my-received-ratings', [RatingController::class, 'myReceivedRatings']);

    // Messaging system (all authenticated users can message)
    Route::get('/conversations', [MessageController::class, 'getConversations']);
    Route::post('/conversations', [MessageController::class, 'getOrCreateConversation']);
    Route::get('/conversations/{conversation}/messages', [MessageController::class, 'getMessages']);
    Route::post('/messages', [MessageController::class, 'sendMessage']);
    Route::post('/messages/{message}/mark-read', [MessageController::class, 'markAsRead']);
    Route::get('/messages/unread-count', [MessageController::class, 'getUnreadCount']);

    // Payment system (all authenticated users can make payments)
    Route::post('/payments', [PaymentController::class, 'create']);
    Route::post('/payments/{payment}/process', [PaymentController::class, 'process']);
    Route::get('/my-payments', [PaymentController::class, 'myPayments']);
    Route::post('/payments/calculate-fee', [PaymentController::class, 'calculateFee']);
});

// Get active helper posts (visible to assistants) - Public but intended for assistants
Route::get('/helper-posts', [HelperPostController::class, 'index']);
Route::get('/helper-posts/{helperPost}', [HelperPostController::class, 'show']);
