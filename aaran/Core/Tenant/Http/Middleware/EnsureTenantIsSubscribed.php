<?php

namespace Aaran\Core\Tenant\Http\Middleware;

use Aaran\Core\Tenant\Services\CentralSubscriptionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantIsSubscribed
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('tenant_id')) {

            if (!CentralSubscriptionService::isValid(session('tenant_id'))) {
                return redirect()->route('subscription.expired');
            }
        }
        return $next($request);
    }
}
