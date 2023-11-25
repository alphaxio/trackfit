<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Get the Accept-Language header from the request
        $locale = $request->header('Accept-Language');

        // Check if the locale is supported in your application
        // For example, check if it exists in the `config/app.php` 'locales' array

        // If the locale is supported, set it as the application's locale
        if ($locale && in_array($locale, config('app.locales'))) {
            app()->setLocale($locale);
        } else {
            // If the Accept-Language header is not supported, use the default locale
            app()->setLocale(config('app.fallback_locale'));
        }

        return $next($request);
    }
}
