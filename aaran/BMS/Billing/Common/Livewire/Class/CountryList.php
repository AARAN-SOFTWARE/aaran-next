<?php

namespace Aaran\BMS\Billing\Common\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Common\Models\Country;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CountryList extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    #[Validate]
    public string $vname = '';
    public string $currency_symbol = '';

    public bool $active_id = true;


    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.countries,vname"),
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
            'vname' => 'Country name',
        ];
    }

    public function getSave(): void
    {
        $this->validate();
        $connection = $this->getTenantConnection();

        Country::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'vname' => Str::ucfirst($this->vname),
                'currency_symbol' => $this->currency_symbol,
                'active_id' => $this->active_id
            ],
        );

        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();
    }


    public function clearFields(): void
    {
        $this->vid = null;
        $this->vname = '';
        $this->currency_symbol = '';
        $this->active_id = true;
        $this->searches = '';
    }

    public function getObj(int $id): void
    {
        if ($obj = Country::on($this->getTenantConnection())->find($id)) {
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->currency_symbol = $obj->currency_symbol;
            $this->active_id = $obj->active_id;
        }
    }

    public function getList()
    {
        return Country::on($this->getTenantConnection())
            ->active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }

    public function deleteFunction(): void
    {
        if (!$this->deleteId) return;

        $obj = Country::on($this->getTenantConnection())->find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }

    public function render()
    {
        return view('common::country-list', [
            'list' => $this->getList()
        ]);
    }

}
