<?php

namespace Aaran\Core\Tenant\Models;

use Aaran\Core\Tenant\Database\Factories\FeatureFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanFeature extends Model
{
    use SoftDeletes;

    protected $table = 'plan_features';

    protected $fillable = ['vname','price','billing_cycle', 'description','active_id'];

    protected $casts = [
        'active_id' => 'boolean',
    ];

    public function scopeActive(Builder $query, $status = '1'): Builder
    {
        return $query->where('active_id', $status);
    }

    public function scopeSearchByName(Builder $query, string $search): Builder
    {
        return $query->where('vname', 'like', "%$search%");
    }

    protected static function newFactory(): FeatureFactory
    {
        return FeatureFactory::new();
    }
}
