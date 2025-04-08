<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class;

use Aaran\Assets\Enums\MsmeType;
use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Common\Models\City;
use Aaran\BMS\Billing\Common\Models\ContactType;
use Aaran\BMS\Billing\Common\Models\Country;
use Aaran\BMS\Billing\Common\Models\Pincode;
use Aaran\BMS\Billing\Common\Models\State;
use Aaran\BMS\Billing\Master\Models\Contact;
use Aaran\BMS\Billing\Master\Models\ContactAddress;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactUpsert extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    #region[properties]

    #[Validate]
    public string $vname = '';
    public string $mobile = '';
    public string $whatsapp = '';
    public string $contact_person = '';
    public mixed $contact_type_id = '';
    public string $msme_no = '';
    public string $msme_type_id = '';
    public mixed $opening_balance = 0;
    public mixed $outstanding = 0;
    public string $effective_from = '';
    #[Validate]
    public string $gstin = '';
    public string $email = '';
    public bool $active_id = true;
    public $address_type = '';

    #region[Address Properties]
    #[validate]
    public array $itemList = [];
    public array $secondaryAddress = [];
    public int $addressIncrement = 0;
    public int $openTab = 0;
    public mixed $itemIndex = '';

    #endregion

    #endregion

    #region[rules]
    public string $route;

    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.contacts,vname"),
            'mobile' => 'required',
            'gstin' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.contacts,gstin"),
            'contact_type_name' => 'required',

//            'itemList.0.address_1' => 'required',
//            'itemList.0.address_2' => 'required',
//            'itemList.0.city_name' => 'required',
//            'itemList.0.state_name' => 'required',
//            'itemList.0.pincode_name' => 'required',
//            'itemList.0.country_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'vname.required' => ' :attribute is required.',
            'gstin.required' => ' :attribute is required.',
            'mobile.required' => ' :attribute is required.',
            'contact_type_name.required' => ' :attribute is required.',

            'vname.unique' => ' :attribute is already taken.',
            'gstin.unique' => ' :attribute is already taken.',

//            'itemList.0.address_1.required' => ' :attribute  is required.',
//            'itemList.0.address_2.required' => ' :attribute  is required.',
//            'itemList.0.city_name.required' => ' :attribute  is required.',
//            'itemList.0.state_name.required' => ' :attribute  is required.',
//            'itemList.0.pincode_name.required' => ' :attribute  is required.',
//            'itemList.0.country_name' => ' :attribute  is required.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'vname' => 'contact name',
            'gstin' => 'GST No',
            'mobile' => 'Mobile no',
            'contact_type_name' => 'Contact Type',

//            'itemList.0.address_1' => 'Address',
//            'itemList.0.address_2' => 'Area Road',
//            'itemList.0.city_name' => 'City name',
//            'itemList.0.state_name' => 'State name',
//            'itemList.0.pincode_name' => 'Pincode name',
//            'itemList.0.country_name' => 'Country name',
        ];
    }
    #endregion

    #region[City]
    #[validate]
    public $city_name = '';
    public $city_id = '';
    public $cityCollection;
    public $highlightCity = 0;
    public $cityTyped = false;

    public function decrementCity(): void
    {
        if ($this->highlightCity === 0) {
            $this->highlightCity = count($this->cityCollection) - 1;
            return;
        }
        $this->highlightCity--;
    }

    public function incrementCity(): void
    {
        if ($this->highlightCity === count($this->cityCollection) - 1) {
            $this->highlightCity = 0;
            return;
        }
        $this->highlightCity++;
    }

    public function setCity($vname, $id, $index = 0): void
    {
        if (!is_null($index)) {
            Arr::set($this->itemList[$index], 'city_name', $vname);
            Arr::set($this->itemList[$index], 'city_id', $id);
        }

        $this->getCityList($index);
    }

    public function enterCity($index = 0): void
    {
        $obj = $this->cityCollection[$this->highlightCity] ?? null;

        $this->city_name = '';
        $this->cityCollection = Collection::empty();
        $this->highlightCity = 0;

        $this->city_name = $obj['vname'] ?? '';;
        $this->city_id = $obj['id'] ?? '';

        if (!is_null($index)) {
            Arr::set($this->itemList[$index], 'city_name', $obj['vname']);
            Arr::set($this->itemList[$index], 'city_id', $obj['id']);
        }

    }

    #[On('refresh-city')]
    public function refreshCity($v, $index = 0): void
    {
        $this->city_id = $v['id'];
        $this->city_name = $v['vname'];

        if (!is_null($index)) {
            Arr::set($this->itemList[$index], 'city_name', $v['vname']);
            Arr::set($this->itemList[$index], 'city_id', $v['id']);
        }

        $this->cityTyped = false;
    }


    public function citySave($vname, $index = 0)
    {
        $obj = City::on($this->getTenantConnection())->create([
            'vname' => $vname,
            'active_id' => '1'
        ]);
        $v = ['vname' => $vname, 'id' => $obj->id];
        $this->refreshCity($v, $index);
    }

    public function getCityList($index = 0): void
    {
        if ($index !== 0) {
            dd($index);
        }

        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $search = $this->itemList[$index]['city_name'] ?? '';

        $this->cityCollection = DB::connection($this->getTenantConnection())
            ->table('cities')
            ->when($search, fn($query) => $query->where('vname', 'like', "%{$search}%"))
            ->get();

    }

    #endregion

    #region[State]
    #[validate]
    public $state_name = '';
    public $state_id = '';
    public $stateCollection;
    public $highlightState = 0;
    public $stateTyped = false;

    public function decrementState(): void
    {
        if ($this->highlightState === 0) {
            $this->highlightState = count($this->stateCollection) - 1;
            return;
        }
        $this->highlightState--;
    }

    public function incrementState(): void
    {
        if ($this->highlightState === count($this->stateCollection) - 1) {
            $this->highlightState = 0;
            return;
        }
        $this->highlightState++;
    }

    public function setState($vname, $id, $index): void
    {
        $this->state_name = $vname;
        $this->state_id = $id;
        Arr::set($this->itemList[$index], 'state_name', $vname);
        Arr::set($this->itemList[$index], 'state_id', $id);
        $this->getStateList();
    }

    public function enterState($index): void
    {
        $obj = $this->stateCollection[$this->highlightState] ?? null;

        $this->state_name = '';
        $this->stateCollection = Collection::empty();
        $this->highlightState = 0;

        $this->state_name = $obj['vname'] ?? '';;
        $this->state_id = $obj['id'] ?? '';;
        Arr::set($this->itemList[$index], 'state_name', $obj['vname']);
        Arr::set($this->itemList[$index], 'state_id', $obj['id']);
    }

    #[On('refresh-state')]
    public function refreshState($v): void
    {
        $this->state_id = $v['id'];
        $this->state_name = $v['vname'];

        Arr::set($this->itemList[$v['index']], 'state_name', $v['vname']);
        Arr::set($this->itemList[$v['index']], 'state_id', $v['id']);

        $this->stateTyped = false;
    }


    public function stateSave($vname, $index)
    {
        $obj = State::on($this->getTenantConnection())->create([
            'vname' => $vname,
            'active_id' => 1
        ]);
        $v = ['vname' => $vname, 'id' => $obj->id, 'index' => $index];
        $this->refreshState($v);
    }


    public function getStateList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->stateCollection = DB::connection($this->getTenantConnection())
            ->table('states')
            ->when($this->state_name, fn($query) => $query->where('vname', 'like', "%{$this->state_name}%"))
            ->get();
    }

    #endregion

    #region[Pincode]
    #[validate]
    public $pincode_id = '';
    public $pincode_name = '';
    public $pincodeCollection;
    public $highlightPincode = 0;
    public $pincodeTyped = false;

    public function decrementPincode(): void
    {
        if ($this->highlightPincode === 0) {
            $this->highlightPincode = count($this->pincodeCollection) - 1;
            return;
        }
        $this->highlightPincode--;
    }

    public function incrementPincode(): void
    {
        if ($this->highlightPincode === count($this->pincodeCollection) - 1) {
            $this->highlightPincode = 0;
            return;
        }
        $this->highlightPincode++;
    }

    public function enterPincode($index): void
    {
        $obj = $this->pincodeCollection[$this->highlightPincode] ?? null;

        $this->pincode_name = '';
        $this->pincodeCollection = Collection::empty();
        $this->highlightPincode = 0;

        $this->pincode_name = $obj['vname'] ?? '';;
        $this->pincode_id = $obj['id'] ?? '';;
        Arr::set($this->itemList[$index], 'pincode_name', $obj['vname']);
        Arr::set($this->itemList[$index], 'pincode_id', $obj['id']);
    }

    public function setPincode($vname, $id, $index): void
    {
        $this->pincode_name = $vname;
        $this->pincode_id = $id;
        Arr::set($this->itemList[$index], 'pincode_name', $vname);
        Arr::set($this->itemList[$index], 'pincode_id', $id);
        $this->getPincodeList();
    }

    #[On('refresh-pincode')]
    public function refreshPincode($v): void
    {
        $this->pincode_id = $v['id'];
        $this->pincode_name = $v['vname'];
        Arr::set($this->itemList[$v['index']], 'pincode_name', $v['vname']);
        Arr::set($this->itemList[$v['index']], 'pincode_id', $v['id']);
        $this->pincodeTyped = false;
    }

    public function pincodeSave($vname, $index)
    {
        $obj = Pincode::on($this->getTenantConnection())->create([
            'vname' => $vname,
            'active_id' => 1
        ]);
        $v = ['vname' => $vname, 'id' => $obj->id, 'index' => $index];
        $this->refreshPincode($v);
    }

    public function getPincodeList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->pincodeCollection = DB::connection($this->getTenantConnection())
            ->table('pincodes')
            ->when($this->pincode_name, fn($query) => $query->where('vname', 'like', "%{$this->pincode_name}%"))
            ->get();
    }


    #endregion

    #region[Country]
    #[validate]
    public $country_name = '';
    public $country_id = '';
    public $countryCollection;
    public $highlightCountry = 0;
    public $countryTyped = false;

    public function decrementCountry(): void
    {
        if ($this->highlightCountry === 0) {
            $this->highlightCountry = count($this->countryCollection) - 1;
            return;
        }
        $this->highlightCountry--;
    }

    public function incrementCountry(): void
    {
        if ($this->highlightCountry === count($this->countryCollection) - 1) {
            $this->highlightCountry = 0;
            return;
        }
        $this->highlightCountry++;
    }

    public function enterCountry($index): void
    {
        $obj = $this->countryCollection[$this->highlightCountry] ?? null;

        $this->country_name = '';
        $this->countryCollection = Collection::empty();
        $this->highlightCountry = 0;

        $this->country_name = $obj->vname ?? '';;
        $this->country_id = $obj->id ?? '';;

        Arr::set($this->itemList[$index], 'country_name', $obj->vname);
        Arr::set($this->itemList[$index], 'country_id', $obj->id);
    }

    public function setCountry($vname, $id, $index): void
    {
        $this->country_name = $vname;
        $this->country_id = $id;
        Arr::set($this->itemList[$index], 'country_name', $vname);
        Arr::set($this->itemList[$index], 'country_id', $id);
        $this->getcountryList();
    }

    #[On('refresh-country')]
    public function refreshCountry($v): void
    {
        $this->country_id = $v['id'];
        $this->country_name = $v['vname'];
        Arr::set($this->itemList[$v['index']], 'country_name', $v['vname']);
        Arr::set($this->itemList[$v['index']], 'country_id', $v['id']);
        $this->countryTyped = false;
    }

    public function countrySave($vname, $index)
    {
        $obj = Country::on($this->getTenantConnection())->create([
            'vname' => $vname,
            'active_id' => 1
        ]);
        $v = ['vname' => $vname, 'id' => $obj->id, 'index' => $index];
        $this->refreshCountry($v);
    }


    public function getCountryList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->countryCollection = DB::connection($this->getTenantConnection())
            ->table('countries')
            ->when($this->country_name, fn($query) => $query->where('vname', 'like', "%{$this->country_name}%"))
            ->get();
    }

    #endregion

    #region[Contact Type]
    public $contact_type_name = '';
    public $contactTypeCollection;
    public $highlightContactType = 0;
    public $contactTypeTyped = false;

    public function decrementContactType(): void
    {
        if ($this->highlightContactType === 0) {
            $this->highlightContactType = count($this->contactTypeCollection) - 1;
            return;
        }
        $this->highlightContactType--;
    }

    public function incrementContactType(): void
    {
        if ($this->highlightContactType === count($this->contactTypeCollection) - 1) {
            $this->highlightContactType = 0;
            return;
        }
        $this->highlightContactType++;
    }

    public function setContactType($vname, $id): void
    {
        $this->contact_type_name = $vname;
        $this->contact_type_id = $id;
        $this->getContactTypeList();
    }

    public function enterContactType(): void
    {
        $obj = $this->contactTypeCollection[$this->highlightContactType] ?? null;

        $this->contact_type_name = '';
        $this->contactTypeCollection = Collection::empty();
        $this->highlightContactType = 0;

        $this->contact_type_name = $obj->vname ?? '';
        $this->contact_type_id = $obj->id ?? '';
    }

    #[On('refresh-contact-type')]
    public function refreshContactType($v): void
    {
        $this->contact_type_id = $v['id'];
        $this->contact_type_name = $v['vname'];
        $this->contactTypeTyped = false;
    }

    public function contactTypeSave($vname)
    {
        $obj = ContactType::on($this->getTenantConnection())->create([
            'vname' => $vname,
            'active_id' => '1'
        ]);

        $v = ['vname' => $vname, 'id' => $obj->id];
        $this->refreshContactType($v);
    }

    public function getContactTypeList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->contactTypeCollection = DB::connection($this->getTenantConnection())
            ->table('contact_types')
            ->when($this->contact_type_name, fn($query) => $query->where('vname', 'like', "%{$this->contact_type_name}%"))
            ->get();
    }

    #endregion

    #region[MSME Type]
    public $msme_type_name = '';
    public array $msmeTypeCollection = [];
    public $highlightMsmeType = 0;
    public $msmeTypeTyped = false;

    public function decrementMsmeType(): void
    {
        if ($this->highlightMsmeType === 0) {
            $this->highlightMsmeType = count($this->msmeTypeCollection) - 1;
            return;
        }
        $this->highlightMsmeType--;
    }

    public function incrementMsmeType(): void
    {
        if ($this->highlightMsmeType === count($this->msmeTypeCollection) - 1) {
            $this->highlightMsmeType = 0;
            return;
        }
        $this->highlightMsmeType++;
    }

    public function setMsmeType($id): void
    {
        $id = (int)$id; // Convert to integer before passing it
        $msmeType = MsmeType::tryFrom($id);

        if ($msmeType) {
            $this->msme_type_id = $msmeType->value;
            $this->msme_type_name = $msmeType->getName();
        }
    }


    public function enterMsmeType(): void
    {
        $obj = $this->msmeTypeCollection[$this->highlightMsmeType] ?? null;
        $this->msmeTypeCollection = [];
        $this->highlightMsmeType = 0;

        if ($obj) {
            $this->setMsmeType($obj['id']);
        }
    }

    #[On('refresh-msme-type')]
    public function refreshMsmeType($v): void
    {
        $this->setMsmeType($v['id']);
        $this->msmeTypeTyped = false;
    }

    public function getMsmeTypeList(): void
    {
        $this->msmeTypeCollection = collect(MsmeType::cases())->map(fn($type) => [
            'id' => $type->value,
            'vname' => $type->getName(),
        ])->toArray();
    }

    #endregion

    #region[Save]
    public function save(): void
    {
        $this->validate($this->rules());

        $connection = $this->getTenantConnection();

        $contact = Contact::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'vname' => Str::upper($this->vname),
                'mobile' => $this->mobile ?? null,
                'whatsapp' => $this->whatsapp ?? null,
                'contact_person' => $this->contact_person ?? null,
                'contact_type_id' => $this->contact_type_id,
                'msme_no' => $this->msme_no ?: '-',
                'msme_type_id' => $this->msme_type_id ?: '1',
                'opening_balance' => $this->opening_balance ?? 0,
                'outstanding' => $this->outstanding ?? 0,
                'effective_from' => $this->effective_from ?? null,
                'gstin' => Str::upper($this->gstin),
                'email' => $this->email ?? null,
                'active_id' => $this->active_id ?? 1,
            ]
        );

        $this->saveItem($contact->id);

        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();
        $this->getRoute();

    }
    #endregion

    #region[clear fields]
    public function clearFields()
    {
        $this->vname = '';
        $this->mobile = '';
        $this->whatsapp = '';
        $this->contact_person = '';
        $this->contact_type_id = '';
        $this->msme_no = '';
        $this->msme_type_id = '';
        $this->opening_balance = '';
        $this->effective_from = '';
        $this->gstin = '';
        $this->email = '';
    }
    #endregion

    #region[Mount]

    public function mount($id): void
    {
        $this->route = url()->previous();

        if ($id == 0) return;

        $contact = Contact::on($this->getTenantConnection())->find($id) ?? abort(404, 'Contact not found.');
        $this->fillContactData($contact);
        $this->loadContactAddresses($id);

    }

    #endregion

    #region[Secondary Address]

    protected function fillContactData($contact): void
    {
        $this->vid = $contact->id;
        $this->vname = $contact->vname;
        $this->mobile = $contact->mobile;
        $this->whatsapp = $contact->whatsapp;
        $this->contact_person = $contact->contact_person;
        $this->contact_type_id = $contact->contact_type_id;
        $this->contact_type_name = $contact->contact_type->vname ?? '-';
        $this->msme_no = $contact->msme_no;
        $this->msme_type_id = $contact->msme_type_id;
        $this->msme_type_name = MsmeType::tryFrom($contact->msme_type_id)->getName();
        $this->opening_balance = $contact->opening_balance;
        $this->outstanding = $contact->outstanding;
        $this->effective_from = $contact->effective_from;
        $this->gstin = $contact->gstin;
        $this->email = $contact->email;
        $this->active_id = $contact->active_id;
    }

    protected function loadContactAddresses($contactId): void
    {
        $default = $this->defaultAddress();

        $addresses = DB::connection($this->getTenantConnection())
            ->table('contact_details')
            ->select(
                'contact_details.*',
                'cities.vname as city_name',
                'states.vname as state_name',
                'countries.vname as country_name',
                'pincodes.vname as pincode_name'
            )
            ->leftJoin('cities', 'cities.id', '=', 'contact_details.city_id')
            ->leftJoin('states', 'states.id', '=', 'contact_details.state_id')
            ->leftJoin('countries', 'countries.id', '=', 'contact_details.country_id')
            ->leftJoin('pincodes', 'pincodes.id', '=', 'contact_details.pincode_id')
            ->where('contact_id', $contactId)
            ->get();

        if ($addresses->isEmpty()) {
            $this->itemList = [$default];
            $this->secondaryAddress = [];
            return;
        }

        $primary = $addresses->firstWhere('address_type', 'Primary');

        $secondaries = $addresses->where('address_type', 'Secondary');

        // Reset itemList: primary at 0, others after
        $this->itemList = [];

        if ($primary) {
            $this->itemList[0] = (array)$primary;
        } else {
            // If no primary, use a default primary
            $this->itemList[0] = $default;
        }

        foreach ($secondaries as $i => $address) {
            $this->itemList[$i + 1] = (array)$address;
        }

        // Set the secondary indexes for tabs (1, 2, ...)
        $this->secondaryAddress = collect($this->itemList)
            ->keys()
            ->filter(fn($i) => $i !== 0)
            ->values()
            ->toArray();
    }


    protected function defaultAddress(): array
    {
        return [
            'address_type' => 'Primary',
            'address_1' => '-',
            'address_2' => '-',
            'city_id' => '1',
            'city_name' => '-',
            'state_id' => '1',
            'state_name' => '-',
            'pincode_id' => '1',
            'pincode_name' => '-',
            'country_id' => '1',
            'country_name' => '-',
        ];
    }

    #endregion

    public function saveItem($contactId): void
    {
        // Delete all previous addresses for this contact
        ContactAddress::on($this->getTenantConnection())
            ->where('contact_id', $contactId)
            ->delete();

        // If itemList is empty, add the default address as Primary
        if (empty($this->itemList) || !isset($this->itemList[0])) {
            ContactAddress::on($this->getTenantConnection())
                ->create($this->buildAddressPayload($contactId, (object)$this->defaultAddress()));
            return;
        }

        // Re-save all items as new
        foreach ($this->itemList as $address) {
            if (is_array($address)) {
                $address = (object)$address;
            }

            // Skip blank entries
            if (empty(trim($address->address_1 ?? '')) && empty(trim($address->address_2 ?? ''))) {
                continue;
            }

            ContactAddress::on($this->getTenantConnection())
                ->create($this->buildAddressPayload($contactId, $address));
        }
    }

    protected function buildAddressPayload($contactId, $data): array
    {
        return [
            'contact_id' => $contactId,
            'address_type' => $data->address_type ?? 'Primary',
            'address_1' => $data->address_1 ?? '-',
            'address_2' => $data->address_2 ?? '-',
            'city_id' => $data->city_id ?? 1,
            'state_id' => $data->state_id ?? 1,
            'pincode_id' => $data->pincode_id ?? 1,
            'country_id' => $data->country_id ?? 1,
        ];
    }

    protected function updateExistingAddress(object $data): void
    {
        $detail = ContactAddress::on($this->getTenantConnection())->find($data->contact_detail_id);
        if (!$detail) return;

        $connection = $this->getTenantConnection();

        $detail->update([
            'address_type' => $data->address_type ?? $detail->address_type,
            'address_1' => $data->address_1 ?? $detail->address_1,
            'address_2' => $data->address_2 ?? $detail->address_2,
            'city_id' => City::on($connection)->where('id', $data->city_id ?? 0)->exists() ? $data->city_id : $detail->city_id,
            'state_id' => State::on($connection)->where('id', $data->state_id ?? 0)->exists() ? $data->state_id : $detail->state_id,
            'pincode_id' => Pincode::on($connection)->where('id', $data->pincode_id ?? 0)->exists() ? $data->pincode_id : $detail->pincode_id,
            'country_id' => Country::on($connection)->where('id', $data->country_id ?? 0)->exists() ? $data->country_id : $detail->country_id,
        ]);
    }

    public function addAddress($currentIndex): void
    {
        // Ensure Primary exists
        if (!array_key_exists(0, $this->itemList)) {
            $this->itemList[0] = (object)array_merge($this->defaultAddress(), [
                'address_type' => 'Primary',
            ]);
        }

        // Find the next free index for secondary (starting from 1)
        $usedIndices = array_keys($this->itemList);
        $nextIndex = 1;
        while (in_array($nextIndex, $usedIndices)) {
            $nextIndex++;
        }

        $this->secondaryAddress[] = $nextIndex;

        $this->itemList[$nextIndex] = (object)array_merge($this->defaultAddress(), [
            'address_type' => 'Secondary',
        ]);

        $this->openTab = $nextIndex;
    }


    public function removeAddress($index, $value): void
    {
        unset($this->secondaryAddress[$index]);
        $this->secondaryAddress = array_values($this->secondaryAddress);

        unset($this->itemList[$value]);

        $this->openTab = 0;
    }


    public function removeItems($index): void
    {
        $item = $this->itemList[$index] ?? null;
        unset($this->itemList[$index]);

        if ($item && $item['contact_detail_id'] != 0) {
            ContactAddress::on($this->getTenantConnection())->find($item['contact_detail_id'])?->delete();
        }
    }

    public function sortSearch($tab): void
    {
        $this->openTab = $tab;
    }

    #endregion

    #region[Route]
    public function getRoute(): void
    {
        $this->redirect(route('contacts'));
    }

    public function render()
    {
//        $this->log = Logbook::where('model_name',$this->gstin)->get();

        $this->getCityList(0);
        $this->getStateList();
        $this->getPincodeList();
        $this->getCountryList();
        $this->getMsmeTypeList();
        $this->getContactTypeList();

        return view('master::contact-upsert');
    }
    #endregion
}
