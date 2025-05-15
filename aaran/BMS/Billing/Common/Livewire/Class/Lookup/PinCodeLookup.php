<?php

namespace Aaran\BMS\Billing\Common\Livewire\Class\Lookup;

use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Common\Models\Pincode;
use Aaran\BMS\Billing\Common\Models\State;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class PinCodeLookup extends Component
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
                ->table('pincodes')
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
            ->table('pincodes')
            ->select('id', 'vname')
            ->orderBy('vname');

        if (strlen(trim($this->search)) > 0) {
            $query->where('vname', 'like', '%' . $this->search . '%')->limit(10);
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
            $this->selectPinCode($selected);
        }
    }

    public function selectPinCode($pincode): void
    {
        $pincode = (object)$pincode;

        $this->search = $pincode->vname;
        $this->results = [];
        $this->showDropdown = false;
        $this->dispatch('refresh-pincode', $pincode->id);
    }

    public function hideDropdown(): void
    {
        $this->showDropdown = false;
    }

    public function createNew(): void
    {
        $pincode = Pincode::on($this->getTenantConnection())->create([
            'vname' => $this->search,
            'active_id' => 1
        ]);

        $this->dispatch('refresh-pincode', $pincode->id);
        $this->dispatch('notify', ...['type' => 'success', 'content' => $this->search. '- pincode Saved Successfully']);
        $this->showDropdown = false;
    }

    #[On('refresh-pincode-lookup')]
    public function refreshPinCode($pincode): void
    {
        if (!empty($pincode['vname'])) {
            $this->search = $pincode['vname'];
            $this->showCreateModal = false;
        } else {
            $this->search = '';
        }
    }

    public function render()
    {
        return view('common::lookup.pincode-lookup');
    }
}
