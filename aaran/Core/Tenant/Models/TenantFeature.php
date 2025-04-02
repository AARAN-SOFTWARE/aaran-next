<?php

namespace Aaran\Core\Tenant\Models;

use Illuminate\Database\Eloquent\Model;

class TenantFeature extends Model
{
    protected $fillable = ['tenant_id', 'feature'];
}
