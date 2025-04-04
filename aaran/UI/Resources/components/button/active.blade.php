<div class="mt-2">
    <label for="active_id" class="inline-flex relative items-center cursor-pointer">
        <input type="checkbox" id="active_id" class="sr-only peer"
               wire:model="active_id" checked>
        <span
            class="w-10 h-5 bg-gray-200 rounded-full peer peer-focus:ring-2
                                        peer-focus:ring-blue-300
                                         peer-checked:after:translate-x-full peer-checked:after:border-white
                                         after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300
                                         after:border after:rounded-full after:h-4 after:w-4 after:transition-all
                                         peer-checked:bg-blue-600"></span>
        <span class="ml-3 sm:text-sm text-xs font-medium text-gray-900">Active</span>
    </label>
</div>

