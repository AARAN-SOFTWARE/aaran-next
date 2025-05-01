<?php


namespace Aaran\Core\Tenant\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Common\Models\City;
use Aaran\Core\Tenant\Models\Subscription;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SubscriptionList extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    #[Validate]
    public string $tenant_id = '';
    public string $plan_id = '';
    public string $status = '';
    public string $started_at = '';
    public string $expires_at = '';

    public function rules(): array
    {
        return [
            'plan_id' => 'required',
            'tenant_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'plan_id.required' => ':attribute is missing.',
            'tenant_id.unique' => 'This :attribute is already created.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'plan_id' => 'Plan',
            'tenant_id' => 'Tenant',
        ];
    }

    public function getSave(): void
    {
        $this->validate();

        Subscription::updateOrCreate(
            ['id' => $this->vid],
            [
                'tenant_id' => $this->tenant_id,
                'plan_id' => $this->plan_id,
                'status' => $this->status,
                'started_at' => $this->started_at,
                'expires_at' => $this->expires_at,
            ],
        );

        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();
    }

    public function clearFields(): void
    {
        $this->vid = null;
        $this->plan_id = '';
        $this->tenant_id = '';
        $this->status = '';
        $this->started_at = '';
        $this->expires_at = '';
        $this->searches = '';
    }

    public function getObj(int $id): void
    {
        if ($obj = Subscription::find($id)) {
            $this->vid = $obj->id;
            $this->plan_id = $obj->vname;
            $this->tenant_id = $obj->code;
            $this->status = $obj->status;
            $this->started_at = $obj->started_at;
            $this->expires_at = $obj->expires_at;
        }
    }

    public function getList()
    {
        return Subscription::when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }

    public function deleteFunction(): void
    {
        if (!$this->deleteId) return;

        $obj = Subscription::find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }

    public function render()
    {
        return view('common::city-list', [
            'list' => $this->getList()
        ]);
    }
}
