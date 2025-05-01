<?php


namespace Aaran\Core\Tenant\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Common\Models\City;
use Aaran\Core\Tenant\Models\Plan;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PlanList extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    #[Validate]
    public string $vname = '';
    public string $price = '';
    public string $billing_cycle = '';
    public string $description = '';
    public bool $active_id = true;

    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:plans,vname"),
            'price' => 'required' . ($this->vid ? '' : "|unique:plans,price"),
        ];
    }

    public function messages(): array
    {
        return [
            'vname.required' => ':attribute is missing.',
            'vname.unique' => 'This :attribute is already created.',

            'price.required' => ':attribute is missing.',
            'price.unique' => 'This :attribute is already created.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'vname' => 'Plan',
            'price' => 'Price',
        ];
    }

    public function getSave(): void
    {
        $this->validate();

        Plan::updateOrCreate(
            ['id' => $this->vid],
            [
                'vname' => Str::ucfirst($this->vname),
                'price' => $this->price,
                'billing_cycle' => $this->billing_cycle,
                'description' => $this->description,
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
        $this->price = '';
        $this->billing_cycle = '';
        $this->description = '';
        $this->active_id = true;
        $this->searches = '';
    }

    public function getObj(int $id): void
    {
        if ($obj = Plan::find($id)) {
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->price = $obj->price;
            $this->billing_cycle = $obj->billing_cycle;
            $this->description = $obj->description;
            $this->active_id = $obj->active_id;
        }
    }

    public function getList()
    {
        return Plan::active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }

    public function deleteFunction(): void
    {
        if (!$this->deleteId) return;

        $obj = Plan::find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }

    public function render()
    {
        return view('tenant::plan-list', [
            'list' => $this->getList()
        ]);
    }
}
