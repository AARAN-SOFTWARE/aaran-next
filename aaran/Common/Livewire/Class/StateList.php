<?php

namespace Aaran\Common\Livewire\Class;

use Aaran\Assets\Traits\CommonTrait;
use Aaran\Common\Models\State;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class StateList extends Component
{
    use CommonTrait;

    #[Validate]
    public string $vname = '';
    public bool $active_id = true;
    public $state_code;

    #region[Validation]
    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : '|unique:states,vname'),
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
            'vname' => 'state name',
        ];
    }

    #endregion[Validation]

    #region[save]
    public function getSave(): void
    {
        $this->validate();

        if ($this->vid == "") {
            State::create([
                'vname' => Str::ucfirst($this->vname),
                'state_code' => $this->state_code,
                'active_id' => $this->active_id,
            ]);
            $message = "Saved";

        } else {
            $obj = State::find($this->vid);
            $obj->vname = Str::ucfirst($this->vname);
            $obj->state_code = $this->state_code;
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
        $this->state_code = '';
        $this->active_id = '1';
        $this->searches = '';
    }
    #endregion[Clear Fields]

    #region[obj]
    public function getObj($id): void
    {
        if ($id) {
            $obj = State::find($id);
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->state_code = $obj->state_code;
            $this->active_id = $obj->active_id;
        }
    }
    #endregion

    #region[list]
    public function getList()
    {
        return State::search($this->searches)
            ->where('active_id', '=', $this->activeRecord)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }
    #endregion

    #region[delete]
    public function deleteFunction($id): void
    {
        if ($id) {
            $obj = State::find($id);
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
        return view('common::state-list')->with([
            'list' => $this->getList()
        ]);
    }
    #endregion
}
