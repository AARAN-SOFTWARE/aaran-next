<?php

namespace Aaran\Master\Livewire\Class;

use Aaran\Assets\Enums\MsmeType;
use Aaran\Assets\Trait\CommonTraitNew;
use Aaran\BMS\Billing\Common\Models\City;
use Aaran\BMS\Billing\Common\Models\Country;
use Aaran\BMS\Billing\Common\Models\Pincode;
use Aaran\BMS\Billing\Common\Models\State;
use Aaran\Master\Models\Company;
use Aaran\Tenant\Models\Tenant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class CompanyList extends Component
{
    use WithFileUploads;

    use CommonTraitNew;

    #region[properties]
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
            'common.vname' => 'required|unique:companies,vname',
            'gstin' => 'unique:companies,gstin',
            'address_1' => 'required',
            'address_2' => 'required',
            'city_name' => 'required',
            'state_name' => 'required',
            'pincode_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'common.vname.required' => ' :attribute is required.',
            'gstin.required' => ' :attribute is required.',
            'vname.unique' => ' :attribute is already taken.',
            'gstin.unique' => ' :attribute is already taken.',
            'address_1.required' => ' :attribute  is required.',
            'address_2.required' => ' :attribute  is required.',
            'city_name.required' => ' :attribute  is required.',
            'state_name.required' => ' :attribute  is required.',
            'pincode_name.required' => ' :attribute  is required.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'common.vname' => 'Company name',
            'gstin' => 'GST No',
            'address_1' => 'Address',
            'address_2' => 'Area Road',
            'city_name' => 'City',
            'state_name' => 'State',
            'pincode_name' => 'Pincode',
        ];
    }
    #endregion

    #region[city]
    public $city_id = '';
    public $city_name = '';
    public Collection $cityCollection;
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

        $this->city_name = $obj['vname'] ?? '';;
        $this->city_id = $obj['id'] ?? '';;
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
        $obj = City::create([
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshCity($v);
    }

    public function getCityList(): void
    {
        $this->cityCollection = $this->city_name ?
            City::search(trim($this->city_name))->get() :
            City::all();
    }
    #endregion

    #region[state]
    public $state_id = '';
    public $state_name = '';
    public Collection $stateCollection;
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

        $this->state_name = $obj['vname'] ?? '';;
        $this->state_id = $obj['id'] ?? '';;
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
        $obj = State::create([
            'vname' => $name,
            'state_code' => '1',
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshState($v);
    }

    public function getStateList(): void
    {
        $this->stateCollection = $this->state_name ?
            State::search(trim($this->state_name))->get() :
            State::all();
    }
    #endregion

    #region[pin-code]
    public $pincode_id = '';
    public $pincode_name = '';
    public Collection $pincodeCollection;
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

        $this->pincode_name = $obj['vname'] ?? '';;
        $this->pincode_id = $obj['id'] ?? '';;
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
        $obj = Pincode::create([
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshPincode($v);
    }

    public function getPincodeList(): void
    {
        $this->pincodeCollection = $this->pincode_name ?
            Pincode::search(trim($this->pincode_name))->get() :
            Pincode::all();
    }
    #endregion

    #region[country]
    public $country_id = '';
    public $country_name = '';
    public Collection $countryCollection;
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

        $this->country_name = $obj['vname'] ?? '';
        $this->country_id = $obj['id'] ?? '';
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
        $obj = Country::create([
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshCountry($v);
    }

    public function getCountryList(): void
    {
        $this->countryCollection = $this->country_name ?
            Country::search(trim($this->country_name))->get() :
            Country::all();
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
        $this->msmeTypeCollection = collect(MsmeType::cases())->map(fn ($type) => [
            'id' => $type->value,
            'vname' => $type->getName(),
        ])->toArray();
    }

#endregion

    #region[save]
    public function getSave(): void
    {
        if ($this->common->vname != '') {
            if ($this->common->vid == '') {
                $this->validate($this->rules());
                $company = new Company();
                $extraFields = [
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
                    'user_id' => Auth::id(),
                    'tenant_id' => $this->tenant_id ?: '1',
                    'logo' => $this->save_logo(),
                ];
                $this->common->save($company, $extraFields);
                $message = "Saved";
            } else {
                $company = Company::find($this->common->vid);
                $extraFields = [
                    'display_name' => $this->display_name,
                    'address_1' => $this->address_1,
                    'address_2' => $this->address_2,
                    'mobile' => $this->mobile,
                    'landline' => $this->landline,
                    'gstin' => Str::upper($this->gstin),
                    'msme_no' => $this->msme_no,
                    'msme_type_id' => $this->msme_type_id,
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
                    'user_id' => Auth::id(),
                    'tenant_id' => $this->tenant_id ?: '1',
                    'logo' => $this->save_logo(),
                ];
                $this->common->edit($company, $extraFields);
                $message = "Updated";
            }
            $this->dispatch('notify', ...['type' => 'success', 'content' => $message . ' Successfully']);
        }
    }
    #endregion

    #region[clear fields]
    public function clearFields()
    {
        $this->common->vid = '';
        $this->common->vname = '';
        $this->common->active_id = '1';
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
            $obj = Company::find($id);
            $this->common->vid = $obj->id;
            $this->common->vname = $obj->vname;
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
            $this->city_name = $obj->city_id ? City::find($obj->city_id)->vname : '';
            $this->state_id = $obj->state_id;
            $this->state_name = $obj->state_id ? State::find($obj->state_id)->vname : '';
            $this->pincode_id = $obj->pincode_id;
            $this->pincode_name = $obj->pincode_id ? Pincode::find($obj->pincode_id)->vname : '';
            $this->country_id = $obj->country_id;
            $this->country_name = $obj->country_id ? Country::find($obj->country_id)->vname : '';
            $this->bank = $obj->bank;
            $this->acc_no = $obj->acc_no;
            $this->ifsc_code = $obj->ifsc_code;
            $this->branch = $obj->branch;
            $this->inv_pfx = $obj->inv_pfx;
            $this->iec_no = $obj->iec_no;
            $this->common->active_id = $obj->active_id;
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

    #region[tenants]
    public function getTenants(): void
    {
        $this->tenants = Tenant::all();

    }
    #endregion

    #region[delete]
    public function deleteFunction($id): void
    {
        if ($id) {
            $obj = Company::find($id);
            if ($obj) {
                $obj->delete();
                $message = "Deleted Successfully";
                $this->dispatch('notify', ...['type' => 'success', 'content' => $message]);
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
        $this->getTenants();
        $this->getMsmeTypeList();
        $this->getCountryList();
//        $this->log = Logbook::where('vname', 'Company')->take(5)->get();
        return view('master::Company.index')->with([
            'list' => $this->getListForm->getList(Company::class, function ($query) {
                return $query;
//                    ->where('tenant_id', session()->get('tenant_id'));
            }),
        ]);
    }
    #endregion
}
