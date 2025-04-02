<?php

namespace Aaran\Common\Livewire\Class;

use Aaran\Assets\Traits\CommonTrait;
use Aaran\Common\Models\Despatch;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DispatchList extends Component
{
    use CommonTrait;

    #[Validate]
    public string $vname = '';
    public string $vdate = '';
    public bool $active_id = true;

    #region[Validation]
    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : '|unique:despatches,vname'),
        ];
    }

    public function messages(): array
    {
        return [
            'vname.required' => 'The :attribute are missing.',
            'vname.unique' => 'The :attribute is already created.',
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'vname' => 'name',
        ];
    }

    #endregion[Validation]

    #region[save]
    public function getSave(): void
    {
        $this->validate();

        if ($this->vid == "") {
            Despatch::create([
                'vname' => Str::ucfirst($this->vname),
                'vdate' => $this->vdate,
                'active_id' => $this->active_id,
            ]);
            $message = "Saved";

        } else {
            $obj = Despatch::find($this->vid);
            $obj->vname = Str::ucfirst($this->vname);
            $obj->vdate = $this->vdate;
            $obj->active_id = $this->active_id;
            $obj->save();
            $message = "Updated";
        }

        $this->dispatch('notify', ...['type' => 'success', 'content' => $message . ' Successfully']);
    }
    #endregion

    #region[Clear Fields]
    public function clearFields(): void
    {
        $this->vid = '';
        $this->vname = '';
        $this->vdate = '';
        $this->active_id = '1';
        $this->searches = '';
    }
    #endregion[Clear Fields]

    #region[obj]
    public function getObj($id): void
    {
        if ($id) {
            $obj = Despatch::find($id);
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->vdate = $obj->vdate;
            $this->active_id = $obj->active_id;
        }
    }
    #endregion

    #region[list]
    public function getList()
    {
        return Despatch::search($this->searches)
            ->where('active_id', '=', $this->activeRecord)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }
    #endregion

    #region[delete]
    public function deleteFunction($id): void
    {
        if ($id) {
            $obj = Despatch::find($id);
            if ($obj) {
                $obj->delete();
                $message = "Deleted Successfully";
                $this->dispatch('notify', ...['type' => 'success', 'content' => $message]);
            }
        }
    }
    #endregion

    #region[render]
    public function render()
    {
        return view('common::dispatch-list')->with([
            'list' => $this->getList()
        ]);
    }
    #endregion
}
