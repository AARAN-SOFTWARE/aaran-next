<?php


namespace Aaran\Core\Tenant\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\Core\Tenant\Models\Feature;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class FeatureList extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    #[Validate]
    public string $vname = '';
    public string $code = '';
    public string $description = '';
    public bool $active_id = true;

    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:features,vname"),
            'code' => 'required' . ($this->vid ? '' : "|unique:features,price"),
        ];
    }

    public function messages(): array
    {
        return [
            'vname.required' => ':attribute is missing.',
            'vname.unique' => 'This :attribute is already created.',

            'code.required' => ':attribute is missing.',
            'code.unique' => 'This :attribute is already created.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'vname' => 'Name',
            'code' => 'Code',
        ];
    }

    public function getSave(): void
    {
        $this->validate();

        Feature::updateOrCreate(
            ['id' => $this->vid],
            [
                'vname' => Str::ucfirst($this->vname),
                'code' => $this->code,
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
        $this->code = '';
        $this->description = '';
        $this->active_id = true;
        $this->searches = '';
    }

    public function getObj(int $id): void
    {
        if ($obj = Feature::find($id)) {
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->code = $obj->code;
            $this->description = $obj->description;
            $this->active_id = $obj->active_id;
        }
    }

    public function getList()
    {
        return Feature::active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }

    public function deleteFunction(): void
    {
        if (!$this->deleteId) return;

        $obj = Feature::find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }

    public function render()
    {
        return view('tenant::feature-list', [
            'list' => $this->getList()
        ]);
    }
}
