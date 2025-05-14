@php
    $menuItems = [
        'home' => 'Home',
        'abouts' => 'About',
        'blogs' => 'Blog',
//        'services' => 'Services',
        'projects'=>'Products',
        'web-contacts' => 'Contact'
    ];
@endphp

<nav x-data="{ mobileMenuIsOpen: false }" @click.away="mobileMenuIsOpen = false" id="navBar"
     class="sm:fixed sm:z-40 sm:w-full flex items-center justify-between border-b border-neutral-300 px-6 py-4 dark:border-neutral-700 text-black transition-colors duration-300">

    <!-- Brand Logo -->
    <a href="#" class="text-3xl flex flex-row shrink-0 items-center hover:scale-105 transition duration-500">
        <h1 class="hover:tracking-wide text-orange-400 hover:font-semibold">
            CODEX<span class="text-neutral-600">SUN</span>
        </h1>
    </a>

    <!-- Desktop Menu -->
    <ul class="hidden md:flex items-center gap-16">
        @foreach ($menuItems as $route => $label)
            <li class="hover:tracking-wide hover:font-bold transition duration-1000">
                <a href="{{ route($route) }}" class="menu-text dark:text-black dark:hover:text-black"
                   wire:navigate>{{ $label }}</a>
            </li>
        @endforeach
        @auth
            <li class="hover:tracking-wide hover:font-bold transition duration-1000">
                <a href="{{ route('dashboard') }}" class="menu-text dark:text-neutral-300 dark:hover:text-white"
                   wire:navigate>Dashboard</a>
            </li>

            <li class="hover:tracking-wide hover:font-bold transition duration-1000">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="menu-text dark:text-neutral-300 dark:hover:text-white" wire:navigate>Logout</a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        @else
            <li class="hover:tracking-wide hover:font-bold transition duration-1000">
                <a href="{{ route('login') }}" class="menu-text dark:text-black dark:hover:text-black"
                   wire:navigate>Login</a>
            </li>
        @endauth
    </ul>

    <!-- Mobile Menu Button -->
    <button @click="mobileMenuIsOpen = !mobileMenuIsOpen" :aria-expanded="mobileMenuIsOpen"
            :class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-50' : null" type="button"
            class="flex text-neutral-600 dark:text-neutral-300 md:hidden" aria-label="mobile menu"
            aria-controls="mobileMenu">
        <svg x-cloak x-show="!mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true"
             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
        </svg>
        <svg x-cloak x-show="mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true"
             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
        </svg>
    </button>
    <!-- Mobile Menu -->
    <ul x-cloak x-show="mobileMenuIsOpen"
        x-transition:enter="transition motion-reduce:transition-none ease-out duration-300"
        x-transition:enter-start="-translate-y-full"
        x-transition:enter-end="translate-y-0"
        x-transition:leave="transition motion-reduce:transition-none ease-out duration-300"
        x-transition:leave-start="translate-y-0" x-transition:leave-end="-translate-y-full" id="mobileMenu"
        class="fixed max-h-svh overflow-y-auto inset-x-0 top-0 z-20 flex flex-col divide-y divide-neutral-300 rounded-b-md border-b border-neutral-300
        bg-neutral-50 px-6 pb-6 pt-20 dark:divide-neutral-700 dark:border-neutral-700 dark:bg-neutral-900 md:hidden">

        <li class="py-2"><a href="{{route('home')}}"
                            class="w-full text-sm font-bold text-neutral-600 focus:underline dark:text-neutral-300 "
                            wire:navigate
            >Home</a></li>
        <li class="py-2"><a href="{{route('abouts')}}"
                            class="w-full text-sm font-medium text-neutral-600 focus:underline dark:text-neutral-300"
                            wire:navigate>About</a>
        </li>
        <li class="py-2"><a href="{{route('blogs')}}"
                            class="w-full text-sm font-medium text-neutral-600 focus:underline dark:text-neutral-300"
                            wire:navigate>Blog</a>
        </li>
{{--        <li class="py-2"><a href="{{route('services')}}"--}}
{{--                            class="w-full text-sm font-medium text-neutral-600 focus:underline dark:text-neutral-300"--}}
{{--                            wire:navigate>Services</a>--}}
{{--        </li>--}}
        <li class="py-2"><a href="{{route('projects')}}"
                            class="w-full text-sm font-medium text-neutral-600 focus:underline dark:text-neutral-300"
                            wire:navigate>Products</a>
        </li>
        <li class="py-2"><a href="{{route('web-contacts')}}"
                            class="w-full text-sm font-medium text-neutral-600 focus:underline dark:text-neutral-300"
                            wire:navigate>Contact</a>
        </li>
        @if (Route::has('login'))
            @auth
                <li class="py-2"><a href="{{route('dashboard')}}"
                                    class="w-full text-sm font-medium text-neutral-600 focus:underline dark:text-neutral-300"
                                    wire:navigate>Dashboard</a>
                </li>
                <li class="py-2"><a href="{{route('logout')}}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="w-full text-sm font-medium text-neutral-600 focus:underline dark:text-neutral-300"
                                    wire:navigate>Logout</a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                    @csrf
                </form>
            @else
                <li class="py-2"><a href="{{route('login')}}"
                                    class="w-full text-sm font-medium text-neutral-600 focus:underline dark:text-neutral-300"
                                    wire:navigate>Login</a>
                </li>
            @endauth
        @endif
    </ul>


</nav>

<script>
    window.onscroll = () => {
        const navBar = document.getElementById("navBar");
        const menuText = document.querySelectorAll(".menu-text");
        if (document.documentElement.scrollTop > 100) {
            navBar.classList.add("sticky-header");
            menuText.forEach(el => el.classList.add("text-black"));
        } else {
            navBar.classList.remove("sticky-header");
            menuText.forEach(el => el.classList.remove("text-black"));
        }
    };
</script>

<style>
    .sticky-header {
        background-color: white !important;
        color: black !important;
        transition: background-color 0.3s ease-out, color 0.3s ease-out;
    }

    .menu-text-mobile {
        @apply text-sm font-medium text-neutral-600 dark:text-neutral-300 focus:underline;
    }
</style>
