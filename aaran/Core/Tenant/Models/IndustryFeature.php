<?php

namespace Aaran\Core\Tenant\Models;

use Aaran\Core\Tenant\Database\Factories\IndustryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IndustryFeature extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'industry_features'; // Explicitly set table name

    protected $fillable = ['industry_id', 'feature_id',  'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Define the factory for this model.
     */
    protected static function newFactory(): IndustryFactory
    {
        return IndustryFactory::new();
    }
}
