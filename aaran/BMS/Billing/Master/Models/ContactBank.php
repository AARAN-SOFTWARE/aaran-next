<?php

namespace Aaran\BMS\Billing\Master\Models;


use Aaran\BMS\Billing\Common\Models\City;
use Aaran\BMS\Billing\Common\Models\Country;
use Aaran\BMS\Billing\Common\Models\Pincode;
use Aaran\BMS\Billing\Common\Models\State;
use Aaran\Master\Database\Factories\ContactDetailFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class ContactBank extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function search(string $searches)
    {
        return empty($searches) ? static::query()
            : static::where('address_1', 'like', '%' . $searches . '%');
    }

    public static function getId(mixed $contact_id)
    {
        $obj = self::where('contact_id', '=', $contact_id)->firstOrFail();;
        return $obj->id;
    }

    public static function printDetails($ids): Collection
    {
        $obj = self::find($ids);

        return collect([
            'address_1' => $obj->address_1,
            'address_2' => $obj->address_2,
            'address_3' => City::find($obj->city_id)->vname . ' - ' . Pincode::find($obj->pincode_id)->vname . '.  ' . State::find($obj->state_id)->state_code,
            'country' => Country::find($obj->id)->vname,
            'gstcell' => 'GSTin : ' . $obj->gstin,
            'gstContact' => $obj->gstin,
            'email' => $obj->email,
        ]);
    }

    protected static function newFactory(): ContactDetailFactory
    {
        return new ContactDetailFactory();
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function pincode(): BelongsTo
    {
        return $this->belongsTo(Pincode::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

}
