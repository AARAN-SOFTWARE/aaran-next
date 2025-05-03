<?php

namespace Aaran\ExternalPartners\Razorpay\Livewire\Class;

use Aaran\Core\Tenant\Models\Subscription;
use Aaran\ExternalPartners\Razorpay\Models\RazorPayment;
use Illuminate\Http\Request;
use Livewire\Component;

class PaymentSuccess extends Component
{

    public $payment;
    public $subscription;
    public function mount(Request $request)
    {
        // Optional: retrieve latest payment or subscription
        $this->payment = RazorPayment::where('user_id', auth()->id())
            ->latest()
            ->first();

        $this->subscription = Subscription::where('user_id', auth()->id())
            ->where('tenant_id', session('tenant_id'))
            ->latest()
            ->first();


    }

    public function render()
    {
        return view('razorpay::payment-success');
    }
}
