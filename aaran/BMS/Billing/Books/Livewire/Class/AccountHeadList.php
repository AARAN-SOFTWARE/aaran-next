<?php

namespace Aaran\BMS\Billing\Books\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Books\Models\AccountHeads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AccountHeadList extends Component
{

    use ComponentStateTrait, TenantAwareTrait;


    #[Validate]
    public string $vname = '';
    public string $description = '';
    public mixed $opening;
    public mixed $opening_date;
    public mixed $current;
    public bool $active_id = true;


    #region[Validation]
    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.account_heads,vname"),
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
            'vname' => 'Account Head',
        ];
    }
    #endregion

    #region[Save]
    public function getSave(): void
    {
        $this->validate();

        $connection = $this->getTenantConnection();

        AccountHeads::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'vname' => Str::ucfirst($this->vname),
                'description' => $this->description,
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

    public function clearFields(): void
    {
        $this->vid = null;
        $this->vname = '';
        $this->description = '';
        $this->opening = '';
        $this->opening_date = Carbon::now()->format('Y-m-d');
        $this->current = '';
        $this->active_id = true;
        $this->searches = '';
    }


    #region[Fetch Data]
    public function getObj(int $id): void
    {
        if ($obj = AccountHeads::on($this->getTenantConnection())->find($id)) {
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->description = $obj->description;
            $this->opening = $obj->opening;
            $this->opening_date = $obj->opening_date;
            $this->current = $obj->current;
            $this->active_id = $obj->active_id;
        }
    }

    public function getList()
    {
        return AccountHeads::on($this->getTenantConnection())
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

        $obj = AccountHeads::on($this->getTenantConnection())->find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }
    #endregion

    #region[Render]
    public function render()
    {
        return view('books::account-head-list')->with([
            'list' => $this->getList(),
        ]);
    }

    #endregion
}
