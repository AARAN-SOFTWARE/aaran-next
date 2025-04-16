<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class\Order;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Aaran\BMS\Billing\Master\Models\Order;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Modal extends Component
{
    use ComponentStateTrait, TenantAwareTrait;

    public bool $showCreateModal = false;

    #[Validate]
    public string $vname = '';
    public string $order_name = '';
    public bool $active_id = true;

    #region[Validation]
    public function rules(): array
    {
        return [
            'vname' => 'required' . ($this->vid ? '' : "|unique:{$this->getTenantConnection()}.orders,vname"),
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
            'vname' => 'Order name',
        ];
    }
    #endregion

    #region[Save]
    public function getSave(): void
    {
        $this->validate();
        $connection = $this->getTenantConnection();

        $order = Order::on($connection)->updateOrCreate(
            ['id' => $this->vid],
            [
                'vname' => Str::ucfirst($this->vname),
                'order_name' => $this->order_name ?: $this->vname,
                'active_id' => $this->active_id
            ],
        );
        $this->dispatch('refresh-order',$order->id);
        $this->dispatch('refresh-order-lookup',$order->vname);
        $this->dispatch('notify', ...['type' => 'success', 'content' => ($this->vid ? 'Updated' : 'Saved') . ' Successfully']);
        $this->closeModal();
    }

    #endregion

    public function closeModal(): void{
        $this->showCreateModal = false;
        $this->clearFields();
    }

    public function clearFields(): void
    {
        $this->vid = null;
        $this->vname = '';
        $this->order_name = '';
        $this->active_id = true;
        $this->searches = '';
    }

    #region[Fetch Data]
    public function getObj(int $id): void
    {
        if ($obj = Order::on($this->getTenantConnection())->find($id)) {
            $this->vid = $obj->id;
            $this->vname = $obj->vname;
            $this->order_name = $obj->order_name;
            $this->active_id = $obj->active_id;
        }
    }
    #endregion

    protected $listeners = ['open-create-order-modal' => 'setInitialName'];

    public function setInitialName($name): void
    {
        $this->vname = $name;
        $this->showCreateModal = true;
    }


    #region[Render]
    public function render()
    {
        return view('master::order.modal');
    }
    #endregion
}
