<?php

namespace Aaran\Core\Tenant\Models;

use Aaran\Core\Tenant\Database\Factories\FeatureFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    protected $table = 'plans';

    protected $fillable = ['vname','price','billing_cycle', 'description','active_id'];

    protected $casts = [
        'active_id' => 'boolean',
    ];

    protected static function newFactory(): FeatureFactory
    {
        return FeatureFactory::new();
    }
}
