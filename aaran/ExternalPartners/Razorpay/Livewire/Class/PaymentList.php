<?php

namespace Aaran\ExternalPartners\Razorpay\Livewire\Class;

use Aaran\Assets\Traits\ComponentStateTrait;
use Aaran\ExternalPartners\Razorpay\Models\RazorPayment;
use Livewire\Component;

class PaymentList extends Component
{
    use ComponentStateTrait;
    public function getList()
    {
        return RazorPayment::when($this->searches, fn($query) => $query->searchByName($this->searches))
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('razorpay::payment-list', [
            'list' => $this->getList()
        ]);
    }
}
