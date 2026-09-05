<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Applies the visitor's chosen language on every request.
 *
 * Setting the locale inside the /locale route only lasts for that one redirect,
 * so the choice has to be re-applied here from the session each request.
 */
class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale');

        if (in_array($locale, ['en', 'fr'], true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
