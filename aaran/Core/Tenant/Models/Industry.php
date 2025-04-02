<?php

namespace Aaran\Core\Tenant\Models;

use Aaran\Core\Tenant\Database\Factories\IndustryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industry extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'industries'; // Explicitly set table name

    protected $fillable = ['name', 'code','is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(Feature::class, 'industry_feature');
    }

    /**
     * Define the factory for this model.
     */
    protected static function newFactory(): IndustryFactory
    {
        return IndustryFactory::new();
    }
}
