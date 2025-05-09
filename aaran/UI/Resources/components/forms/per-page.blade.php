<x-Ui::input.group borderless paddingless for="perPage" label="">
    <div class="flex items-center space-x-2 sm:space-x-3">
        <label for="perPage" class="text-sm font-medium text-gray-700">Per Page</label>
        <select wire:model.live="perPage" id="perPage"
                class="w-20 text-center rounded-md border border-gray-300 bg-white text-sm text-gray-700 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>
</x-Ui::input.group>


