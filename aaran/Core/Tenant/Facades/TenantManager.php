<?php

namespace Aaran\Core\Tenant\Facades;

use Aaran\Core\Tenant\Services\TenantDatabaseService;
use Illuminate\Support\Facades\Facade;

class TenantManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TenantDatabaseService::class;
    }
}
