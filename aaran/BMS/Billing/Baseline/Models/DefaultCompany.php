<?php

namespace Aaran\BMS\Billing\Baseline\Models;

use Aaran\BMS\Billing\Master\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DefaultCompany extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

}
