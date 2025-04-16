<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class\Product;

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

class Modal extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    public bool $showCreateModal = false;

    #region[Properties]
    public string $vname = '';
    public $quantity;
    public $price;
    public $active_id = true;

    #endregion

    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.products,vname"),
//            'hsncode_name' => 'required',
//            'unit_name' => 'required',
            'gst_percent_name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'vname.required' => ' :attribute are missing.',
            'vname.unique' => ' :attribute is already created.',
//            'hsncode_name.required' => ' :attribute is required.',
//            'unit_name.required' => ' :attribute is required.',
            'gst_percent_name.required' => ' :attribute is required.',
        ];
    }

    public function validationAttributes()
    {
        return [
            'vname' => 'Name',
//            'hsncode_name' => 'Hsncode',
//            'unit_name' => 'Unit',
            'gst_percent_name' => 'Gst percent',
        ];
    }

    #region[Get-Save]
    public function getSave(): void
    {
//        $this->vname = preg_replace('/[^A-Za-z0-9\-]/', '', $this->vname);

        $this->validate();

        $connection = $this->getTenantConnection();

        $product = Product::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'vname' => $this->vname,
                'product_type_id' => $this->product_type_id ?: ProductType::GOODS,
                'hsncode_id' => $this->hsncode_id ?: '1',
                'unit_id' => $this->unit_id ?: '1',
                'gst_percent_id' => $this->gst_percent_id ?: '1',
                'initial_quantity' => $this->quantity ?: '0',
                'initial_price' => $this->price ?: '0',
                'active_id' => $this->active_id,
            ],
        );
        $this->dispatch('refresh-product-from-model',$product);
        $this->dispatch('refresh-product-lookup',$product->vname);
        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->closeModal();
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

    #region[product Type]
    public $product_type_id = '';
    public $product_type_name = '';
    public $productTypeCollection;
    public $highlightProductType = 0;
    public $productTypeTyped = false;

    public function decrementProductType(): void
    {
        if ($this->highlightProductType === 0) {
            $this->highlightProductType = count($this->productTypeCollection) - 1;
            return;
        }
        $this->highlightProductType--;
    }

    public function incrementProductType(): void
    {
        if ($this->highlightProductType === count($this->productTypeCollection) - 1) {
            $this->highlightProductType = 0;
            return;
        }
        $this->highlightProductType++;
    }

    public function setProductType($name, $id): void
    {
        $this->product_type_name = $name;
        $this->product_type_id = $id;
        $this->getProductTypeList();
    }

    public function enterProductType(): void
    {
        $obj = $this->productTypeCollection[$this->highlightProductType] ?? null;

        $this->product_type_name = '';
        $this->productTypeCollection = Collection::empty();
        $this->highlightProductType = 0;

        $this->product_type_name = $obj['name'] ?? '';
        $this->product_type_id = $obj['id'] ?? '';
    }

    public function refreshProductType($v): void
    {
        $this->product_type_id = $v['id'];
        $this->product_type_name = $v['name'];
        $this->productTypeTyped = false;
    }

    public function getProductTypeList(): void
    {
        $this->productTypeCollection = collect(ProductType::getList());
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

    #region[gst percent]
    #[validate]
    public $gst_percent_name = '';
    public $gst_percent_id = '';
    public $gstPercentCollection;
    public $highlightGstPercent = 0;
    public $gstPercentTyped = false;

    public function decrementGstPercent(): void
    {
        if ($this->highlightGstPercent === 0) {
            $this->highlightGstPercent = count($this->gstPercentCollection) - 1;
            return;
        }
        $this->highlightGstPercent--;
    }

    public function incrementGstPercent(): void
    {
        if ($this->highlightGstPercent === count($this->gstPercentCollection) - 1) {
            $this->highlightGstPercent = 0;
            return;
        }
        $this->highlightGstPercent++;
    }

    public function setGstPercent($name, $id): void
    {
        $this->gst_percent_name = $name;
        $this->gst_percent_id = $id;
        $this->getGstPercentList();
    }

    public function enterGstPercent(): void
    {
        $obj = $this->gstPercentCollection[$this->highlightGstPercent] ?? null;

        $this->gst_percent_name = '';
        $this->gstPercentCollection = Collection::empty();
        $this->highlightGstPercent = 0;

        $this->gst_percent_name = $obj->vname ?? '';
        $this->gst_percent_id = $obj->id ?? '';
    }

    #[On('refresh-gst-percent')]
    public function refreshGstPercent($v): void
    {
        $this->gst_percent_id = $v['id'];
        $this->gst_percent_name = $v['name'];
        $this->gstPercentTyped = false;
    }

    public function gstPercentSave($name): void
    {
        $obj = GstPercent::on($this->getTenantConnection())->create([
            'vname' => $name,
            'description' => '',
            'active_id' => '1'
        ]);
        $v = ['name' => $name, 'id' => $obj->id];
        $this->refreshGstPercent($v);
    }

    public function getGstPercentList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->gstPercentCollection = DB::connection($this->getTenantConnection())
            ->table('gst_percents')
            ->when($this->gst_percent_name, fn($query) => $query->where('vname', 'like', "%{$this->gst_percent_name}%"))
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
            $this->hsncode_id = $obj->hsncode_id;
            $this->hsncode_name = $obj->hsncode->vname;
            $this->product_type_id = $obj->product_type_id;
            $this->product_type_name = $obj->product_type_id ? ProductType::tryFrom($obj->product_type_id)->getName() : '';
            $this->unit_id = $obj->unit_id;
            $this->unit_name = $obj->unit->vname;
            $this->gst_percent_id = $obj->gst_percent_id;
            $this->gst_percent_name = $obj->gstPercent->vname;
            $this->quantity = $obj->initial_quantity;
            $this->price = $obj->initial_price;
            $this->active_id = $obj->active_id;
            return $obj;
        }
        return null;
    }
    #endregion

    #region[Clear-Fields]

    public function closeModal(): void{
        $this->showCreateModal = false;
        $this->clearFields();
    }

    public function clearFields(): void
    {
        $this->vid = null;
        $this->vname = '';
        $this->active_id = true;
        $this->hsncode_id = '';
        $this->hsncode_name = '';
        $this->gst_percent_name = '';
        $this->gst_percent_id = '';
        $this->unit_name = '';
        $this->unit_id = '';
        $this->product_type_id = '';
        $this->product_type_name = '';
        $this->quantity = '';
        $this->price = '';
    }
    #endregion

    #region[Render]
    protected $listeners = ['open-create-product-modal' => 'setInitialName'];

    public function setInitialName($name): void
    {
        $this->vname = $name;
        $this->showCreateModal = true;
    }

    public function render()
    {
        $this->getHsncodeList();
        $this->getProductTypeList();
        $this->getUnitList();
        $this->getGstPercentList();

        return view('master::product.modal');
    }
    #endregion
}
