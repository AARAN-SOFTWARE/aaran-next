<?php

namespace Aaran\BMS\Billing\Books\Models;

use Aaran\Core\User\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ledger extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeActive(Builder $query, $status = '1'): Builder
    {
        return $query->where('active_id', $status);
    }

    public function scopeSearchByName(Builder $query, string $search): Builder
    {
        return $query->where('vname', 'like', "%$search%");
    }

    public function ledger_group(): BelongsTo
    {
        return $this->belongsTo(LedgerGroup::class, 'ledger_group_id');
    }
}
