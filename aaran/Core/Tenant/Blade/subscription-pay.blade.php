<x-layouts.app :title="__('Pay')">
    <div class="bg-gray-50 flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full">
            <h2 class="text-2xl font-bold text-center text-blue-600 mb-4">Complete Your Payment</h2>

            <p class="text-center text-lg text-gray-700 mb-6">
                You are about to renew your <strong>
                    {{--            {{ ucfirst($plan) }}--}}
                </strong> subscription. Please choose a payment method below to continue.
            </p>

            <!-- Payment Options -->
            <div class="space-y-4 mb-6">
                <!-- Option 1: Stripe -->
                <div class="border p-4 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <h3 class="text-xl font-semibold text-blue-600">Pay with Stripe</h3>
                    <p class="text-lg text-gray-700">Securely pay with your credit/debit card using Stripe.</p>
                    <div class="mt-4">
                        <form
                            {{--                    action="{{ route('subscription.stripe') }}" --}}
                            method="POST">
                            @csrf
                            <input type="hidden" name="plan"
                                {{--                           value="{{ $plan }}"--}}
                            >

                            <button type="submit"
                                    class="inline-block px-6 py-3 bg-blue-600 text-white rounded-full text-lg hover:bg-blue-700 transition duration-300">
                                Pay with Stripe
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Option 2: PayPal -->
                <div class="border p-4 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <h3 class="text-xl font-semibold text-blue-600">Pay with PayPal</h3>
                    <p class="text-lg text-gray-700">Pay with your PayPal account for a quick and secure payment
                        experience.</p>
                    <div class="mt-4">
                        <form
                            {{--                    action="{{ route('subscription.paypal') }}" --}}
                            method="POST">
                            @csrf
                            <input type="hidden" name="plan"
                                {{--                           value="{{ $plan }}"--}}
                            >

                            <button type="submit"
                                    class="inline-block px-6 py-3 bg-blue-600 text-white rounded-full text-lg hover:bg-blue-700 transition duration-300">
                                Pay with PayPal
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Back to Dashboard or Other Options -->
            <div class="text-center mt-6">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-700">
                    Back to Dashboard
                </a>
            </div>

        </div>
    </div>
</x-layouts.app>
