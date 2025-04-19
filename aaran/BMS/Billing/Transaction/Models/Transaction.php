<?php

namespace Aaran\BMS\Billing\Transaction\Models;

use Aaran\BMS\Billing\Common\Models\Bank;
use Aaran\BMS\Billing\Master\Models\Contact;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{

    protected $guarded = [];

    public function scopeActive(Builder $query, $status = '1'): Builder
    {
        return $query->where('active_id', $status);
    }

    public function scopeSearchByName(Builder $query, string $search): Builder
    {
        return $query->whereHas('contact', function ($q) use ($search) {
            $q->where('vname', 'like', "%$search%");
        });
    }

    public static function nextNo($connection = null, $account_book_id = null)
    {
        $model = new static;
        $model->setConnection($connection);

        return $model->newQuery()
                ->where('account_book_id', $account_book_id)
                ->max('vch_no') + 1;
    }

    public function account_book(): BelongsTo
    {
        return $this->belongsTo(AccountBook::class, 'account_book_id', 'id');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function instrument_bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class, 'instrument_bank_id', 'id');
    }

}
