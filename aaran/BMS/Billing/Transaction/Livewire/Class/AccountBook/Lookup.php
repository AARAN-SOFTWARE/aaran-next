<?php

namespace Aaran\BMS\Billing\Transaction\Livewire\Class\AccountBook;

use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Transaction\Models\AccountBook;
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
                ->table('account_books')
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
            ->table('account_books')
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
            $this->selectObj($selected);
        }
    }

    public function selectObj($obj): void
    {
        $obj = (object)$obj;

        $this->search = $obj->vname;
        $this->results = [];
        $this->showDropdown = false;
        $this->dispatch('refresh-account-book', $obj->id);
    }

    public function hideDropdown(): void
    {
        $this->showDropdown = false;
    }

    public function createNew(): void
    {
        $obj = AccountBook::on($this->getTenantConnection())->create([
            'transaction_type_id'=> 1,
            'vname' => $this->search,
            'account_no' => '',
            'ifsc_code' => '',
            'bank_id' => 1,
            'account_type_id' => 1,
            'branch' => '',
            'opening_balance' => 0,
            'opening_balance_date' => now(),
            'current_balance' => 0,
            'current_balance_date' => now(),
            'current_entry_id' => 0,
            'notes' => '',
            'company_id' => session('company_id'),
            'active_id' => 1
        ]);
        $this->dispatch('refresh-account-book', $obj->id);
        $this->dispatch('notify', ...['type' => 'success', 'content' => $this->search. '- Account book Saved Successfully']);
        $this->showDropdown = false;
    }

    #[On('refresh-account-book-lookup')]
    public function refreshAccountBook($obj): void
    {
        if (!empty($obj['vname'])) {
            $this->search = $obj['vname'];
            $this->showCreateModal = false;
        } else {
            $this->search = '';
        }
    }

    public function render()
    {
        return view('transaction::account-book.lookup');
    }
}
