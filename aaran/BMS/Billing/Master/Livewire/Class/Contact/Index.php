<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class\Contact;

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
use Aaran\BMS\Billing\Master\Models\ContactBank;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Index extends Component
{

    use ComponentStateTrait, TenantAwareTrait;

    #region[properties]

    #[Validate]
    public string $vname = '';
    public string $mobile = '';
    public string $whatsapp = '';
    public string $contact_person = '';
    public mixed $contact_type_id = '';
    #[Validate]
    public string $gstin = '';
    public ?string $email = '';
    public ?string $msme_no = '';
    public string $msme_type_id = '';
    public mixed $opening_balance = 0;
    public mixed $outstanding = 0;
    public string $effective_from = '';
    public $active_id = true;

    public string $address_type = '';
    public string $address_1 = '';
    public string $address_2 = '';
    public string $city_id = '';
    public string $state_id = '';
    public string $pincode_id = '';
    public string $country_id = '';

    public $bank_type;
    public $acc_no;
    public $ifsc_code;
    public $bank;
    public $branch;

    #endregion

    #region[rules]
    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.companies,vname"),
            'gstin' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.companies,vname"),
            'address_1' => 'required',
            'address_2' => 'required',
            'city_name' => 'required',
            'state_name' => 'required',
            'pincode_name' => 'required',
            'country_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'vname.required' => ' :attribute is required.',
            'gstin.required' => ' :attribute is required.',
            'vname.unique' => ' :attribute is already taken.',
            'gstin.unique' => ' :attribute is already taken.',
            'address_1.required' => ' :attribute  is required.',
            'address_2.required' => ' :attribute  is required.',
            'city_name.required' => ' :attribute  is required.',
            'state_name.required' => ' :attribute  is required.',
            'pincode_name.required' => ' :attribute  is required.',
            'country_name.required' => ' :attribute  is required.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'vname' => 'Contact name',
            'gstin' => 'GST No',
            'address_1' => 'Address',
            'address_2' => 'Area Road',
            'city_name' => 'City',
            'state_name' => 'State',
            'pincode_name' => 'Pincode',
            'country_name' => 'Country',
        ];
    }
    #endregion

    #[On('refresh-city')]
    public function refreshCity($v): void
    {
        $this->city_id = $v;
    }



    #region[state]
    public $state_name = '';
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

    public function setState($name, $id): void
    {
        $this->state_name = $name;
        $this->state_id = $id;
        $this->getStateList();
    }

    public function enterState(): void
    {
        $obj = $this->stateCollection[$this->highlightState] ?? null;

        $this->state_name = '';
        $this->stateCollection = Collection::empty();
        $this->highlightState = 0;

        $this->state_name = $obj->vname ?? '';;
        $this->state_id = $obj->id ?? '';;
    }

    #[On('refresh-state')]
    public function refreshState($v): void
    {
        $this->state_id = $v['id'];
        $this->state_name = $v['name'];
        $this->stateTyped = false;

    }

    public function stateSave($name): void
    {
        $obj = State::on($this->getTenantConnection())->create([
            'vname' => $name,
            'state_code' => '1',
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
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

    #region[pin-code]
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

    public function enterPincode(): void
    {
        $obj = $this->pincodeCollection[$this->highlightPincode] ?? null;

        $this->pincode_name = '';
        $this->pincodeCollection = Collection::empty();
        $this->highlightPincode = 0;

        $this->pincode_name = $obj->vname ?? '';;
        $this->pincode_id = $obj->id ?? '';;
    }

    public function setPincode($name, $id): void
    {
        $this->pincode_name = $name;
        $this->pincode_id = $id;
        $this->getPincodeList();
    }

    #[On('refresh-pincode')]
    public function refreshPincode($v): void
    {
        $this->pincode_id = $v['id'];
        $this->pincode_name = $v['name'];
        $this->pincodeTyped = false;
    }

    public function pincodeSave($name)
    {
        $obj = Pincode::on($this->getTenantConnection())->create([
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
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

    #region[country]
    public $country_name = '';
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

    public function setCountry($name, $id): void
    {
        $this->country_name = $name;
        $this->country_id = $id;
        $this->getCountryList();
    }

    public function enterCountry(): void
    {
        $obj = $this->countryCollection[$this->highlightCountry] ?? null;

        $this->country_name = '';
        $this->countryCollection = Collection::empty();
        $this->highlightCountry = 0;

        $this->country_name = $obj->vname ?? '';
        $this->country_id = $obj->id ?? '';
    }

    #[On('refresh-country')]
    public function refreshCountry($v): void
    {
        $this->country_id = $v['id'];
        $this->country_name = $v['name'];
        $this->countryTyped = false;
    }

    public function countrySave($name)
    {
        $obj = Country::on($this->getTenantConnection())->create([
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
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
//        $msmeType = MsmeType::tryFrom((int) $id);
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

    #region[save]
    public function getSave(): void
    {
        $this->validate();

        $connection = $this->getTenantConnection();

        $contact = Contact::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'vname' => $this->vname,
                'mobile' => $this->mobile,
                'whatsapp' => $this->whatsapp,
                'contact_person' => $this->contact_person,
                'contact_type_id' => $this->contact_type_id,
                'gstin' => Str::upper($this->gstin),
                'email' => $this->email,
                'msme_no' => $this->msme_no ?: '-',
                'msme_type_id' => $this->msme_type_id ?: '1',
                'opening_balance' => $this->opening_balance ?: '0',
                'outstanding' => $this->outstanding ?: '0',
                'effective_from' => $this->effective_from,
                'active_id' => $this->active_id,
            ],
        );

        // Get the primary address detail (if exists)
        $existingPrimaryAddress = ContactAddress::on($connection)
            ->where('contact_id', $contact->id)
            ->where('address_type', 'primary')
            ->first();

        ContactAddress::on($connection)->updateOrCreate(
            [
                'id' => optional($existingPrimaryAddress)->id,
            ],
            [
                'contact_id' => $contact->id,
                'address_type' => 'primary',
                'address_1' => $this->address_1,
                'address_2' => $this->address_2,
                'city_id' => $this->city_id,
                'state_id' => $this->state_id,
                'pincode_id' => $this->pincode_id,
                'country_id' => $this->country_id,
            ]
        );


        // Get the primary Bank detail (if exists)
        $existingPrimaryBank = ContactBank::on($connection)
            ->where('contact_id', $contact->id)
            ->where('bank_type', 'primary')
            ->first();

        ContactBank::on($connection)->updateOrCreate(
            [
                'id' => optional($existingPrimaryBank)->id,
            ],
            [
                'contact_id' => $contact->id,
                'bank_type' => 'primary',
                'acc_no' => $this->acc_no,
                'ifsc_code' => $this->ifsc_code,
                'bank' => $this->bank,
                'branch' => $this->branch,
            ]
        );


        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();
    }

    #endregion

    #region[clear fields]
    public function clearFields()
    {
        $this->vid = null;
        $this->vname = '';
        $this->mobile = '';
        $this->whatsapp = '';
        $this->contact_person = '';
        $this->contact_type_id = '';
        $this->contact_type_name = '';
        $this->gstin = '';
        $this->email = '';
        $this->msme_no = '';
        $this->msme_type_id = '';
        $this->msme_type_name = '';
        $this->opening_balance = '';
        $this->outstanding = '';
        $this->effective_from = '';
        $this->active_id = true;

        $this->address_type = 'primary';
        $this->address_1 = '';
        $this->address_2 = '';
        $this->city_id = '';
        $this->state_id = '';
        $this->pincode_id = '';
        $this->country_id = '';

        $this->state_name = '';
        $this->pincode_name = '';
        $this->country_name = '';

        $this->acc_no = '';
        $this->ifsc_code = '';
        $this->bank = '';
        $this->branch = '';

        $this->dispatch('refresh-city-lookup', '');
    }
    #endregion

    #region[obj]
    public function getObj($id)
    {
        $connection = $this->getTenantConnection();

        if ($id) {
            $obj = Contact::on($connection)->find($id);

            if (!$obj) {
                return; // Or handle not found
            }

            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->mobile = $obj->mobile;
            $this->whatsapp = $obj->whatsapp;
            $this->contact_person = $obj->contact_person;
            $this->contact_type_id = $obj->contact_type_id;
            $this->contact_type_name = optional($obj->contact_type)->vname;
            $this->gstin = $obj->gstin;
            $this->email = $obj->email;
            $this->msme_no = $obj->msme_no;
            $this->msme_type_id = $obj->msme_type_id;
            $this->msme_type_name = MsmeType::tryFrom($obj->msme_type_id)?->getName();
            $this->opening_balance = $obj->opening_balance;
            $this->outstanding = $obj->outstanding;
            $this->effective_from = $obj->effective_from;
            $this->active_id = $obj->active_id;
        }

        $address = ContactAddress::on($connection)
            ->where('contact_id', $id)
            ->where('address_type', 'primary')
            ->first();

        if ($address) {
            $this->address_type = $address->address_type;
            $this->address_1 = $address->address_1;
            $this->address_2 = $address->address_2;
            $this->city_id = $address->city_id;

            $this->dispatch('refresh-city-lookup', optional($address->city)->vname);

            $this->state_id = $address->state_id;
            $this->state_name = optional($address->state)->vname;
            $this->pincode_id = $address->pincode_id;
            $this->pincode_name = optional($address->pincode)->vname;
            $this->country_id = $address->country_id;
            $this->country_name = optional($address->country)->vname;
        }

        $bank = ContactBank::on($connection)
            ->where('contact_id', $id)
            ->where('bank_type', 'primary')
            ->first();

        if ($bank) {
            $this->bank_type = $bank->bank_type;
            $this->acc_no = $bank->acc_no;
            $this->ifsc_code = $bank->ifsc_code;
            $this->bank = $bank->bank;
            $this->branch = $bank->branch;
        }
    }

    #endregion

    #region[route]
    public function getRoute(): void
    {
        $this->redirect(route('contacts'));
    }
    #endregion

    #region[getList]
    public function getList()
    {
        return Contact::on($this->getTenantConnection())
            ->active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }
    #endregion

    #region[delete]
    public function deleteFunction($id): void
    {
        if ($id) {
            $obj = Contact::on($this->getTenantConnection())->find($id);
            if ($obj) {
                $obj->delete();
                $message = "Deleted Successfully";
            }
        }
    }
    #endregion

    #region[render]
    public function render()
    {
//        $this->getCityList();
        $this->getStateList();
        $this->getPincodeList();
        $this->getMsmeTypeList();
        $this->getCountryList();
        $this->getContactTypeList();

        return view('master::contact.index')->with([
            'list' => $this->getList(),
        ]);
    }
    #endregion
}
