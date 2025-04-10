<div class="relative">
    <input
        type="text"
        class="form-input w-full"
        placeholder="Search Contact..."
        wire:model.debounce.300ms="search"
        wire:focus="showDropdown"
        wire:blur="hideDropdown"
    />

    @if($showDropdown && count($results) > 0)
        <ul class="absolute z-50 w-full bg-white border border-gray-200 mt-1 rounded shadow">
            @foreach($results as $result)
                <li
                    wire:click="selectContact({{ $result->id }})"
                    class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                >
                    {{ $result->name }}
                </li>
            @endforeach
        </ul>
    @elseif($showDropdown && strlen($search) > 0)
        <ul class="absolute z-50 w-full bg-white border border-gray-200 mt-1 rounded shadow">
            <li class="px-4 py-2 text-gray-500">No results found</li>
        </ul>
    @endif
</div>
