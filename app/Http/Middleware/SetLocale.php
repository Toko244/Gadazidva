<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Check for locale in request header
        $locale = $request->header('Accept-Language', config('app.locale'));

        // Validate locale is available
        if (in_array($locale, config('app.available_locales'))) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
