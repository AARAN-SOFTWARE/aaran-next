<?php

namespace Aaran\BMS\Billing\Entries\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Entries\Livewire\Forms\SalesForm;
use Aaran\BMS\Billing\Entries\Livewire\Forms\SalesItemForm;
use Livewire\Attributes\On;
use Livewire\Component;

class SalesUpsert extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    public SalesForm $sale;
    public SalesItemForm $saleItem;

    public $itemList;
    public $grandTotalBeforeRound;


    #[On('refresh-contact')]
    public function refreshContact($id): void
    {
        $this->sale->contact_id = $id;
    }

    public function getSave()
    {
        dd($this->sale->contact_id);
    }

    public function mount()
    {
        $this->sale->contact_id = 3;
    }


    public function render()
    {
        return view('entries::sales-upsert');
    }
}
