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
use Aaran\Master\Models\ContactDetail;
use Carbon\Carbon;
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

    #region[Contact properties]
    #[Validate]
    public $vname;

    public $active_id;

    public string $mobile = '';
    public string $whatsapp = '';
    public string $contact_person = '';
    public mixed $contact_type = '';
    public string $msme_no = '';
    public mixed $opening_balance = 0;
    public mixed $outstanding = 0;
    public string $effective_from = '';
    public mixed $route;
    #endregion

    #region[Address Properties]
    #[validate]
    public $gstin = '';
    public $email = '';
    public $address_type;
    public $log;
    #endregion

    #region[rules]
    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.contacts,vname"),
            'mobile' => 'required',
            'gstin' => 'unique:contacts,gstin',
            'itemList.0.address_1' => 'required',
            'itemList.0.address_2' => 'required',
            'itemList.0.city_name' => 'required',
            'itemList.0.state_name' => 'required',
            'itemList.0.pincode_name' => 'required',
            'itemList.0.country_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'vname.required' => ' :attribute is required.',
            'gstin.required' => ' :attribute is required.',
            'vname.unique' => ' :attribute is already taken.',
            'gstin.unique' => ' :attribute is already taken.',
            'itemList.0.address_1.required' => ' :attribute  is required.',
            'itemList.0.address_2.required' => ' :attribute  is required.',
            'itemList.0.city_name.required' => ' :attribute  is required.',
            'itemList.0.state_name.required' => ' :attribute  is required.',
            'itemList.0.pincode_name.required' => ' :attribute  is required.',
            'itemList.0.country_name' => ' :attribute  is required.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'vname' => 'contact name',
            'gstin' => 'GST No',
            'itemList.0.address_1' => 'Address',
            'itemList.0.address_2' => 'Area Road',
            'itemList.0.city_name' => 'City name',
            'itemList.0.state_name' => 'State name',
            'itemList.0.pincode_name' => 'Pincode name',
            'itemList.0.country_name' => 'Country name',
        ];
    }
    #endregion

    #region[array]
    #[validate]
    public $itemList = [];
    public mixed $itemIndex = '';
    public $secondaryAddress = [];
    public $addressIncrement = 0;
    public $openTab = 0;
    #endregion

    #region[addAddress]
    public function addAddress($id)
    {
        $this->addressIncrement = $id + 1;
        if (!in_array($this->addressIncrement, $this->secondaryAddress, true)) {
            $this->secondaryAddress[] = $this->addressIncrement;
        } elseif (!in_array(($this->addressIncrement + 1), $this->secondaryAddress, true)) {
            $this->secondaryAddress[] = $this->addressIncrement + 1;
        }


        $this->itemList[] = [
            'contact_detail_id' => 0,
            'address_type' => 'Secondary',
            "state_name" => "",
            "state_id" => "",
            "city_id" => "",
            "city_name" => "",
            "country_id" => "",
            "country_name" => "",
            "pincode_id" => "",
            "pincode_name" => "",
            "address_1" => "",
            "address_2" => "",
        ];
        $this->city_name = "";
        $this->state_name = "";
        $this->country_name = "";
        $this->pincode_name = "";
        $this->city_id = '';
        $this->state_id = '';
        $this->country_id = '';
        $this->pincode_id = '';
    }
    #endregion

    #region[removeAddress]
    public function removeAddress($id, $value): void
    {
        $this->openTab = 0;
        $this->addressIncrement = $value - 1;
        unset($this->secondaryAddress[$id]);
        $this->removeItems($value);
    }
    #endregion

    #region[sortSearch]
    public function sortSearch($id): void
    {
        $this->openTab = $id;
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

    public function setCity($vname, $id, $index=null): void
    {
        $this->city_name = $vname;
        $this->city_id = $id;
        Arr::set($this->itemList[$index], 'city_name', $vname);
        Arr::set($this->itemList[$index], 'city_id', $id);

        $this->getCityList();
    }

    public function enterCity($index): void
    {
        $obj = $this->cityCollection[$this->highlightCity] ?? null;

        $this->city_name = '';
        $this->cityCollection = Collection::empty();
        $this->highlightCity = 0;

        $this->city_name = $obj['vname'] ?? '';;
        $this->city_id = $obj['id'] ?? '';
        Arr::set($this->itemList[$index], 'city_name', $obj['vname']);
        Arr::set($this->itemList[$index], 'city_id', $obj['id']);

    }

    #[On('refresh-city')]
    public function refreshCity($v, $index): void
    {
        $this->city_id = $v['id'];
        $this->city_name = $v['vname'];

        Arr::set($this->itemList[$index], 'city_name', $v['vname']);
        Arr::set($this->itemList[$index], 'city_id', $v['id']);

        $this->cityTyped = false;
    }


    public function citySave($vname, $index)
    {
        $obj = City::on($this->getTenantConnection())->create([
            'vname' => $vname,
            'active_id' => '1'
        ]);
        $v = ['vname' => $vname, 'id' => $obj->id];
        $this->refreshCity($v, $index);
    }

    public function getCityList(): void
    {
//        $searchTerm = trim($this->itemList[$this->openTab]['city_name'] ?? '');
//
//        $this->cityCollection = $searchTerm
//            ? City::where('vname', 'like', "%{$searchTerm}%")->get()
//            : City::all();

        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->cityCollection = DB::connection($this->getTenantConnection())
            ->table('cities')
            ->when($this->city_name, fn($query) => $query->where('vname', 'like', "%{$this->city_name}%"))
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
        $v = ['vname' => $vname, 'id' => $obj->id,'index' => $index];
        $this->refreshState($v);
    }


    public function getStateList(): void
    {
//        $searchTerm = trim($this->itemList[$this->openTab]['state_name'] ?? '');
//
//        $this->stateCollection = $searchTerm
//            ? State::where('vname', 'like', "%{$searchTerm}%")->get()
//            : State::all();

        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->stateCollection = DB::connection($this->getTenantConnection())
            ->table('states')
            ->when($this->state_name, fn($query) => $query->where('vname', 'like', "%{$this->state_name}%"))
            ->get();

    }


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
        $v = ['vname' => $vname, 'id' => $obj->id,'index' => $index];
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

        $this->country_name = $obj['vname'] ?? '';;
        $this->country_id = $obj['id'] ?? '';;
        Arr::set($this->itemList[$index], 'country_name', $obj['vname']);
        Arr::set($this->itemList[$index], 'country_id', $obj['id']);
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
        $v = ['vname' => $vname, 'id' => $obj->id,'index' => $index];
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
    public $contact_type_id = '';
    public $contact_type_name = '';
    public Collection $contactTypeCollection;
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

        $this->contact_type_name = $obj['vname'] ?? '';
        $this->contact_type_id = $obj['id'] ?? '';
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
        $this->contactTypeCollection = !empty($this->contact_type_name)
            ? ContactType::search(trim($this->contact_type_name))->get()
            : ContactType::all();
    }

#endregion

    #region[MSME Type]
    public $msme_type_id = '';
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
        $id = (int) $id; // Convert to integer before passing it
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
        $this->msmeTypeCollection = collect(MsmeType::cases())->map(fn ($type) => [
            'id' => $type->value,
            'vname' => $type->getName(),
        ])->toArray();
    }

#endregion

    #region[Save]
    public function save(): void
    {
        $this->validate($this->rules());
//        $company_id = Company::value('id');

        if (!empty($this->vname)) {
            if (empty($this->vid)) {
                $contactTypeId = !empty($this->contact_type_id) ? $this->contact_type_id : ContactType::value('id') ?? 124;

                // Creating new contact
                $obj = Contact::create([
                    'vname' => Str::upper($this->vname),
                    'mobile' => $this->mobile ?? null,
                    'whatsapp' => $this->whatsapp ?? null,
                    'contact_person' => $this->contact_person ?? null,
                    'contact_type_id' => $contactTypeId,
                    'msme_no' => $this->msme_no ?: '-',
                    'msme_type_id' => $this->msme_type_id ?: '1',
                    'opening_balance' => $this->opening_balance ?? 0,
                    'outstanding' => $this->outstanding ?? 0,
                    'effective_from' => $this->effective_from ?? null,
                    'gstin' => Str::upper($this->gstin),
                    'email' => $this->email ?? null,
                    'active_id' => $this->active_id ?? 1,
                    'user_id' => auth()->id(),
//                    'company_id' => $company_id,
                ]);
                $this->saveItem($obj->id);
//                $this->common->logEntry('Contact name: '.$this->common->vname,$this->gstin,'create',$this->vname.'has been created');
                $message = "Saved";
                $this->getRoute();

            } else {
                // Updating existing contact
                $obj = Contact::findOrFail($this->vid);
                $obj->update([
                    'vname' => Str::upper($this->vname),
                    'mobile' => $this->mobile,
                    'whatsapp' => $this->whatsapp,
                    'contact_person' => $this->contact_person,
                    'contact_type_id' => $this->contact_type_id ?: 124,
                    'msme_no' => $this->msme_no,
                    'msme_type_id' => $this->msme_type_id ?: 1,
                    'opening_balance' => $this->opening_balance ?: 0,
                    'outstanding' => $this->outstanding ?: 0,
                    'effective_from' => $this->effective_from,
                    'gstin' => $this->gstin,
                    'email' => $this->email,
                    'active_id' => $this->active_id,
                    'user_id' => auth()->id(),
//                    'company_id' => $company_id,
                ]);
                $this->saveItem($obj->id);
//                $this->common->logEntry('Contact name: '.$this->common->vname,'Contact','update',$this->vname.' has been updated');
                $message = "Updated";
                $this->getRoute();

            }

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

            $this->dispatch('notify', ...['type' => 'success', 'content' => $message . ' Successfully']);

        }
    }
    #endregion

    #region[SaveItem]
    public function saveItem($id): void
    {
        if ($this->itemList != null) {
            foreach ($this->itemList as $sub) {
                if (!isset($sub['address_1']) || trim($sub['address_1']) === "") {
                    continue; // Skip empty addresses
                }

                if (!isset($sub['contact_detail_id']) || $sub['contact_detail_id'] === 0) {
                    // Create a new ContactDetail entry
                    ContactDetail::create([
                        'contact_id' => $id,
                        'address_type' => $sub['address_type'] ?? 'Primary',
                        'address_1' => $sub['address_1'] ?? '-',
                        'address_2' => $sub['address_2'] ?? '-',
                        'city_id' => $sub['city_id'] ?? 1,
                        'state_id' => $sub['state_id'] ?? 1,
                        'pincode_id' => $sub['pincode_id'] ?? 1,
                        'country_id' => $sub['country_id'] ?? 1,
                    ]);

                } else {
                    // Update an existing ContactDetail entry
                    $detail = ContactDetail::find($sub['contact_detail_id']);

                    if ($detail) {
                        $detail->address_type = $sub['address_type'] ?? $detail->address_type;
                        $detail->address_1    = $sub['address_1'] ?? $detail->address_1;
                        $detail->address_2    = $sub['address_2'] ?? $detail->address_2;
                        $detail->city_id      = City::where('id', $sub['city_id'] ?? 0)->exists() ? $sub['city_id'] : $detail->city_id;
                        $detail->state_id     = State::where('id', $sub['state_id'] ?? 0)->exists() ? $sub['state_id'] : $detail->state_id;
                        $detail->pincode_id   = Pincode::where('id', $sub['pincode_id'] ?? 0)->exists() ? $sub['pincode_id'] : $detail->pincode_id;
                        $detail->country_id   = Country::where('id', $sub['country_id'] ?? 0)->exists() ? $sub['country_id'] : $detail->country_id;

                        $detail->save();
                    }
                }
            }
        } else {
            // Create a default entry if no itemList is provided
            ContactDetail::create([
                'contact_id'   => $id,
                'address_type' => 'Primary',
                'address_1'    => '-',
                'address_2'    => '-',
                'city_id'      => 1,
                'state_id'     => 1,
                'pincode_id'   => 1,
                'country_id'   => 1,
            ]);
        }
    }
    #endregion


    #region[Mount]
    public function mount($id): void
    {
        $this->route = url()->previous();

        if ($id != 0) {
            $obj = Contact::find($id);

            if (!$obj) {
                abort(404, 'Contact not found.');
            }

            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->mobile = $obj->mobile;
            $this->whatsapp = $obj->whatsapp;
            $this->contact_person = $obj->contact_person;
            $this->contact_type_id = $obj->contact_type_id;
            $this->contact_type_name = optional(ContactType::find($obj->contact_type_id))->vname ?? '-';
            $this->msme_no = $obj->msme_no;
            $this->msme_type_id = $obj->msme_type_id;
            $this->msme_type_name = optional(ContactType::find($obj->msme_type_id))->vname ?? '-';
            $this->opening_balance = $obj->opening_balance;
            $this->outstanding = $obj->outstanding;
            $this->effective_from = $obj->effective_from;
            $this->gstin = $obj->gstin;
            $this->email = $obj->email;
            $this->active_id = $obj->active_id;

            // Fetching contact details with correct table joins
            $data = DB::table('contact_details')
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
                ->where('contact_id', '=', $id)
                ->get()
                ->map(function ($data) {
                    return [
                        'contact_detail_id' => $data->id,
                        'address_type' => $data->address_type ?? 'Primary',
                        'city_name' => $data->city_name ?? '-',
                        'city_id' => $data->city_id ?? '1',
                        'state_name' => $data->state_name ?? '-',
                        'state_id' => $data->state_id ?? '1',
                        'pincode_name' => $data->pincode_name ?? '-',
                        'pincode_id' => $data->pincode_id ?? '1',
                        'country_name' => $data->country_name ?? '-',
                        'country_id' => $data->country_id ?? '1',
                        'address_1' => $data->address_1 ?? '-',
                        'address_2' => $data->address_2 ?? '-',
                    ];
                });

            $this->itemList = $data->toArray();
            for ($j = 0; $j < $data->skip(1)->count(); $j++) {
                $this->secondaryAddress[] = $j + 1;
            }
        } else {
            $this->effective_from = Carbon::now()->format('Y-m-d');
            $this->active_id = true;
            $this->itemList = [[
                "contact_detail_id" => 0,
                'address_type' => "Primary",
                "state_name" => "-",
                "state_id" => "1",
                "city_id" => "1",
                "city_name" => "-",
                "country_id" => "1",
                "country_name" => "-",
                "pincode_id" => "1",
                "pincode_name" => "-",
                "address_1" => "-",
                "address_2" => "-",
            ]];
            $this->address_type = "Primary";
        }
    }
    #endregion

    #region[removeItems]
    public function removeItems($index): void
    {
        $items = $this->itemList[$index];
        unset($this->itemList[$index]);
        if ($items['contact_detail_id'] != 0) {
            $obj = ContactDetail::find($items['contact_detail_id']);
            $obj->delete();
        }
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
        $this->getCityList();
        $this->getStateList();
        $this->getPincodeList();
        $this->getCountryList();
        $this->getMsmeTypeList();
        $this->getContactTypeList();
        return view('master::Contact.upsert');
    }
    #endregion
}
