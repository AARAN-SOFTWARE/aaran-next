<?php

namespace Aaran\Common\Livewire\Class;


use Aaran\Assets\Traits\CommonTrait;
use Aaran\Common\Models\Pincode;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class PincodeList extends Component
{
    use CommonTrait;

    #[Validate]
    public string $vname = '';
    public bool $active_id = true;

    #region[Validation]
    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : '|unique:pincodes,vname'),
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
            Pincode::create([
                'vname' => Str::ucfirst($this->vname),
                'active_id' => $this->active_id,
            ]);
            $message = "Saved";

        } else {
            $obj = Pincode::find($this->vid);
            $obj->vname = Str::ucfirst($this->vname);
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
        $this->active_id = '1';
        $this->searches = '';
    }
    #endregion[Clear Fields]

    #region[obj]
    public function getObj($id): void
    {
        if ($id) {
            $obj = Pincode::find($id);
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->active_id = $obj->active_id;
        }
    }
    #endregion

    #region[list]
    public function getList()
    {
        return Pincode::search($this->searches)
            ->where('active_id', '=', $this->activeRecord)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }
    #endregion

    #region[delete]
    public function deleteFunction($id): void
    {
        if ($id) {
            $obj = Pincode::find($id);
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
        return view('common::pincode-list')->with([
            'list' => $this->getList()
        ]);
    }
    #endregion
}
