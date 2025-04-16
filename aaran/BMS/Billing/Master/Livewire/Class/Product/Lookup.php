<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class\Product;

use Aaran\Assets\Traits\TenantAwareTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Lookup extends Component
{
    use TenantAwareTrait;

    public $search = '';
    public $results = [];
    public $highlightIndex = 0;
    public $showDropdown = false;
    public $showCreateModal = false;

    public $initId;

    public function mount($initId = null): void
    {
        $this->initId = $initId;

        if ($initId && $this->getTenantConnection()) {

            $vname = DB::connection($this->getTenantConnection())
                ->table('products')
                ->where('id', $initId)
                ->value('vname');

            if ($vname) {
                $this->search = $vname;
            }
        } else {
            $this->search = '';
        }
    }


    public function updatedSearch(): void
    {
        $this->searchBy();
    }

    public function searchBy(): void
    {
        if (!$this->getTenantConnection()) {
            return;
        }

        $query = DB::connection($this->getTenantConnection())
            ->table('products')
            ->select(
                'products.id',
                'products.vname',
                'gst_percents.vname as gst_percent'
            )
            ->leftJoin('gst_percents', 'products.gst_percent_id', '=', 'gst_percents.id')
            ->orderBy('products.vname');


        if (strlen(trim($this->search)) > 0) {
            $query->where('products.vname', 'like', '%' . $this->search . '%')->limit(10);
        }
        $results = $query->get();

        $this->results = $results;
        $this->highlightIndex = 0;
        $this->showDropdown = true;
    }

    public function incrementHighlight(): void
    {
        if ($this->highlightIndex < count($this->results) - 1) {
            $this->highlightIndex++;
        }
    }

    public function decrementHighlight(): void
    {
        if ($this->highlightIndex > 0) {
            $this->highlightIndex--;
        }
    }

    public function selectHighlighted(): void
    {
        $selected = $this->results[$this->highlightIndex] ?? null;
        if ($selected) {
            $this->selectProduct($selected);
        }
    }

    public function selectProduct($product): void
    {
        $product = (object)$product;

        $this->search = $product->vname;
        $this->results = [];
        $this->showDropdown = false;

        $this->dispatch('refresh-product', $product);
    }

    public function hideDropdown(): void
    {
        $this->showDropdown = false;
    }

    public function openCreateModal(): void
    {
        $this->dispatch('open-create-product-modal', name: $this->search);
    }

    #[On('refresh-product-lookup')]
    public function refreshProductLookup($v): void
    {
        $this->search = $v;
    }

    public function render()
    {
        return view('master::product.lookup');
    }
}
