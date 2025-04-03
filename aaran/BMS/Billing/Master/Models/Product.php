<?php

namespace Aaran\Master\Models;

use Aaran\Assets\Enums\ProductType;
use Aaran\BMS\Billing\Common\Models\GstPercent;
use Aaran\BMS\Billing\Common\Models\Hsncode;
use Aaran\BMS\Billing\Common\Models\Unit;
use Aaran\Master\Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];


    public static function search(string $searches)
    {
        return empty($searches) ? static::query()
            : static::where('vname', 'like', '%' . $searches . '%');
    }

    public function hsncode(): BelongsTo
    {
        return $this->belongsTo(Hsncode::class, 'hsncode_id', 'id');
    }


    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function gstpercent(): BelongsTo
    {
        return $this->belongsTo(GstPercent::class, 'gstpercent_id', 'id');
    }

    protected static function newFactory(): ProductFactory
    {
        return new ProductFactory();
    }

    protected $casts = [
        'producttype_id' => ProductType::class, // Casts to Enum
    ];

}
