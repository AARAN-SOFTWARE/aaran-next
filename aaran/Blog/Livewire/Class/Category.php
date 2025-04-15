<?php

namespace Aaran\Blog\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\Blog\Models\BlogCategory;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Category extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    #[Validate]
    public string $vname = '';
    public bool $active_id = true;

    #region[Validation]
    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.blog_categories,vname"),
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
            'vname' => 'Category name',
        ];
    }

    #endregion[Validation]

    #region[getSave]
    public function getSave(): void
    {
        $this->validate();
        $connection = $this->getTenantConnection();

        BlogCategory::on($connection)->updateOrCreate(
        ['id' => $this->vid],
        [
            'vname' => Str::ucfirst($this->vname),
            'active_id' => $this->active_id
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
        $this->active_id = true;
        $this->searches = '';
    }
    #endregion[Clear Fields]

    #region[getObj]
    public function getObj($id): void
    {
        if ($id) {
            $obj = BlogCategory::on($this->getTenantConnection())->find($id);
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->active_id = $obj->active_id;
        }
    }
    #endregion

    #region[getList]
    public function getList()
    {
        return BlogCategory::on($this->getTenantConnection())
            ->active($this->activeRecord)
            ->when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }
    #endregion

    #region[delete]
    public function deleteFunction(): void
    {
        if (!$this->deleteId) return;

        $obj = BlogCategory::on($this->getTenantConnection())->find($this->deleteId);
        if ($obj) {
            $obj->delete();
        }
    }
    #endregion

    #region[render]
    public function render()
    {
        return view('blog::category')->with([
            'list' => $this->getList()
        ]);
    }
    #endregion
}
