<?php


namespace Aaran\Core\Tenant\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\Core\Tenant\Models\Plan;
use Aaran\Core\Tenant\Models\Subscription;
use Aaran\Core\Tenant\Models\Tenant;
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
    public bool $active_id = true;

    public array $tenants = [];
    public array $plans = [];

    public function rules(): array
    {
        return [
            'tenant_id' => 'required',
            'plan_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'tenant_id.unique' => 'This :attribute is already created.',
            'plan_id.required' => ':attribute is missing.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'tenant_id' => 'Tenant',
            'plan_id' => 'Plan',
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
        $this->tenant_id = '';
        $this->plan_id = '';
        $this->status = '';
        $this->started_at = '';
        $this->expires_at = '';
        $this->searches = '';
    }

    public function getObj(int $id): void
    {
        if ($obj = Subscription::find($id)) {
            $this->vid = $obj->id;
            $this->tenant_id = $obj->tenant_id;
            $this->plan_id = $obj->plan_id;
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

    public function mount(): void
    {
        $this->tenants = Tenant::all()->pluck('t_name', 'id')->toArray();
        $this->plans = Plan::all()->pluck('vname', 'id')->toArray();
    }

    public function render()
    {
        return view('tenant::subscription-list', [
            'list' => $this->getList()
        ]);
    }
}
