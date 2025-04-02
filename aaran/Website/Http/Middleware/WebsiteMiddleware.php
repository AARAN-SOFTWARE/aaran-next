<?php

namespace Aaran\Website\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class WebsiteMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if the request is routed through the 'web' middleware group
        if ($request->route() && collect($request->route()->gatherMiddleware())->contains('website')) {

            Log::info('Access Granted: Request passed through the web middleware group.', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
            ]);
        }
        return $next($request);
    }
}
