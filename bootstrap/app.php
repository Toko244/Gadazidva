<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Global middleware
        $middleware->append(\App\Http\Middleware\SetLocale::class);

        // Middleware aliases
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Custom JSON error handling for API requests
        $exceptions->render(function (Throwable $e, $request) {
            // Check if request expects JSON (API routes or Accept header)
            if ($request->is('api/*') || $request->expectsJson()) {
                // Handle validation exceptions
                if ($e instanceof \Illuminate\Validation\ValidationException) {
                    return response()->json([
                        'success' => false,
                        'message' => __('messages.errors.validation_failed'),
                        'errors' => $e->errors(),
                    ], 422);
                }

                // Handle authentication exceptions
                if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                    return response()->json([
                        'success' => false,
                        'message' => __('messages.errors.unauthenticated'),
                        'error' => $e->getMessage(),
                    ], 401);
                }

                // Handle authorization exceptions
                if ($e instanceof \Illuminate\Auth\Access\AuthorizationException) {
                    return response()->json([
                        'success' => false,
                        'message' => __('messages.errors.unauthorized'),
                        'error' => $e->getMessage(),
                    ], 403);
                }

                // Handle model not found exceptions
                if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                    return response()->json([
                        'success' => false,
                        'message' => __('messages.general.not_found'),
                        'error' => __('messages.errors.resource_not_found'),
                    ], 404);
                }

                // Handle method not allowed exceptions
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
                    return response()->json([
                        'success' => false,
                        'message' => __('messages.errors.method_not_allowed'),
                        'error' => $e->getMessage(),
                    ], 405);
                }

                // Handle not found (404) exceptions
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
                    return response()->json([
                        'success' => false,
                        'message' => __('messages.general.not_found'),
                        'error' => __('messages.errors.endpoint_not_found'),
                    ], 404);
                }

                // Handle throttle exceptions (rate limiting)
                if ($e instanceof \Illuminate\Http\Exceptions\ThrottleRequestsException) {
                    return response()->json([
                        'success' => false,
                        'message' => __('messages.errors.too_many_requests'),
                        'error' => __('messages.errors.rate_limit_exceeded'),
                    ], 429);
                }

                // Handle HTTP exceptions with status codes
                if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface) {
                    return response()->json([
                        'success' => false,
                        'message' => \Illuminate\Http\Response::$statusTexts[$e->getStatusCode()] ?? __('messages.general.error'),
                        'error' => $e->getMessage() ?: __('messages.general.error'),
                    ], $e->getStatusCode());
                }

                // Get status code for other exceptions
                $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
                $statusCode = ($statusCode >= 100 && $statusCode < 600) ? $statusCode : 500;

                // Build error response
                $response = [
                    'success' => false,
                    'message' => __('messages.errors.server_error'),
                    'error' => config('app.debug') ? $e->getMessage() : __('messages.errors.unexpected_error'),
                ];

                // Add debug information in debug mode
                if (config('app.debug')) {
                    $response['debug'] = [
                        'exception' => get_class($e),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => collect($e->getTrace())->take(5)->map(function ($trace) {
                            return [
                                'file' => $trace['file'] ?? 'unknown',
                                'line' => $trace['line'] ?? 0,
                                'function' => $trace['function'] ?? 'unknown',
                            ];
                        })->toArray(),
                    ];
                }

                return response()->json($response, $statusCode);
            }

            // Return null to use default Laravel error handling for non-API requests
            return null;
        });
    })->create();
