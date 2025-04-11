<?php

namespace Aaran\Entries\Models;

use Aaran\Common\Models\Common;
use Aaran\BMS\Billing\Entries\Database\Factories\PurchaseFactory;
use Aaran\BMS\Billing\Master\Models\Company;
use Aaran\BMS\Billing\Master\Models\Contact;
use Aaran\BMS\Billing\Master\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function search(string $searches): Builder
    {
        return empty($searches) ? static::query()
            : static::where('purchase_no', 'like', '%' . $searches . '%');
    }

    public static function nextNo()
    {
        return static::where('company_id','=',session()->get('company_id'))->max('Entry_no') + 1;
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function common(): BelongsTo
    {
        return $this->belongsTo(Common::class);
    }

    protected static function newFactory(): PurchaseFactory
    {
        return new PurchaseFactory();
    }

    public function purchaseItems():HasMany
    {
        return $this->hasMany(Purchaseitem::class);
    }


}
