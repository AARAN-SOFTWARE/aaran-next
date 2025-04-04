<li>
    <button
        x-data @keydown.tab.stop
        :id="$id('tab', whichChild($el.parentElement, $refs.tablist))"
        @click="select($el.id)"
        @mousedown.prevent
        @focus="select($el.id)"
        type="button"
        :tabindex="isSelected($el.id) ? 0 : -1"
        :aria-selected="isSelected($el.id)"
        :class="isSelected($el.id) ? ' border-blue-500 ' : 'border-transparent'"
        class="inline-flex rounded-t-sm border-b-2 mx-0.5  px-5 py-3 font-merri text-xs text-gray-400 tracking-wider"
        role="tab"
    >
        {{$slot}}
    </button>
</li>
