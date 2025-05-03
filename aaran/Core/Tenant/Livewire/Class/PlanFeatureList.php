<?php


namespace Aaran\Core\Tenant\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\Core\Tenant\Models\Feature;
use Aaran\Core\Tenant\Models\Plan;
use Aaran\Core\Tenant\Models\PlanFeature;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PlanFeatureList extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    #[Validate]
    public string $plan_id = '';
    public string $feature_id = '';
    public bool $active_id = true;

    public $plans = [];
    public $features = [];

    public function rules(): array
    {
        return [
            'plan_id' => 'required',
            'feature_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'plan_id.required' => ':attribute is missing.',
            'feature_id.unique' => 'This :attribute is already created.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'plan_id' => 'Plan',
            'feature_id' => 'Feature',
        ];
    }

    public function getSave(): void
    {
        $this->validate();

        PlanFeature::updateOrCreate(
            ['id' => $this->vid],
            [
                'plan_id' => $this->plan_id,
                'feature_id' => $this->feature_id,
                'active_id' => $this->active_id
            ],
        );

        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->clearFields();
    }

    public function clearFields(): void
    {
        $this->vid = null;
        $this->plan_id = '';
        $this->feature_id = '';
        $this->active_id = true;
        $this->searches = '';
    }

    public function getObj(int $id): void
    {
        if ($obj = PlanFeature::find($id)) {
            $this->vid = $obj->id;
            $this->plan_id = $obj->plan_id;
            $this->feature_id = $obj->feature_id;
            $this->active_id = $obj->active_id;
        }
    }

    public function getList()
    {
        return PlanFeature::active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }

    public function deleteFunction(): void
    {
        if (!$this->deleteId) return;

        $obj = PlanFeature::find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }


    public function mount()
    {
        $this->plans = Plan::all()->pluck('vname', 'id')->toArray();
        $this->features = Feature::all()->pluck('vname', 'id')->toArray();
    }

    public function render()
    {
        return view('tenant::plan-feature-list', [
            'list' => $this->getList()
        ]);
    }
}
