<?php

return [
    // Authentication
    'auth' => [
        'register_success' => 'User registered successfully',
        'login_success' => 'Login successful',
        'logout_success' => 'Logged out successfully',
        'unauthorized' => 'Unauthorized',
        'invalid_credentials' => 'Invalid credentials',
    ],

    // Service Posts
    'service_post' => [
        'created' => 'Service post created successfully',
        'updated' => 'Service post updated successfully',
        'deleted' => 'Service post deleted successfully',
        'not_found' => 'Service post not found',
        'unauthorized' => 'You are not authorized to perform this action',
    ],

    // Driver Profiles
    'driver_profile' => [
        'created' => 'Driver profile created successfully',
        'updated' => 'Driver profile updated successfully',
        'deleted' => 'Driver profile deleted successfully',
        'not_found' => 'Driver profile not found',
        'unauthorized' => 'You are not authorized to perform this action',
        'already_exists' => 'You already have a driver profile',
        'cost_calculated' => 'Trip cost calculated successfully',
    ],

    // Helper Posts
    'helper_post' => [
        'created' => 'Helper post created successfully',
        'updated' => 'Helper post updated successfully',
        'deleted' => 'Helper post deleted successfully',
        'not_found' => 'Helper post not found',
        'unauthorized' => 'You are not authorized to perform this action',
        'marked_filled' => 'Helper post marked as filled',
        'marked_completed' => 'Helper post marked as completed',
    ],

    // Assistant Profiles
    'assistant_profile' => [
        'created' => 'Assistant profile created successfully',
        'updated' => 'Assistant profile updated successfully',
        'deleted' => 'Assistant profile deleted successfully',
        'not_found' => 'Assistant profile not found',
        'unauthorized' => 'You are not authorized to perform this action',
        'already_exists' => 'You already have an assistant profile',
        'cost_calculated' => 'Job cost calculated successfully',
    ],

    // Ratings
    'rating' => [
        'created' => 'Rating submitted successfully',
        'not_found' => 'Rating not found',
        'already_rated' => 'You have already rated this entity',
        'cannot_rate_self' => 'You cannot rate yourself',
    ],

    // Messages
    'message' => [
        'sent' => 'Message sent successfully',
        'marked_read' => 'Message marked as read',
        'conversation_created' => 'Conversation created successfully',
        'not_found' => 'Message not found',
        'conversation_not_found' => 'Conversation not found',
        'unauthorized' => 'You are not authorized to access this conversation',
    ],

    // Payments
    'payment' => [
        'created' => 'Payment created successfully',
        'processed' => 'Payment processed successfully',
        'not_found' => 'Payment not found',
        'unauthorized' => 'You are not authorized to access this payment',
        'cannot_refund' => 'Can only refund completed payments',
        'fee_calculated' => 'Platform fee calculated successfully',
    ],

    // Distance Calculator
    'distance' => [
        'calculated' => 'Distance calculated successfully',
        'estimated' => 'Trip estimate calculated successfully',
    ],

    // General
    'general' => [
        'success' => 'Operation completed successfully',
        'error' => 'An error occurred',
        'not_found' => 'Resource not found',
        'unauthorized' => 'Unauthorized action',
        'validation_error' => 'Validation error',
        'server_error' => 'Internal server error',
    ],

    // Error Messages
    'errors' => [
        'validation_failed' => 'Validation failed',
        'unauthenticated' => 'Unauthenticated',
        'unauthorized' => 'Unauthorized',
        'resource_not_found' => 'The requested resource could not be found',
        'endpoint_not_found' => 'The requested endpoint could not be found',
        'method_not_allowed' => 'Method not allowed',
        'too_many_requests' => 'Too many requests',
        'rate_limit_exceeded' => 'Rate limit exceeded. Please try again later.',
        'server_error' => 'Server error',
        'unexpected_error' => 'An unexpected error occurred',
    ],
];
