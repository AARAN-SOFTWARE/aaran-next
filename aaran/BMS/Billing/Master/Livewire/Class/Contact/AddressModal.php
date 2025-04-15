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

class AddressModal extends Component
{

    use ComponentStateTrait, TenantAwareTrait;

    #region[properties]
    public bool $showModal = false;

    public string $contact_id = '';
    public string $address_type = '';
    public string $address_1 = '';
    public string $address_2 = '';
    public string $city_id = '';
    public string $state_id = '';
    public string $pincode_id = '';
    public string $country_id = '';

    #endregion

    #region[rules]
    public function rules(): array
    {
        return [
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
            'address_1' => 'Address',
            'address_2' => 'Area Road',
            'city_name' => 'City',
            'state_name' => 'State',
            'pincode_name' => 'Pincode',
            'country_name' => 'Country',
        ];
    }
    #endregion

    #region[city]
    public $city_name = '';
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

    public function setCity($name, $id): void
    {
        $this->city_name = $name;
        $this->city_id = $id;
        $this->getCityList();
    }

    public function enterCity(): void
    {
        $obj = $this->cityCollection[$this->highlightCity] ?? null;

        $this->city_name = '';
        $this->cityCollection = Collection::empty();
        $this->highlightCity = 0;

        $this->city_name = $obj->vname ?? '';;
        $this->city_id = $obj->id ?? '';;
    }

    #[On('refresh-city')]
    public function refreshCity($v): void
    {
        $this->city_id = $v['id'];
        $this->city_name = $v['name'];
        $this->cityTyped = false;
    }

    public function citySave($name)
    {
        $obj = City::on($this->getTenantConnection())->create([
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshCity($v);
    }

    public function getCityList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->cityCollection = DB::connection($this->getTenantConnection())
            ->table('cities')
            ->when($this->city_name, fn($query) => $query->where('vname', 'like', "%{$this->city_name}%"))
            ->get();
    }
    #endregion

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

    #region[save]
    public function getSave(): void
    {
        $this->validate();

        $connection = $this->getTenantConnection();

        $contact_address = ContactAddress::on($connection)->updateOrCreate(
            [
                'contact_id' => $this->contact_id,
                'address_type' => 'Secondary',
                'address_1' => $this->address_1,
                'address_2' => $this->address_2,
                'city_id' => $this->city_id,
                'state_id' => $this->state_id,
                'pincode_id' => $this->pincode_id,
                'country_id' => $this->country_id,
            ]
        );

        $this->dispatch('refresh-address-model',$contact_address);
        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->closeModal();
    }

    #endregion

    #region[clear fields]

    public function closeModal(): void{
        $this->showModal = false;
        $this->clearFields();
    }

    public function clearFields()
    {
        $this->address_type = 'primary';
        $this->address_1 = '';
        $this->address_2 = '';
        $this->city_id = '';
        $this->state_id = '';
        $this->pincode_id = '';
        $this->country_id = '';

        $this->city_name =  '';
        $this->state_name = '';
        $this->pincode_name = '';
        $this->country_name = '';

    }
    #endregion

    protected $listeners = ['open-create-address-modal' => 'setInitialName'];

    public function setInitialName($name): void
    {
        $this->contact_id = $name;
    }

    #region[render]
    public function render()
    {
        $this->getCityList();
        $this->getStateList();
        $this->getPincodeList();
        $this->getCountryList();

        return view('master::contact.address-modal');
    }
    #endregion
}
