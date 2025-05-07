<div>
    <x-slot name="header">Gst Authenticate</x-slot>
    <x-Ui::forms.m-panel>
        <div>
            @if (session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div>
                <input type="email" wire:model="email" placeholder="Email" />
                <button wire:click="authenticate" class="bg-green-500 px-3 py-2" >Authenticate</button>
            </div>

            @if($authToken)
                <p><strong>Token:</strong> {{ $authToken }}</p>
            @endif
        </div>

    </x-Ui::forms.m-panel>
</div>
