<?php

namespace Aaran\BMS\Billing\Books\Livewire\Class\Lookup;

use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Books\Models\Ledger;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class LedgerLookup extends Component
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
                ->table('ledgers')
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
            ->table('ledgers')
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
            $this->selectLedger($selected);
        }
    }

    public function selectLedger($ledger): void
    {
        $ledger = (object)$ledger;

        $this->search = $ledger->vname;
        $this->results = [];
        $this->showDropdown = false;
        $this->dispatch('refresh-ledger', $ledger);
    }

    public function hideDropdown(): void
    {
        $this->showDropdown = false;
    }

    public function createNew(): void
    {
        $ledger = Ledger::on($this->getTenantConnection())->create([
            'vname' => $this->search,
            'ledger_group_id' => '1',
            'active_id' => 1
        ]);
        $this->dispatch('refresh-ledger', $ledger);
        $this->dispatch('notify', ...['type' => 'success', 'content' => $this->search. '- Ledger Saved Successfully']);
        $this->showDropdown = false;
    }

    #[On('refresh-ledger-lookup')]
    public function refreshLedger($ledger): void
    {
        if (!empty($ledger['vname'])) {
            $this->search = $ledger['vname'];
            $this->showCreateModal = false;
        } else {
            $this->search = '';
        }
    }

    public function render()
    {
        return view('books::lookup.ledger-lookup');
    }
}
