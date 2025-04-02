<?php

namespace Aaran\Core\Tenant\Models;

use Aaran\Core\Tenant\Database\Factories\FeatureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'features'; // Explicitly set table name

    protected $fillable = ['name', 'code','is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function industries(): BelongsToMany
    {
        return $this->belongsToMany(Industry::class, 'industry_feature');
    }

    /**
     * Define the factory for this model.
     */
    protected static function newFactory(): FeatureFactory
    {
        return FeatureFactory::new();
    }
}
