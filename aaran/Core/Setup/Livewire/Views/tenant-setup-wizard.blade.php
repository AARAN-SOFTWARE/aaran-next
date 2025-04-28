<div>

    <x-Ui::loadings.loading/>

    <div class="relative font-roboto tracking-wider">
        <div class="h-[20rem] bg-amber-100">
        </div>
        <div class="w-full absolute text-white top-[120px] text-center flex-col flex items-center justify-center">
            <div class="z-20 w-6/12 mx-auto sm:text-8xl text-4xl font-semibold pb-4 animate__animated wow bounceInDown"
                 data-wow-duration="3s">Setup
            </div>
            <span
                class="z-10 absolute rounded-xl sm:top-6 -top-2 sm:py-6 py-3 sm:px-[180px] px-[80px]
                bg-gradient-to-r from-transparent via-[#1CB5E0] to-[#000851]
                animate__animated wow animate__backInLeft" data-wow-duration="3s">&nbsp;</span>
            <div class="sm:w-6/12 w-auto mx-auto text-black sm:text-lg pb-4 animate__animated wow animate__backInRight" data-wow-duration="3s">
                Empowering your digital dreams
            </div>
        </div>
    </div>



    <div class="mt-10 max-w-3xl mx-auto bg-white shadow-lg border border-neutral-200 rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800">Setup</h2>
        <p class="text-gray-600">Step {{ $step }} of 4</p>

        <!-- Step 1: Tenant Details -->
        @if($step === 1)
            <div>
                <label class="block text-gray-700">Business Name</label>
                <input type="text" wire:model.defer="b_name" class="w-full border rounded px-3 py-2 mt-1">
                <x-Ui::input.error-text wire:model="b_name"/>

                <label class="block text-gray-700 mt-4">Tenant Name</label>
                <input type="text" wire:model.defer="t_name" class="w-full border rounded px-3 py-2 mt-1">
                <x-Ui::input.error-text wire:model="t_name"/>

                <label class="block text-gray-700 mt-4">Email</label>
                <input type="email" wire:model.defer="email" class="w-full border rounded px-3 py-2 mt-1">
                <x-Ui::input.error-text wire:model="email"/>
            </div>
        @endif

        <!-- Step 2: Database Setup -->
        @if($step === 2)
            <div>
                <label class="block text-gray-700">Database Name</label>
                <input type="text" wire:model.defer="db_name" class="w-full border rounded px-3 py-2 mt-1">
                <x-Ui::input.error-text wire:model="db_name"/>

                <label class="block text-gray-700 mt-4">Database User</label>
                <input type="text" wire:model.defer="db_user" class="w-full border rounded px-3 py-2 mt-1">
                <x-Ui::input.error-text wire:model="db_user"/>

                <label class="block text-gray-700 mt-4">Database Password</label>
                <input type="password" wire:model.defer="db_pass" class="w-full border rounded px-3 py-2 mt-1">
                <x-Ui::input.error-text wire:model="db_pass"/>
            </div>
        @endif

        <!-- Step 3: Industry & Features -->
        @if($step === 3)
            <div>
                <label class="block text-gray-700">Select Industry</label>
                <select wire:model="industry_id" class="w-full border rounded px-3 py-2 mt-1">
                    @foreach($industries ?? [] as $industry)
                        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                    @endforeach
                </select>
                <x-Ui::input.error-text wire:model="industry_id"/>

                <label class="block text-gray-700 mt-4">Enable Features</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($features ?? [] as $feature)
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="selected_features" value="{{ $feature->id }}"
                                   class="mr-2">
                            {{ $feature->name }}
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Step 4: Subscription & Security -->
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

<script>
    document.addEventListener('livewire:update', () => {
        const logsContainer = document.getElementById('logs-container');
        if (logsContainer) {
            logsContainer.scrollTo({
                top: logsContainer.scrollHeight,
                behavior: 'smooth'
            });
        }
    });
</script>
