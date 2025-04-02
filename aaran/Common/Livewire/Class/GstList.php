<?php

namespace Aaran\Common\Livewire\Class;

use Aaran\Assets\Traits\CommonTrait;
use Aaran\Common\Models\GstPercent;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class GstList extends Component
{
    use CommonTrait;

    #[Validate]
    public string $vname = '';
    public bool $active_id = true;
    public $desc;

    #region[Validation]
    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : '|unique:gst_percents,vname'),
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
            'vname' => 'gst percent',
        ];
    }

    #endregion[Validation]

    #region[save]
    public function getSave(): void
    {
        $this->validate();

        if ($this->vid == "") {
            GstPercent::create([
                'vname' => Str::ucfirst($this->vname),
                'desc' => $this->desc,
                'active_id' => $this->active_id,
            ]);
            $message = "Saved";

        } else {
            $obj = GstPercent::find($this->vid);
            $obj->vname = Str::ucfirst($this->vname);
            $obj->desc = $this->desc;
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
        $this->desc = '';
        $this->active_id = '1';
        $this->searches = '';
    }
    #endregion[Clear Fields]

    #region[obj]
    public function getObj($id): void
    {
        if ($id) {
            $obj = GstPercent::find($id);
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->desc = $obj->desc;
            $this->active_id = $obj->active_id;
        }
    }
    #endregion

    #region[list]
    public function getList()
    {
        return GstPercent::search($this->searches)
            ->where('active_id', '=', $this->activeRecord)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }
    #endregion

    #region[delete]
    public function deleteFunction($id): void
    {
        if ($id) {
            $obj = GstPercent::find($id);
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
        return view('common::gst-list')->with([
            'list' => $this->getList()
        ]);
    }
    #endregion
}
