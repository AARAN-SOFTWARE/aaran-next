<?php

namespace Aaran\BMS\Billing\Entries\Models;

use Aaran\BMS\Billing\Master\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseItem extends Model
{
//    use HasFactory;

    protected $guarded = [];

    public $timestamps=false;

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function purchase():BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }
}
