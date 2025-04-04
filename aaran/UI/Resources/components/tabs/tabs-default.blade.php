<div x-data="{ selectedTab: 'groups' }" class="w-full">
    <div @keydown.right.prevent="$focus.wrap().next()" @keydown.left.prevent="$focus.wrap().previous()" class="flex gap-2 overflow-x-auto border-b border-slate-300 dark:border-slate-700" role="tablist" aria-label="tab options">
        <button @click="selectedTab = 'groups'" :aria-selected="selectedTab === 'groups'" :tabindex="selectedTab === 'groups' ? '0' : '-1'" :class="selectedTab === 'groups' ? 'font-bold text-blue-700 border-b-2 border-blue-700 dark:border-blue-600 dark:text-blue-600' : 'text-slate-700 font-medium dark:text-slate-300 dark:hover:border-b-slate-300 dark:hover:text-white hover:border-b-2 hover:border-b-slate-800 hover:text-black'" class="h-min px-4 py-2 text-sm" type="button" role="tab" aria-controls="tabpanelGroups" >Groups</button>
        <button @click="selectedTab = 'likes'" :aria-selected="selectedTab === 'likes'" :tabindex="selectedTab === 'likes' ? '0' : '-1'" :class="selectedTab === 'likes' ? 'font-bold text-blue-700 border-b-2 border-blue-700 dark:border-blue-600 dark:text-blue-600' : 'text-slate-700 font-medium dark:text-slate-300 dark:hover:border-b-slate-300 dark:hover:text-white hover:border-b-2 hover:border-b-slate-800 hover:text-black'" class="h-min px-4 py-2 text-sm" type="button" role="tab" aria-controls="tabpanelLikes" >Likes</button>
        <button @click="selectedTab = 'comments'" :aria-selected="selectedTab === 'comments'" :tabindex="selectedTab === 'comments' ? '0' : '-1'" :class="selectedTab === 'comments' ? 'font-bold text-blue-700 border-b-2 border-blue-700 dark:border-blue-600 dark:text-blue-600' : 'text-slate-700 font-medium dark:text-slate-300 dark:hover:border-b-slate-300 dark:hover:text-white hover:border-b-2 hover:border-b-slate-800 hover:text-black'" class="h-min px-4 py-2 text-sm" type="button" role="tab" aria-controls="tabpanelComments" >Comments</button>
        <button @click="selectedTab = 'saved'" :aria-selected="selectedTab === 'saved'" :tabindex="selectedTab === 'saved' ? '0' : '-1'" :class="selectedTab === 'saved' ? 'font-bold text-blue-700 border-b-2 border-blue-700 dark:border-blue-600 dark:text-blue-600' : 'text-slate-700 font-medium dark:text-slate-300 dark:hover:border-b-slate-300 dark:hover:text-white hover:border-b-2 hover:border-b-slate-800 hover:text-black'" class="h-min px-4 py-2 text-sm" type="button" role="tab" aria-controls="tabpanelSaved" >Saved</button>
    </div>
    <div class="px-2 py-4 text-slate-700 dark:text-slate-300">
        <div x-show="selectedTab === 'groups'" id="tabpanelGroups" role="tabpanel" aria-label="groups">
            <div><b><a href="#" class="underline">Groups</a></b> tab is selected</div>
            <div>
                <x-interactions.download />
            </div>
        </div>
        <div x-show="selectedTab === 'likes'" id="tabpanelLikes" role="tabpanel" aria-label="likes">
            <div><b><a href="#" class="underline">Likes</a></b> tab is selected</div>
            <div>
                <x-interactions.download />
            </div>
        </div>
        <div x-show="selectedTab === 'comments'" id="tabpanelComments" role="tabpanel" aria-label="comments">
            <div><b><a href="#" class="underline">Comments</a></b> tab is selected</div>
            <div>
                <x-interactions.download />
            </div>
        </div>
        <div x-show="selectedTab === 'saved'" id="tabpanelSaved" role="tabpanel" aria-label="saved">
            <div><b><a href="#" class="underline">Saved</a></b> tab is selected</div>
            <div>
                <x-interactions.download />
            </div>
        </div>
    </div>
</div>
