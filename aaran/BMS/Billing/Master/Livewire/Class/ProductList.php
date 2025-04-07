<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class;

use Aaran\Assets\Enums\ProductType;
use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Common\Models\GstPercent;
use Aaran\BMS\Billing\Common\Models\Hsncode;
use Aaran\BMS\Billing\Common\Models\Unit;
use Aaran\BMS\Billing\Master\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductList extends Component
{
    use WithFileUploads;

    use ComponentStateTrait, TenantAwareTrait;

    #region[Properties]
    public string $vname = '';
    public $quantity;
    public $price;
    public $active_id = true;
    public $log;
    #endregion

    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.products,vname"),
            'hsncode_name' => 'required',
            'unit_name' => 'required',
            'gstpercent_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'vname.required' => ' :attribute are missing.',
            'vname.unique' => ' :attribute is already created.',
            'hsncode_name.required' => ' :attribute is required.',
            'unit_name.required' => ' :attribute is required.',
            'gstpercent_name.required' => ' :attribute is required.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'vname' => 'Name',
            'hsncode_name' => 'Hsncode',
            'unit_name' => 'Unit',
            'gstpercent_name' => 'Gst percent',
        ];
    }

    #region[Get-Save]
    public function getSave(): void
    {
        $this->vname = preg_replace('/[^A-Za-z0-9\-]/', '', $this->vname);

        $this->validate();

        $connection = $this->getTenantConnection();

        Product::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
            'vname' => $this->vname,
            'producttype_id'  => $this->producttype_id ?: ProductType::GOODS,
            'hsncode_id'      => $this->hsncode_id ?: Hsncode::value('id'),
            'unit_id'         => $this->unit_id ?: Unit::value('id'),
            'gstpercent_id'   => $this->gstpercent_id ?: GstPercent::value('id'),
            'initial_quantity'=> $this->quantity ?: '0',
            'initial_price'   => $this->price ?: '0',
            'active_id' => $this->active_id,
//            'user_id'         => auth()->id(),
//            'company_id'      => session()->get('company_id') ?? 1, // Ensure default value
            ],
        );

        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();
    }
    #endregion

    #region[hsncode]
    public $hsncode_name = '';
    public $hsncode_id = '';
    public $hsncodeCollection;
    public $highlightHsncode = 0;
    public $hsncodeTyped = false;

    public function decrementHsncode(): void
    {
        if ($this->highlightHsncode === 0) {
            $this->highlightHsncode = count($this->hsncodeCollection) - 1;
            return;
        }
        $this->highlightHsncode--;
    }

    public function incrementHsncode(): void
    {
        if ($this->highlightHsncode === count($this->hsncodeCollection) - 1) {
            $this->highlightHsncode = 0;
            return;
        }
        $this->highlightHsncode++;
    }

    public function setHsncode($name, $id): void
    {
        $this->hsncode_name = $name;
        $this->hsncode_id = $id;
        $this->getHsncodeList();
    }

    public function enterHsncode(): void
    {
        $obj = $this->hsncodeCollection[$this->highlightHsncode] ?? null;

        $this->hsncode_name = '';
        $this->hsncodeCollection = Collection::empty();
        $this->highlightHsncode = 0;

        $this->hsncode_name = $obj['vname'] ?? '';
        $this->hsncode_id = $obj['id'] ?? '';
    }

    public function refreshHsncode($v): void
    {
        $this->hsncode_id = $v['id'];
        $this->hsncode_name = $v['name'];
        $this->hsncodeTyped = false;
    }

    public function hsncodeSave($name)
    {
        $obj = Hsncode::on($this->getTenantConnection())->create([
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshHsncode($v);
    }

    public function getHsncodeList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->hsncodeCollection = DB::connection($this->getTenantConnection())
            ->table('hsncodes')
            ->when($this->hsncode_name, fn($query) => $query->where('vname', 'like', "%{$this->hsncode_name}%"))
            ->get();
    }
#endregion

    #region[producttype]
    public $producttype_id = '';
    public $producttype_name = '';
    public $producttypeCollection;
    public $highlightProductType = 0;
    public $producttypeTyped = false;

    public function decrementProductType(): void
    {
        if ($this->highlightProductType === 0) {
            $this->highlightProductType = count($this->producttypeCollection) - 1;
            return;
        }
        $this->highlightProductType--;
    }

    public function incrementProductType(): void
    {
        if ($this->highlightProductType === count($this->producttypeCollection) - 1) {
            $this->highlightProductType = 0;
            return;
        }
        $this->highlightProductType++;
    }

    public function setProductType($name, $id): void
    {
        $this->producttype_name = $name;
        $this->producttype_id = $id;
        $this->getProductTypeList();
    }

    public function enterProductType(): void
    {
        $obj = $this->producttypeCollection[$this->highlightProductType] ?? null;

        $this->producttype_name = '';
        $this->producttypeCollection = Collection::empty();
        $this->highlightProductType = 0;

        $this->producttype_name = $obj['name'] ?? '';
        $this->producttype_id = $obj['id'] ?? '';
    }

    public function refreshProductType($v): void
    {
        $this->producttype_id = $v['id'];
        $this->producttype_name = $v['name'];
        $this->producttypeTyped = false;
    }

    public function getProductTypeList(): void
    {
        $this->producttypeCollection = collect(ProductType::getList());
    }
#endregion
#endregion

    #region[unit]
    public $unit_name = '';
    public $unit_id = '';
    public $unitCollection;
    public $highlightUnit = 0;
    public $unitTyped = false;

    public function decrementUnit(): void
    {
        if ($this->highlightUnit === 0) {
            $this->highlightUnit = count($this->unitCollection) - 1;
            return;
        }
        $this->highlightUnit--;
    }

    public function incrementUnit(): void
    {
        if ($this->highlightUnit === count($this->unitCollection) - 1) {
            $this->highlightUnit = 0;
            return;
        }
        $this->highlightUnit++;
    }

    public function setUnit($name, $id): void
    {
        $this->unit_name = $name;
        $this->unit_id = $id;
        $this->getUnitList();
    }

    public function enterUnit(): void
    {
        $obj = $this->unitCollection[$this->highlightUnit] ?? null;

        $this->unit_name = '';
        $this->unitCollection = Collection::empty();
        $this->highlightUnit = 0;

        $this->unit_name = $obj->vname ?? '';
        $this->unit_id = $obj->id ?? '';
    }
    #[On('refresh-unit')]
    public function refreshUnit($v): void
    {
        $this->unit_id = $v['id'];
        $this->unit_name = $v['vname'];
        $this->unitTyped = false;
    }

    public function unitSave($name)
    {
        $obj = Unit::on($this->getTenantConnection())->create([
            'vname' => $name,
            'active_id' => '1'
        ]);
        $v = ['vname' => $name, 'id' => $obj->id];
        $this->refreshUnit($v);
    }

    public function getUnitList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->unitCollection = DB::connection($this->getTenantConnection())
            ->table('units')
            ->when($this->unit_name, fn($query) => $query->where('vname', 'like', "%{$this->unit_name}%"))
            ->get();
    }
    #endregion

    #region[gstpercent]
    #[validate]
    public $gstpercent_name = '';
    public $gstpercent_id = '';
    public $gstpercentCollection;
    public $highlightGstPercent = 0;
    public $gstpercentTyped = false;

    public function decrementGstPercent(): void
    {
        if ($this->highlightGstPercent === 0) {
            $this->highlightGstPercent = count($this->gstpercentCollection) - 1;
            return;
        }
        $this->highlightGstPercent--;
    }

    public function incrementGstPercent(): void
    {
        if ($this->highlightGstPercent === count($this->gstpercentCollection) - 1) {
            $this->highlightGstPercent = 0;
            return;
        }
        $this->highlightGstPercent++;
    }

    public function setGstPercent($name, $id): void
    {
        $this->gstpercent_name = $name;
        $this->gstpercent_id = $id;
        $this->getGstPercentList();
    }

    public function enterGstPercent(): void
    {
        $obj = $this->gstpercentCollection[$this->highlightGstPercent] ?? null;

        $this->gstpercent_name = '';
        $this->gstpercentCollection = Collection::empty();
        $this->highlightGstPercent = 0;

        $this->gstpercent_name = $obj->vname ?? '';
        $this->gstpercent_id = $obj->id ?? '';
    }

    #[On('refresh-gst-percent')]
    public function refreshGstPercent($v): void
    {
        $this->gstpercent_id = $v['id'];
        $this->gstpercent_name = $v['name'];
        $this->gstpercentTyped = false;
    }

    public function gstPercentSave($name)
    {
        $obj = GstPercent::on($this->getTenantConnection())->create([
            'vname' => $name,
            'desc' => null,
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshGstPercent($v);
    }

    public function getGstpercentList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->gstpercentCollection = DB::connection($this->getTenantConnection())
            ->table('gst_percents')
            ->when($this->gstpercent_name, fn($query) => $query->where('vname', 'like', "%{$this->gstpercent_name}%"))
            ->get();
    }
#endregion

    #region[Get-Obj]
    public function getObj($id)
    {
        if ($id) {
            $obj = Product::on($this->getTenantConnection())->find($id);
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->active_id = $obj->active_id;
            $this->hsncode_id = $obj->hsncode_id;
            $this->hsncode_name = $obj->hsncode_id ? Hsncode::on($this->getTenantConnection())->find($obj->hsncode_id)->vname : '';
            $this->producttype_id = $obj->producttype_id;
            $this->producttype_name = $obj->producttype_id->name ?? 'Unknown';
            $this->unit_id = $obj->unit_id;
            $this->unit_name = $obj->unit_id ? Unit::on($this->getTenantConnection())->find($obj->unit_id)->vname : '';
            $this->gstpercent_id = $obj->gstpercent_id;
            $this->gstpercent_name = $obj->gstpercent_id ? GstPercent::on($this->getTenantConnection())->find($obj->gstpercent_id)->vname : '';
            $this->quantity = $obj->initial_quantity;
            $this->price = $obj->initial_price;
            return $obj;
        }
        return null;
    }
    #endregion

    #region[Clear-Fields]
    public function clearFields(): void
    {
        $this->vid = null;
        $this->vname = '';
        $this->active_id = true;
        $this->hsncode_id = '';
        $this->hsncode_name = '';
        $this->gstpercent_name = '';
        $this->gstpercent_id = '';
        $this->unit_name = '';
        $this->unit_id = '';
        $this->producttype_id = '';
        $this->producttype_name = '';
        $this->quantity = '';
        $this->price = '';
    }
    #endregion

    #region[Render]
    public function getRoute()
    {
        return route('products');
    }

    #region[getList]
    public function getList()
    {
        return Product::on($this->getTenantConnection())
            ->active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }
    #endregion

    #region[Delete]
    public function deleteFunction($id): void
    {
        if ($id) {
            $obj = Product::on($this->getTenantConnection())->find($id);
            if ($obj) {
                $obj->delete();
            }
        }
    }
    #endregion

    public function render()
    {
        $this->getHsncodeList();
        $this->getProductTypeList();
        $this->getUnitList();
        $this->getGstPercentList();
//        $this->log = Logbook::where('model_name','Product')->take(5)->get();
        return view('master::product-list')->with([
            'list' => $this->getList(),
        ]);
    }
    #endregion
}

