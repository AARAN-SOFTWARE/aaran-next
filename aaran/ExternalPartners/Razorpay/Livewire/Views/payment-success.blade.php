<div>
    <div class="max-w-xl mx-auto p-8 bg-white shadow rounded mt-10 text-center">
        <h1 class="text-2xl font-bold text-green-600 mb-4">Payment Successful!</h1>
        <p class="text-gray-700 mb-6">Thank you! Your payment has been processed successfully.</p>

        @if ($payment)
            <div class="text-left bg-gray-100 p-4 rounded">
                <p><strong>Order ID:</strong> {{ $payment->order_id }}</p>
                <p><strong>Payment ID:</strong> {{ $payment->payment_id }}</p>
                <p><strong>Amount:</strong> ₹{{ number_format($payment->amount / 100, 2) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
            </div>
        @endif

        @if($subscription)
            <div class="text-left bg-gray-100 p-4 rounded">
                <p><strong>plan</strong> {{ $subscription->plan->vname }}</p>
                <p><strong>Registered Date</strong>{{ date('d-m-Y', strtotime( $subscription->started_at))}}</p>
                <p><strong>Expires Date</strong>{{ date('d-m-Y', strtotime( $subscription->expires_at))}}</p>
                <p><strong>Status:</strong> {{ ucfirst($subscription->status) }}</p>
            </div>
        @endif

        <a href="{{ route('dashboard') }}" class="inline-block mt-6 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Go to Dashboard
        </a>
    </div>

    <x-Ui::setup.confetti-effect/>
</div>
