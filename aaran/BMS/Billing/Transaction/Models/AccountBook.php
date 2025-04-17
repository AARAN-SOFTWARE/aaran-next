<?php

namespace Aaran\BMS\Billing\Transaction\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountBook extends Model
{

    protected $guarded = [];

    public function scopeActive(Builder $query, $status = '1'): Builder
    {
        return $query->where('active_id', $status);
    }

    public function scopeSearchByName(Builder $query, string $search): Builder
    {
        return $query->where('vname', 'like', "%$search%");
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class,'account_book_id','id');

    }

    public function accountBook(): BelongsTo
    {
        return $this->belongsTo(Transaction::class,'account_book_id','id');
    }
}
