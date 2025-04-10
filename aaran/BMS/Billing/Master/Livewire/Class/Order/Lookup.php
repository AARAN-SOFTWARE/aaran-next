<?php

namespace Aaran\BMS\Billing\Master\Livewire\Class\Order;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\Assets\Traits\TenantAwareTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Lookup extends Component
{

    use ComponentStateTrait, TenantAwareTrait;

    public bool $showModal = false;

    public $order_name = '';

    public $order_id = '';
    public $orderCollection;
    public $highlightOrder = 0;
    public $orderTyped = false;

    public function decrementOrder(): void
    {
        if ($this->highlightOrder === 0) {
            $this->highlightOrder = count($this->orderCollection) - 1;
            return;
        }
        $this->highlightOrder--;
    }

    public function incrementOrder(): void
    {
        if ($this->highlightOrder === count($this->orderCollection) - 1) {
            $this->highlightOrder = 0;
            return;
        }
        $this->highlightOrder++;
    }

    public function setOrder($name, $id): void
    {
        $this->order_name = $name;
        $this->order_id = $id;
        $this->getOrderList();
    }

    public function enterOrder(): void
    {
        $obj = $this->orderCollection[$this->highlightOrder] ?? null;

        $this->order_name = '';
        $this->orderCollection = Collection::empty();
        $this->highlightOrder = 0;

        $this->order_name = $obj->vname ?? '';
        $this->order_id = $obj->id ?? '';
    }

    #[On('refresh-order')]
    public function refreshOrder($v): void
    {
        $this->order_id = $v['id'];
        $this->order_name = $v['vname'];
        $this->orderTyped = false;
    }

    public function getOrderList(): void
    {
        if (!$this->getTenantConnection()) {
            return; // Prevent execution if tenant is not set
        }

        $this->orderCollection = DB::connection($this->getTenantConnection())
            ->table('orders')
            ->when(trim($this->order_name), fn($query) => $query->where('vname', 'like', '%' . trim($this->order_name) . '%'))
            ->get();
    }

    public function render()
    {
        $this->getOrderList();

        return view('master::order.lookup');
    }
}
