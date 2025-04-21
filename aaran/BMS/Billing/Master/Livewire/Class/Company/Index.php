<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class\Company;

use Aaran\Assets\Enums\MsmeType;
use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Common\Models\City;
use Aaran\BMS\Billing\Common\Models\Country;
use Aaran\BMS\Billing\Common\Models\Pincode;
use Aaran\BMS\Billing\Common\Models\State;
use Aaran\BMS\Billing\Master\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;

    use ComponentStateTrait, TenantAwareTrait;

    #region[properties]
    public string $vname = '';
    public string $mobile = '';

    public string $email = '';
    public string $gstin = '';
    public mixed $msme_no = '';
    public string $address_1 = '';
    public string $address_2 = '';
    public string $display_name = '';
    public string $landline = '';
    public string $website = '';
    public string $inv_pfx = '';
    public string $iec_no = '';
    public $logo = '';
    public $old_logo = '';
    public string $pan = '';
    public $bank;
    public $acc_no;
    public $ifsc_code;
    public $branch;
    public $isUploaded = false;
    public $active_id = true;

    public string $cities;
    public string $states;
    public string $pincode;
    public $tenant_id;
    public $log;
    public Collection $tenants;
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
            'vname' => 'Company name',
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

    #region[city]
    public $city_id = '';
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
    public $state_id = '';
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
    public $country_id = '';
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

        Company::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'vname' => $this->vname,
                'display_name' => $this->display_name,
                'address_1' => $this->address_1,
                'address_2' => $this->address_2,
                'mobile' => $this->mobile,
                'landline' => $this->landline,
                'gstin' => Str::upper($this->gstin),
                'msme_no' => $this->msme_no ?: '-',
                'msme_type_id' => $this->msme_type_id ?: '1',
                'pan' => Str::upper($this->pan),
                'email' => $this->email,
                'website' => $this->website,
                'city_id' => $this->city_id ?: '1',
                'state_id' => $this->state_id ?: '1',
                'pincode_id' => $this->pincode_id ?: '1',
                'country_id' => $this->country_id ?: '1',
                'bank' => $this->bank,
                'acc_no' => $this->acc_no,
                'ifsc_code' => $this->ifsc_code,
                'branch' => $this->branch,
                'inv_pfx' => $this->inv_pfx ?: '-',
                'iec_no' => $this->iec_no ?: '-',
                'active_id' => $this->active_id,
                'logo' => 'logo'//$this->save_logo(),
            ],
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
        $this->active_id = true;
        $this->display_name = '';
        $this->address_1 = '';
        $this->address_2 = '';
        $this->mobile = '';
        $this->landline = '';
        $this->gstin = '';
        $this->msme_no = '';
        $this->msme_type_id = '';
        $this->msme_type_name = '';
        $this->pan = '';
        $this->email = '';
        $this->website = '';
        $this->city_id = '';
        $this->city_name = '';
        $this->state_id = '';
        $this->state_name = '';
        $this->pincode_id = '';
        $this->pincode_name = '';
        $this->country_id = '';
        $this->country_name = '';
        $this->iec_no = '';
        $this->inv_pfx = '';
        $this->bank = '';
        $this->acc_no = '';
        $this->ifsc_code = '';
        $this->branch = '';
        $this->logo = '';
        $this->old_logo = '';
    }
    #endregion

    #region[logo]
    public function save_logo()
    {
        if ($this->logo) {

            $image = $this->logo;
            $filename = $this->logo->getClientOriginalName();

            if (Storage::disk('public')->exists(Storage::path('public/images/' . $this->old_logo))) {
                Storage::disk('public')->delete(Storage::path('public/images/' . $this->old_logo));
            }

            $image->storeAs('public/images', $filename);

            return $filename;

        } else {
            if ($this->old_logo) {
                return $this->old_logo;
            } else {
                return 'no_image';
            }
        }
    }
    #endregion

    #region[obj]
    public function getObj($id)
    {
        if ($id) {
            $obj = Company::on($this->getTenantConnection())->find($id);
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->display_name = $obj->display_name;
            $this->address_1 = $obj->address_1;
            $this->address_2 = $obj->address_2;
            $this->mobile = $obj->mobile;
            $this->landline = $obj->landline;
            $this->gstin = $obj->gstin;
            $this->msme_no = $obj->msme_no;
            $this->msme_type_id = $obj->msme_type_id;
            $this->msme_type_name = MsmeType::tryFrom($obj->msme_type_id)->getName();
            $this->pan = $obj->pan;
            $this->email = $obj->email;
            $this->website = $obj->website;
            $this->city_id = $obj->city_id;
            $this->city_name = $obj->city->vname;
            $this->state_id = $obj->state_id;
            $this->state_name = $obj->state->vname;
            $this->pincode_id = $obj->pincode_id;
            $this->pincode_name = $obj->pincode->vname;
            $this->country_id = $obj->country_id;
            $this->country_name = $obj->country->vname;
            $this->bank = $obj->bank;
            $this->acc_no = $obj->acc_no;
            $this->ifsc_code = $obj->ifsc_code;
            $this->branch = $obj->branch;
            $this->inv_pfx = $obj->inv_pfx;
            $this->iec_no = $obj->iec_no;
            $this->active_id = $obj->active_id;
            $this->old_logo = $obj->logo;
            return $obj;
        }
        return null;
    }
    #endregion

    #region[route]
    public function getRoute(): void
    {
        $this->redirect(route('companies'));
    }
    #endregion

    #region[getList]
    public function getList()
    {
        return Company::on($this->getTenantConnection())
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
            $obj = Company::on($this->getTenantConnection())->find($id);
            if ($obj) {
                $obj->delete();
            }
        }
    }
    #endregion

    #region[render]
    public function render()
    {
        $this->getCityList();
        $this->getStateList();
        $this->getPincodeList();
        $this->getMsmeTypeList();
        $this->getCountryList();
//        $this->log = Logbook::where('vname', 'Company')->take(5)->get();

        return view('master::company.index')->with([
            'list' => $this->getList(),
        ]);
    }
    #endregion
}
