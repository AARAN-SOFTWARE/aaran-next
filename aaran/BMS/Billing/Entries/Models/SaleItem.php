<?php

namespace Aaran\BMS\Billing\Entries\Models;

use Aaran\BMS\Billing\Entries\Database\Factories\SaleitemFactory;
use Aaran\BMS\Billing\Master\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function newFactory(): SaleitemFactory
    {
        return new SaleitemFactory();
    }
}
