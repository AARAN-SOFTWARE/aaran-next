<!-- Tabs -->
<div
    x-data="{
        selectedId: null,
        init() {
            // Set the first available tab on the page on page load.
            this.$nextTick(() => this.select(this.$id('tab', 1)))
        },
        select(id) {
            this.selectedId = id
        },
        isSelected(id) {
            return this.selectedId === id
        },
        whichChild(el, parent) {
            return Array.from(parent.children).indexOf(el) + 1
        }
    }"
    x-id="['tab']"
    class="mx-auto w-full"
>
    <!-- Tab List -->
    <ul
        x-ref="tablist"
        @keydown.right.prevent.stop="$focus.wrap().next()"
        @keydown.home.prevent.stop="$focus.first()"
        @keydown.page-up.prevent.stop="$focus.first()"
        @keydown.left.prevent.stop="$focus.wrap().prev()"
        @keydown.end.prevent.stop="$focus.last()"
        @keydown.page-down.prevent.stop="$focus.last()"
        role="tablist"
        class="-mb-px flex items-stretch  overflow-x-auto border rounded-t-lg"
    >
        <!-- Tab -->

        @if(isset($tabs))
            {{$tabs}}
        @endif

    </ul>
    <div class=" border-b   border-gray-200 shadow-md"></div>

    <!-- Panels -->
    <div role="tabpanel" class=" border-l border-r border-b border-gray-200 bg-white text-xs font-lex">

        <!-- Content -->

        @if(isset($content))
            {{$content}}
        @endif

    </div>
</div>
