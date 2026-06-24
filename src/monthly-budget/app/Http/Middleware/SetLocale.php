<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Try to get locale from session, fallback to config otherwise.
        $locale = session('locale', config('app.locale'));

        if (in_array($locale, ['en', 'lt']))
        {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
