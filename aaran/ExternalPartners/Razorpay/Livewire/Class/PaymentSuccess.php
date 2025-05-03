<?php

namespace Aaran\ExternalPartners\Razorpay\Livewire\Class;

use Aaran\Core\Tenant\Models\Subscription;
use Aaran\ExternalPartners\Razorpay\Models\RazorPayment;
use Illuminate\Http\Request;
use Livewire\Attributes\Layout;
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

        $subscription = Subscription::where('user_id', auth()->id())
            ->where('tenant_id', session('tenant_id'))
            ->latest()
            ->first();

        if ($subscription) {
            $subscription->update([
                'started_at' => now(),
                'expires_at' => now()->addDays(365),
                'status' => 'active',
            ]);

            $this->subscription = $subscription;
            // Step 3: Dispatch after saving
            $this->dispatch('tenant-created');
        }
    }

    #[Layout('Ui::components.layouts.guest')]
    public function render()
    {
        return view('razorpay::payment-success');
    }
}
