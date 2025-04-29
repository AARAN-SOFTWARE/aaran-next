<?php

namespace Aaran\Core\Tenant\Models;

use Aaran\Core\Tenant\Database\Factories\SubscriptionFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id', 'plan_name', 'price', 'status', 'started_at', 'expires_at',
    ];

    protected $dates = ['started_at', 'expires_at'];


    public function scopeActive(Builder $query, $status = '1'): Builder
    {
        return $query->where('active_id', $status);
    }

    public function scopeSearchByName(Builder $query, string $search): Builder
    {
        return $query->where('t_name', 'like', "%$search%");
    }

    public function tenant()
    {
        return $this->belongsTo(\Aaran\Core\Tenant\Models\Tenant::class);
    }

    public function isActive()
    {
        return $this->status === 'active' && now()->lt($this->expires_at);
    }

    protected static function newFactory(): SubscriptionFactory
    {
        return SubscriptionFactory::new();
    }
}
