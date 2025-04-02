<?php

namespace Aaran\Common\Models;

use Aaran\Common\Database\Factories\TransactionTypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{

    use HasFactory;

    protected $table = 'transaction_types'; // Ensure this is correct

    protected $guarded = [];

    public $timestamps = false;

    public static function search(string $searches)
    {
        return empty($searches) ? static::query()
            : static::where('vname', 'like', '%' . $searches . '%');
    }

    protected static function newFactory(): TransactionTypeFactory
    {
        return new TransactionTypeFactory();
    }
}
