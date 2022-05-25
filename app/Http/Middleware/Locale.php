<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Request;

class Locale
{
    const LOCALES = ['es', 'en'];

    public function handle(Request $request, Closure $next)
    {
        $locale = $request->get('locale');
        if ($locale && in_array($locale, self::LOCALES)) {
            app('translator')->setLocale($locale);
        } else {
            app('translator')->setLocale(self::LOCALES[0]);
        }

        return $next($request);
    }
}
