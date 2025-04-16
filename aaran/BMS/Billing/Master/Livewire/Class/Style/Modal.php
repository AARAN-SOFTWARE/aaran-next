<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class\Style;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Master\Models\Style;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Modal extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    public bool $showCreateModal = false;

    #[Validate]
    public string $vname = '';
    public string $description = '';
    public string $image = '';
    public bool $active_id = true;

    #region[Validation]
    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.styles,vname"),
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
            'vname' => 'Styles name',
        ];
    }
    #endregion

    #region[Save]
    public function getSave(): void
    {
        $this->validate();
        $connection = $this->getTenantConnection();

        $style = Style::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'vname' => Str::ucfirst($this->vname),
                'description' => $this->description,
                'image' => $this->image,
                'active_id' => $this->active_id
            ],
        );
        $this->dispatch('refresh-style', $style->id);
        $this->dispatch('refresh-style-lookup', $style->vname);
        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->closeModal();
    }

    #endregion

    public function closeModal(): void
    {
        $this->showCreateModal = false;
        $this->clearFields();
    }

    public function clearFields(): void
    {
        $this->vid = null;
        $this->vname = '';
        $this->description = '';
        $this->image = '';
        $this->active_id = true;
        $this->searches = '';
    }

    #region[Fetch Data]
    public function getObj(int $id): void
    {
        if ($obj = Style::on($this->getTenantConnection())->find($id)) {
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->description = $obj->description;
            $this->image = $obj->image;
            $this->active_id = $obj->active_id;
        }
    }

    #endregion

    protected $listeners = ['open-create-style-modal' => 'setInitialName'];

    public function setInitialName($name): void
    {
        $this->vname = $name;
        $this->showCreateModal = true;
    }


    #region[Render]
    public function render()
    {
        return view('master::style.modal');
    }
    #endregion
}
