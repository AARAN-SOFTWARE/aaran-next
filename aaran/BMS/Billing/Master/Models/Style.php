<?php

namespace Aaran\BMS\Billing\Master\Models;

use Aaran\Master\Database\Factories\StyleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Style extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    public static function search(string $searches)
    {
        return empty($searches) ? static::query()
            : static::where('vname', 'like', '%' . $searches . '%');
    }

    public function scopeActive(Builder $query, $status = '1'): Builder
    {
        return $query->where('active_id', $status);
    }

    public function scopeSearchByName(Builder $query, string $search): Builder
    {
        return $query->where('vname', 'like', "%$search%");
    }


    protected static function newFactory(): StyleFactory
    {
        return new StyleFactory();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function printDetails($ids): Collection
    {
        $obj = self::find($ids);

        return collect([
            'description' => $obj->description,]);

    }
}
