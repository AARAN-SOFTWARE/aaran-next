<?php

namespace Aaran\BMS\Billing\Books\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Books\Models\LedgerGroup;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LedgerGroupList extends Component
{

    use ComponentStateTrait, TenantAwareTrait;


    #[Validate]
    public string $vname = '';
    public string $description = '';
    public $account_head_id = '';
    public mixed $opening;
    public mixed $opening_date;
    public mixed $current;
    public bool $active_id = true;


    #region[Validation]
    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.ledger_groups,vname"),
            'account_head_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'vname.required' => ':attribute is missing.',
            'vname.unique' => 'This :attribute is already created.',
            'account_head_id.required' => ':attribute is missing.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'vname' => 'Ledger Group',
            'account_head_id' => 'Account Head',
        ];
    }
    #endregion

    #region[Save]
    public function getSave(): void
    {
        $this->validate();

        $connection = $this->getTenantConnection();

        LedgerGroup::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'vname' => Str::ucfirst($this->vname),
                'description' => $this->description,
                'account_head_id' => $this->account_head_id ?: '1',
                'opening' => $this->opening,
                'opening_date' => $this->opening_date,
                'current' => $this->current,
                'active_id' => $this->active_id,
            ],
        );

        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();
    }

    #endregion

    #region[Clear Fields]
    public function clearFields(): void
    {
        $this->vid = null;
        $this->vname = '';
        $this->description = '';
        $this->account_head_id = '';
        $this->opening = '';
        $this->opening_date = Carbon::now()->format('Y-m-d');
        $this->current = '';
        $this->active_id = true;
        $this->searches = '';
    }
    #endregion

    #region[Fetch Data]
    public function getObj(int $id): void
    {
        if ($obj = LedgerGroup::on($this->getTenantConnection())->find($id)) {
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->description = $obj->description;
            $this->account_head_id = $obj->account_head_id;
            $this->account_name = $obj->account_head->vname;
            $this->opening = $obj->opening;
            $this->opening_date = $obj->opening_date;
            $this->current = $obj->current;
            $this->active_id = $obj->active_id;
        }
    }

    public function getList()
    {
        return LedgerGroup::on($this->getTenantConnection())
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

        $obj = LedgerGroup::on($this->getTenantConnection())->find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }
    #endregion

    #region[account head]
    public $account_name = '';
    public Collection $accountCollection;
    public $highlightAccount = 0;
    public $accountTyped = false;

    public function decrementAccount(): void
    {
        if ($this->highlightAccount === 0) {
            $this->highlightAccount = count($this->accountCollection) - 1;
            return;
        }
        $this->highlightAccount--;
    }

    public function incrementAccount(): void
    {
        if ($this->highlightAccount === count($this->accountCollection) - 1) {
            $this->highlightAccount = 0;
            return;
        }
        $this->highlightAccount++;
    }

    public function setAccount($name, $id): void
    {
        $this->account_name = $name;
        $this->account_head_id = $id;
        $this->getAccountList();
    }

    public function enterAccount(): void
    {
        $obj = $this->accountCollection[$this->highlightAccount] ?? null;

        $this->account_name = '';
        $this->accountCollection = Collection::empty();
        $this->highlightAccount = 0;

        $this->account_name = $obj->vname ?? '';
        $this->account_head_id = $obj->id ?? '';
    }

    #[On('refresh-Account')]
    public function refreshAccount($v): void
    {
        $this->account_head_id = $v['id'];
        $this->account_name = $v['name'];
        $this->accountTyped = false;
    }

    public function getAccountList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->accountCollection = DB::connection($this->getTenantConnection())
            ->table('account_heads')
            ->when($this->account_name, fn($query) => $query->where('vname', 'like', "%{$this->account_name}%"))
            ->get();
    }

    #endregion

    #region[Render]
    public function render()
    {
        $this->getAccountList();

        return view('books::ledger-group-list')->with([
            'list' => $this->getList(),
        ]);
    }

    #endregion
}
