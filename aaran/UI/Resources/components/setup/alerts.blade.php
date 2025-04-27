<div class="mt-5 max-w-3xl mx-auto">
    <!-- Success Alert -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             class="bg-green-500 text-white p-3 rounded-lg shadow-md mb-4">
            <strong>✅ Success:</strong> {{ session('success') }}
        </div>
    @endif

    <!-- Error Alert -->
    @if (session()->has('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)"
             class="bg-red-500 text-white p-3 rounded-lg shadow-md mb-4">
            <strong>⚠️ Error:</strong> {{ session('error') }}
        </div>
@endif
</div>
