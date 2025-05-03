<x-Ui::layouts.guest :title="__('Subscription Renew')">
    <div class="bg-gray-50 flex items-center justify-center min-h-fit">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg w-full">
            <h2 class="text-2xl font-bold text-center text-blue-600 mb-4">Renew Your Subscription</h2>

            <p class="text-center text-lg text-gray-700 mb-6">
                Your subscription has expired. To continue enjoying uninterrupted access to all features, please renew
                your subscription.
            </p>

            <!-- Subscription Plan Options -->
            <div class="space-y-4 mb-6">
                <div class="border p-4 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <h3 class="text-xl font-semibold text-blue-600">Basic Plan</h3>
                    <p class="text-lg text-gray-700">Access to basic features and support.</p>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-lg font-bold text-green-600">rs.100 / month</span>
                        <a href="{{ route('subscription.pay', ['plan' => 'basic', 'amount'=>'100']) }}"
                           class="inline-block px-6 py-3 bg-blue-600 text-white rounded-full text-lg hover:bg-blue-700 transition duration-300">
                            Renew Now
                        </a>
                    </div>
                </div>

                <div class="border p-4 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                    <h3 class="text-xl font-semibold text-blue-600">Pro Plan</h3>
                    <p class="text-lg text-gray-700">Access to all features, premium support, and more.</p>
                    <div class="flex justify-between items-center mt-4">
                        <span class="text-lg font-bold text-green-600">rs.100 / month</span>
                        <a href="{{ route('subscription.pay', ['plan' => 'pro', 'amount'=>'100']) }}"
                           class="inline-block px-6 py-3 bg-blue-600 text-white rounded-full text-lg hover:bg-blue-700 transition duration-300">
                            Renew Now
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Support -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Need help or have questions? <a href="{{ route('contacts') }}"
                                                    class="text-blue-600 hover:text-blue-700">Contact support</a>
                </p>
            </div>
        </div>
    </div>
</x-Ui::layouts.guest>
