<header class="flex  items-center sm:px-4 px-1 py-3 text-semibold text-gray-800  border-b
shadow-md print:hidden">

    <div class="w-full sm:px-2 px-0 flex flex-row  justify-between items-center">

        <div
            class="w-3/12 flex sm:flex-row flex-col sm:justify-start sm:space-x-4
            items-center sm:space-y-1.5 space-y-3">
            <div class="p-1 cursor-pointer hover:bg-gray-200 self-start hover:rounded-sm"
                 @click="sidebarOpen = !sidebarOpen">

                <svg class="sm:h-8 sm:w-8 w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': sidebarOpen, 'inline-flex': ! sidebarOpen }" class="inline-flex"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': ! sidebarOpen, 'inline-flex': sidebarOpen }" class="hidden"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>

            </div>
            <!-- Page Heading -->
            <div
                class=" font-semibold sm:text-xl text-md text-gray-800 leading-tight sm:px-0 px-2 mt-2 self-start">

                {{$slot ?? 'Dashboard'}}
            </div>
        </div>
        <div class="w-5/12 flex sm:flex-row flex-col sm:justify-end justify-evenly items-center space-y-1">
            <div class="flex max-w-max justify-center items-center">

                <a role="button" href="{{route('switch-default-company')}}"
                        class="text-gray-600 bg-white focus:outline-none hover:bg-gray-100 font-semibold sm:px-2 px-0.5 sm:py-2 py-1 rounded-lg text-xs cursor-pointer">
                    {{session()->get('company_name') ?:'Select Company' }}
{{--                    &nbsp;-&nbsp;{{ \Aaran\Assets\Enums\Acyear::tryFrom(session()->get('acyear_id'))->getName()}}--}}
                </a>

            </div>

            {{-- login menu--}}
            <div class="sm:flex sm:items-center ">
                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-Ui::jet.dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @auth
                                {{--                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())--}}
                                {{--                                    <button--}}
                                {{--                                        class="flex sm:text-sm text-xs border-2 border-gray-300 rounded-full--}}
                                {{--                                        focus:outline-none focus:border-gray-300 transition">--}}
                                {{--                                        <img class="h-10 w-10 rounded-full object-cover"--}}
                                {{--                                             src="{{ Auth::user()->profile_photo_url }}"--}}
                                {{--                                             alt="{{ Auth::user()->name }}"/>--}}
                                {{--                                    </button>--}}
                                {{--                                @else--}}
                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                            class="inline-flex items-center sm:px-3 px-1 sm:py-2 py-1 border border-gray-300 sm:text-sm text-xs
                                            leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                        {{ Auth::user()->name }}
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                             viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </span>
                                {{--                                @endif--}}
                            @endauth
                        </x-slot>


                        <x-slot name="content">

                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-Ui::jet.dropdown-link
                                {{--                                href="{{ route('profile.show') }}"--}}
                            >
                                {{ __('Profile') }}
                            </x-Ui::jet.dropdown-link>

                            {{--                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())--}}
                            {{--                                <x-dropdown-link href="{{ route('api-tokens.index') }}">--}}
                            {{--                                    {{ __('API Tokens') }}--}}
                            {{--                                </x-Ui::jet.dropdown-link>--}}
                            {{--                            @endif--}}

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-Ui::jet.dropdown-link href="{{ route('logout') }}"
                                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-Ui::jet.dropdown-link>
                            </form>
                        </x-slot>
                    </x-Ui::jet.dropdown>
                </div>
            </div>

            {{-- login menu--}}

        </div>

    </div>
</header>
