<?php

namespace Aaran\Common\Models;

use Aaran\Common\Database\Factories\PaymentModeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMode extends Model
{
    use HasFactory;

    protected $table = 'payment_modes'; // Ensure this is correct

    protected $guarded = [];

    public $timestamps = false;

    public static function search(string $searches)
    {
        return empty($searches) ? static::query()
            : static::where('vname', 'like', '%' . $searches . '%');
    }

    protected static function newFactory(): PaymentModeFactory
    {
        return new PaymentModeFactory();
    }

}
