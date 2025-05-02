<?php

namespace Aaran\ExternalPartners\Razorpay\Livewire\Class;

use Illuminate\Http\Request;
use Livewire\Component;

class SubscriptionPayment extends Component
{
    public string $plan;
    public int $amount;
    public string $tenantId;

    public mixed $razorpayKey;
    public string $userName;
    public string $userEmail;

    public function mount(Request $request)
    {
        $this->plan = $request->get('plan');
        $this->amount = (int)$request->get('amount');
        $this->tenantId = $request->get('tenant_id', session('tenant_id'));

        $this->razorpayKey = config('razorpay.razorpay.key');
        $this->userName = auth()->user()->name;
        $this->userEmail = auth()->user()->email;
    }

    public function render()
    {
        return view('razorpay::subscription-payment');
    }
}
