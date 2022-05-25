<?php

namespace App\Http\Middleware;

use App\Services\RequestData;
use Closure;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Request;

class Logger
{
    public function handle(Request $request, Closure $next)
    {

        $ip  = RequestData::clientIpAddress();
        $uri = $request->getUri();

        Log::channel('access')->info('IP: ' . $ip . ' URI: ' . $uri);

        return $next($request);
    }
}
