<?php

namespace Aaran\BMS\Billing\Books\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Books\Models\Ledger;
use Aaran\BMS\Billing\Books\Models\LedgerGroup;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LedgerList extends Component
{

    use ComponentStateTrait, TenantAwareTrait;


    #[Validate]
    public string $vname = '';
    public string $description = '';
    public $ledger_group_id = '';
    public mixed $opening;
    public mixed $opening_date;
    public mixed $current;
    public bool $active_id = true;


    #region[Validation]
    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.ledgers,vname"),
        ];
    }

    public function messages(): array
    {
        return [
            'vname.required' => ':attribute is missing.',
            'vname.unique' => 'This :attribute is already created.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'vname' => 'Ledger Group',
        ];
    }
    #endregion

    #region[Save]
    public function getSave(): void
    {
        $this->validate();
        $connection = $this->getTenantConnection();

        Ledger::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'vname' => Str::ucfirst($this->vname),
                'desc' => $this->description,
                'ledger_group_id' => $this->ledger_group_id,
                'opening' => $this->opening,
                'opening_date' => $this->opening_date,
                'current' => $this->current,
                'active_id' => $this->active_id,
                'user_id' => auth()->id(),
            ],
        );

        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();
    }

    #endregion

    public function clearFields(): void
    {
        $this->vid = null;
        $this->vname = '';
        $this->description = '';
        $this->ledger_group_id = '';
        $this->opening = '';
        $this->opening_date = Carbon::now()->format('Y-m-d');
        $this->current = '';
        $this->active_id = true;
        $this->searches = '';
    }


    #region[Fetch Data]
    public function getObj(int $id): void
    {
        if ($obj = Ledger::on($this->getTenantConnection())->find($id)) {
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->description = $obj->description;
            $this->ledger_group_id = $obj->ledger_group_id;
            $this->opening = $obj->opening;
            $this->opening_date = $obj->opening_date;
            $this->current = $obj->current;
            $this->active_id = $obj->active_id;
        }
    }

    public function getList()
    {
        return Ledger::on($this->getTenantConnection())
            ->active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }
    #endregion

    #region[Delete]
    public function deleteFunction(): void
    {
        if (!$this->deleteId) return;

        $obj = Ledger::on($this->getTenantConnection())->find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }
    #endregion

    #region[ledger Group]

    public $ledger_name = '';
    public Collection $ledgerCollection;
    public $highlightLedger = 0;
    public $ledgerTyped = false;

    public function decrementLedger(): void
    {
        if ($this->highlightLedger === 0) {
            $this->highlightLedger = count($this->ledgerCollection) - 1;
            return;
        }
        $this->highlightLedger--;
    }

    public function incrementLedger(): void
    {
        if ($this->highlightLedger === count($this->ledgerCollection) - 1) {
            $this->highlightLedger = 0;
            return;
        }
        $this->highlightLedger++;
    }

    public function setLedger($name, $id): void
    {
        $this->ledger_name = $name;
        $this->ledger_group_id = $id;
        $this->getLedgerList();
    }

    public function enterLedger(): void
    {
        $obj = $this->ledgerCollection[$this->highlightLedger] ?? null;

        $this->ledger_name = '';
        $this->ledgerCollection = Collection::empty();
        $this->highlightLedger = 0;

        $this->ledger_name = $obj['vname'] ?? '';
        $this->ledger_group_id = $obj['id'] ?? '';
    }

    #[On('refresh-Ledger')]
    public function refreshLedger($v): void
    {
        $this->ledger_group_id = $v['id'];
        $this->ledger_name = $v['name'];
        $this->ledgerTyped = false;
    }

    public function getLedgerList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->ledgerCollection = $this->ledger_name ?
            LedgerGroup::on($this->getTenantConnection())->when($this->ledger_name, fn($query) => $query->where('vname', 'like', "%{$this->ledger_name}%"))->get() :
            Collection::empty();
    }
    #endregion

    #region[Render]
    public function render()
    {
        $this->getLedgerList();

        return view('books::ledger-list')->with([
            'list' => $this->getList(),
        ]);
    }

    #endregion
}
