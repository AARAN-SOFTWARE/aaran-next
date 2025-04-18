<?php

namespace Aaran\BMS\Billing\Transaction\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
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

    public static function nextNo($value)
    {
        return static::where('mode_id', '=', $value)
                ->max('vch_no') + 1;
    }
}
