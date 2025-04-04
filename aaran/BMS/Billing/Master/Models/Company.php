<?php

namespace Aaran\BMS\Billing\Master\Models;

use Aaran\BMS\Billing\Common\Models\City;
use Aaran\BMS\Billing\Common\Models\Country;
use Aaran\BMS\Billing\Common\Models\Pincode;
use Aaran\BMS\Billing\Common\Models\State;
use Aaran\Master\Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

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


    public static function printDetails($ids): Collection
    {
        $obj = self::find($ids);

        return collect([
            'company_name' => $obj->display_name,
            'address_1' => $obj->address_1,
            'address_2' => $obj->address_2,
            'city' => City::find($obj->id)->vname . ' - ' . Pincode::find($obj->id)->vname,
            'city_name' => City::find($obj->id)->vname,
            'state' => State::find($obj->id)->vname . ' - ' . State::find($obj->id)->desc,
            'country' => Country::find($obj->id)->vname,
            'contact' => ' Contact : ' . $obj->mobile,
            'email' => 'Email : ' . $obj->email,
            'gstin' => 'GST : ' . $obj->gstin,
            'gst' => $obj->gstin,
            'msme' => 'MSME No : ' . $obj->msme_no,
            'logo' => $obj->logo,
            'bank' => $obj->bank,
            'acc_no' => $obj->acc_no,
            'ifsc_code' => $obj->ifsc_code,
            'branch' => $obj->branch,
            'inv_pfx' => $obj->inv_pfx,
            'iec_no' => $obj->iec_no,
        ]);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function pincode(): BelongsTo
    {
        return $this->belongsTo(Pincode::class, 'pincode_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }


    protected static function newFactory(): CompanyFactory
    {
        return new CompanyFactory();
    }

//    public function companyDetail():HasMany
//    {
//        return  $this->hasMany(CompanyDetail::class);
//    }
}
