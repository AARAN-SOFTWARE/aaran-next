<!-- Search -->
<div class="relative flex w-full flex-col gap-1 text-slate-700 dark:text-slate-300">

    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
         aria-hidden="true"
         class="absolute left-2.5 top-1/2 size-5 -translate-y-1/2 text-slate-700/50 dark:text-slate-300/50">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
    </svg>

    <input {{$attributes}} type="search" name="search" placeholder="Search" aria-label="search"
           class="w-full rounded-xl border border-slate-300 bg-slate-50 py-2.5 pl-10 pr-2 text-sm
           focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2
           disabled:cursor-not-allowed disabled:opacity-75 dark:border-slate-700
           dark:bg-slate-800/50 dark:focus-visible:outline-blue-600"/>
</div>
