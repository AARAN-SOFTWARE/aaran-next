<div>
    <x-Ui::loadings.loading/>

    <!-- Banner -->
    <x-Ui::web.home-new.items.banner
        label="Setup"
        desc="Empowering your digital dreams"
        padding="sm:px-[160px]"
        padding_mob="px-[70px]"
    />

    <div class="mt-10 max-w-3xl mx-auto bg-white shadow-lg border border-neutral-200 rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800">Setup</h2>
        <p class="text-gray-600">Step {{ $step }} of 4</p>

        <!-- Step 1: Tenant Details -->
        @if($step === 1)
            <div>
                <label class="block text-gray-700">Business Name</label>
                <input type="text" wire:model.defer="b_name" class="w-full border rounded px-3 py-2 mt-1">
                @error('b_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <label class="block text-gray-700 mt-4">Tenant Name</label>
                <input type="text" wire:model.defer="t_name" class="w-full border rounded px-3 py-2 mt-1">
                @error('t_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <label class="block text-gray-700 mt-4">Email</label>
                <input type="email" wire:model.defer="email" class="w-full border rounded px-3 py-2 mt-1">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        @endif

        <!-- Step 2: Database Setup -->
        @if($step === 2)
            <div>
                <label class="block text-gray-700">Database Name</label>
                <input type="text" wire:model.defer="db_name" class="w-full border rounded px-3 py-2 mt-1">

                <label class="block text-gray-700 mt-4">Database User</label>
                <input type="text" wire:model.defer="db_user" class="w-full border rounded px-3 py-2 mt-1">

                <label class="block text-gray-700 mt-4">Database Password</label>
                <input type="password" wire:model.defer="db_pass" class="w-full border rounded px-3 py-2 mt-1">
            </div>
        @endif

        <!-- Step 3: Subscription & Security -->
        @if($step === 4)
            <div>
                <label class="block text-gray-700">Plan</label>
                <select wire:model="plan" class="w-full border rounded px-3 py-2 mt-1">
                    <option value="free">Free</option>
                    <option value="premium">Premium</option>
                </select>

                <label class="block text-gray-700 mt-4">Storage Limit (GB)</label>
                <input type="number" wire:model="storage_limit" class="w-full border rounded px-3 py-2 mt-1">
            </div>
        @endif

        <!-- Step 4: Industry & Features -->
        @if($step === 3)
            <div>
                <label class="block text-gray-700">Select Industry</label>
                <select wire:model="industry_id" class="w-full border rounded px-3 py-2 mt-1">
                    @foreach($industries ?? [] as $industry)
                        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                    @endforeach
                </select>
                @error('industry_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <label class="block text-gray-700 mt-4">Enable Features</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($features ?? [] as $feature)
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="selected_features" value="{{ $feature->id }}" class="mr-2">
                            {{ $feature->name }}
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-6">
            @if($step > 1)
                <button wire:click="prevStep" class="bg-gray-500 text-white px-4 py-2 rounded">Previous</button>
            @endif
            @if($step < 4)
                <button wire:click="nextStep" class="bg-blue-500 text-white px-4 py-2 rounded">Next</button>
            @endif
            @if($step === 4)
                <button wire:click="createTenant" class="bg-green-500 text-white px-4 py-2 rounded">Submit</button>
            @endif
        </div>
    </div>

    <x-Ui::setup.alerts/>
    <x-Ui::setup.confetti-effect/>
</div>
