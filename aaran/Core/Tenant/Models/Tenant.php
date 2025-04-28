<?php

namespace Aaran\Core\Tenant\Models;

use Aaran\Core\Tenant\Database\Factories\TenantFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tenants'; // Explicitly set table name

    protected $fillable = [
        'b_name', 't_name', 'email', 'contact', 'phone',
        'db_name', 'db_host', 'db_port', 'db_user', 'db_pass',
        'plan', 'subscription_start', 'subscription_end',
        'storage_limit', 'user_limit', 'is_active', 'industry_code',
        'settings', 'enabled_features', 'two_factor_enabled', 'api_key',
        'whitelisted_ips', 'allow_sso', 'active_users', 'requests_count',
        'disk_usage', 'last_active_at'
    ];

    protected $casts = [
        'settings' => 'array',
        'enabled_features' => 'array',
        'whitelisted_ips' => 'array',
        'is_active' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'allow_sso' => 'boolean',
        'storage_limit' => 'float',
        'disk_usage' => 'float',
        'subscription_start' => 'date',
        'subscription_end' => 'date',
        'last_active_at' => 'datetime',
    ];

//TODO: IN FUTURE
//
//    protected function getDbPassAttribute($value)
//    {
//        return $value ? Crypt::decryptString($value) : null;
//    }
//
//    protected function setDbPassAttribute($value)
//    {
//        $this->attributes['db_pass'] = $value ? Crypt::encryptString($value) : null;
//    }
//
//    protected function getApiKeyAttribute($value)
//    {
//        return $value ? Crypt::decryptString($value) : null;
//    }
//
//    protected function setApiKeyAttribute($value)
//    {
//        $this->attributes['api_key'] = $value ? Crypt::encryptString($value) : null;
//    }

    public function scopeActive(Builder $query, $status = '1'): Builder
    {
        return $query->where('active_id', $status);
    }

    public function scopeSearchByName(Builder $query, string $search): Builder
    {
        return $query->where('t_name', 'like', "%$search%");
    }

    /**
     * Relationship: A Tenant has many Users.
     */
    public function users()
    {
        return $this->hasMany(\Aaran\Core\User\Models\User::class);
    }

    /**
     * Define the factory for this model.
     */
    protected static function newFactory(): TenantFactory
    {
        return TenantFactory::new();
    }
}
