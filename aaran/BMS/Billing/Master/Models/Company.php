<?php

namespace Aaran\BMS\Billing\Master\Models;

use Aaran\Assets\Traits\TenantAwareTrait;
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
    use HasFactory,TenantAwareTrait;

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

    public static function printDetails(): Collection
    {
        $modelInstance = new static;
        $connection = $modelInstance->getTenantConnection();
        $companyId = session('company_id');

        if (!$companyId) {
            return collect(); // or throw new \Exception("No company_id in session");
        }

        $company = $modelInstance->setConnection($connection)
            ->with(['city', 'pincode', 'state', 'country'])
            ->find($companyId);

        if (!$company) {
            return collect(); // or throw new \Exception("Company not found");
        }

        return collect([
            'company_name' => $company->display_name,
            'address_1' => $company->address_1,
            'address_2' => $company->address_2,
            'city' => optional($company->city)->vname . ' - ' . optional($company->pincode)->vname,
            'city_name' => optional($company->city)->vname,
            'state' => optional($company->state)->vname . ' - ' . optional($company->state)->desc,
            'country' => optional($company->country)->vname,
            'contact' => ' Contact : ' . $company->mobile,
            'email' => 'Email : ' . $company->email,
            'gstin' => 'GST : ' . $company->gstin,
            'gst' => $company->gstin,
            'msme' => 'MSME No : ' . $company->msme_no,
            'logo' => $company->logo,
            'bank' => $company->bank,
            'acc_no' => $company->acc_no,
            'ifsc_code' => $company->ifsc_code,
            'branch' => $company->branch,
            'inv_pfx' => $company->inv_pfx,
            'iec_no' => $company->iec_no,
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
