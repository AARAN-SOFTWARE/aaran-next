<div>
<x-slot name="header">Payment</x-slot>
    <div
        x-data="{
        async pay() {
            try {
                // Step 1: Get order ID from server
                const response = await fetch('{{ route('razorpay.createOrder') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: {{ $amount }},
                        currency: 'INR',
                        receipt: 'receipt_{{ uniqid() }}'
                    })
                });

                const { order_id } = await response.json();

                // Step 2: Launch Razorpay
                const options = {
                    key: '{{ $razorpayKey }}',
                    amount: '{{ $amount }}',
                    currency: 'INR',
                    name: 'YourAppName',
                    description: 'Subscription: {{ ucfirst($plan) }}',
                    order_id: order_id,
                    handler: async function (response) {
                        const verifyResponse = await fetch('{{ route('razorpay.verify') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(response)
                        });

                        const result = await verifyResponse.json();
                        if (result.success) {
                            window.location.href = '{{ route('payment-succes') }}';
                        } else {
                            alert('Payment verification failed!');
                        }
                    },
                    prefill: {
                        name: '{{ $userName }}',
                        email: '{{ $userEmail }}',
                    },
                    theme: {
                        color: '#0d6efd'
                    }
                };

                const rzp = new Razorpay(options);
                rzp.open();
            } catch (e) {
                console.error('Payment error', e);
                alert('Payment could not be initiated.');
            }
        }
    }"
        x-init="pay()"
        class="p-10 text-center bg-white shadow rounded max-w-md mx-auto mt-10"
    >
        <h1 class="text-xl font-semibold mb-4">Processing Payment...</h1>
        <p class="text-gray-600">Launching Razorpay Checkout. Please wait.</p>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
