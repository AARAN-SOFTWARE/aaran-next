<?php

namespace Aaran\BMS\Billing\Transaction\Models;

use Aaran\BMS\Billing\Common\Models\AccountType;
use Aaran\BMS\Billing\Common\Models\Bank;
use Aaran\BMS\Billing\Common\Models\TransactionType;
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

    public function transaction_type(): BelongsTo
    {
        return $this->belongsTo(TransactionType::class,'transaction_type_id','id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class,'bank_id','id');
    }


    public function account_type(): BelongsTo
    {
        return $this->belongsTo(AccountType::class,'account_type_id','id');
    }

//    protected $connection = 'tenant';
//    protected static function booted()
//    {
//        self::creating(function ($model) {
//        });
//    }

}
