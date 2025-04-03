<?php

namespace Aaran\Master\Models;

use Aaran\Master\Database\Factories\CompanyDetailFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyDetail extends Model
{
    use HasFactory;

    protected static function newFactory(): CompanyDetailFactory
    {
        return new CompanyDetailFactory();
    }

}
