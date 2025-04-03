<?php

namespace Aaran\BMS\Billing\Books\Models;

use Aaran\Core\Tenant\Facades\TenantManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LedgerGroup extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'ledger_groups'; // Ensure correct table name

    public function scopeActive(Builder $query, $status = '1'): Builder
    {
        return $query->where('active_id', $status);
    }

    public function scopeSearchByName(Builder $query, string $search): Builder
    {
        return $query->where('vname', 'like', "%$search%");
    }

    public function account_head(): BelongsTo
    {
        return $this->belongsTo(AccountHeads::class, 'account_head_id');
    }

}
