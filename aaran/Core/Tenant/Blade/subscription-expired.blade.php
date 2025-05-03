<x-Ui::layouts.guest :title="__('Subscription Expired')">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full">
            <h2 class="text-2xl font-bold text-center text-red-600 mb-4">Your Subscription Has Expired</h2>

            <p class="text-center text-lg text-gray-700 mb-6">
                Unfortunately, your subscription has expired. Please renew your subscription to regain access to all
                features.
            </p>

            <!-- Call to Action -->
            <div class="text-center">
                <a href="{{ route('subscription.renew') }}"
                   class="inline-block px-6 py-3 bg-blue-600 text-white rounded-full text-lg hover:bg-blue-700 transition duration-300">
                    Renew Now
                </a>
            </div>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Need help? <a href="{{ route('contacts') }}" class="text-blue-600 hover:text-blue-700">Contact
                        support</a>
                </p>
            </div>
        </div>
    </div>
</x-Ui::layouts.guest>
