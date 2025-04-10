<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class\Product;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Lookup extends Component
{

    use ComponentStateTrait, TenantAwareTrait;

    public bool $showModal = false;
    public $product_name = '';

    public $product_id = '';
    public $productCollection;
    public $highlightProduct = 0;
    public $productTyped = false;

    public function decrementProduct(): void
    {
        if ($this->highlightProduct === 0) {
            $this->highlightProduct = count($this->productCollection) - 1;
            return;
        }
        $this->highlightProduct--;
    }

    public function incrementProduct(): void
    {
        if ($this->highlightProduct === count($this->productCollection) - 1) {
            $this->highlightProduct = 0;
            return;
        }
        $this->highlightProduct++;
    }

    public function setProduct($name, $id): void
    {
        $this->product_name = $name;
        $this->product_id = $id;
        $this->getProductList();
    }

    public function enterProduct(): void
    {
        $obj = $this->productCollection[$this->highlightProduct] ?? null;

        $this->product_name = '';
        $this->productCollection = Collection::empty();
        $this->highlightProduct = 0;

        $this->product_name = $obj->vname ?? '';
        $this->product_id = $obj->id ?? '';
    }

    #[On('refresh-product')]
    public function refreshProduct($v): void
    {
        $this->product_id = $v['id'];
        $this->product_name = $v['vname'];
        $this->productTyped = false;
    }

    public function getProductList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->productCollection = DB::connection($this->getTenantConnection())
            ->table('products')
            ->when(trim($this->product_name), fn($query) => $query->where('vname', 'like', '%' . trim($this->product_name) . '%'))
            ->get();
    }

    public function render()
    {
        $this->getProductList();

        return view('master::product.lookup');
    }
}
