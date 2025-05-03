<?php

namespace Aaran\ExternalPartners\Razorpay\Models;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RazorPayment  extends Model
{
    protected $fillable = [
        'order_id',
        'payment_id',
        'signature',
        'amount',
        'currency',
        'status',
        'method',
        'email',
        'contact',
        'description',
        'tenant_id',
        'user_id',
    ];

    public function scopeSearchByName(Builder $query, string $search): Builder
    {
        return $query->whereHas('tenant', function ($q) use ($search) {
            $q->where('t_name', 'like', "%$search%");
        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

}
