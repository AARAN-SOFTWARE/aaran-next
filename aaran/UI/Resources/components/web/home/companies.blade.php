<div>
    @php
        $logos = [
            'sk-logo.jpeg',
            'sk-logo.jpeg',
             'sk-logo.jpeg',
        ];
    @endphp

    <div class="mx-auto max-w-7xl text-center py-8">
        <div class="mt-8">
            <p class="font-display text-base text-slate-900">
                Trusted by these companies so far
            </p>
            <ul
                role="list"
                class="mt-8 flex flex-wrap items-center justify-center gap-8 sm:flex-col sm:gap-y-6 xl:flex-row xl:gap-x-12 xl:gap-y-0"
            >
                @foreach ($logos as $logo)
                    <li class="flex h-fit">
                        <img
                            src="{{ asset('images/logo/' . $logo) }}"
                            alt="Company Logo"
                            class="h-16 w-auto object-contain"
                        />
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
