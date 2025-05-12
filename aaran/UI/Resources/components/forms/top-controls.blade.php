@props([
'showFilters'=>false,
])

<div class="flex sm:flex-row sm:justify-between sm:items-center  flex-col gap-6 py-4 print:hidden">
    <div class="w-2/4 flex items-center space-x-2">

        <x-Ui::input.search-bar wire:model.live="searches"
                            wire:keydown.escape="$set('searches', '')" label="Search"/>
        <x-Ui::input.toggle-filter :show-filters="$showFilters"/>
    </div>

    <div class="flex sm:justify-center justify-between items-center gap-6">
        <x-Ui::forms.per-page/>
        <div class="self-end">
            <x-Ui::newtemplate.dynamic-button :button-label="'New'" wire:click="create"/>
        </div>
    </div>
</div>
<x-Ui::input.advance-search :show-filters="$showFilters"/>
