<?php

namespace Aaran\BMS\Billing\Entries\Models;

use Aaran\BMS\Billing\Entries\Database\Factories\SaleFactory;
use Aaran\BMS\Billing\Master\Models\Contact;
use Aaran\BMS\Billing\Master\Models\ContactAddress;
use Aaran\BMS\Billing\Master\Models\Order;
use Aaran\BMS\Billing\Master\Models\Style;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sale extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeActive(Builder $query, $status = '1'): Builder
    {
        return $query->where('active_id', $status);
    }
    public static function search(string $searches)
    {
        return empty($searches) ? static::query()
            : static::where('invoice_no', 'like', '%' . $searches . '%');
    }

    public function scopeSearchByName(Builder $query, string $search): Builder
    {
        return $query->whereHas('contact', function ($q) use ($search) {
            $q->where('vname', 'like', "%$search%");
        });
    }

    public static function nextNo($connection = null)
    {
        $model = new static;
        $model->setConnection($connection);

        return $model->newQuery()
                ->max('invoice_no') + 1;
    }

    public function saleItems():HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function contactDetail(): BelongsTo
    {
        return $this->belongsTo(ContactAddress::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function style(): BelongsTo
    {
        return $this->belongsTo(Style::class);
    }

    protected static function newFactory(): SaleFactory
    {
        return new SaleFactory();
    }
}
