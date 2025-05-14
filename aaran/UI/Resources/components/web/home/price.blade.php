@php
    $plans = [
        [
            'id' => 'starter',
            'title' => 'Starter',
            'price' => '$9',
            'description' => 'Good for anyone who is self-employed and just getting started.',
            'features' => [
                'Send 10 quotes and invoices',
                'Connect up to 2 bank accounts',
                'Track up to 15 expenses per month',
                'Manual payroll support',
                'Export up to 3 reports',
            ],
            'highlighted' => false,
        ],
        [
             'id' => 'smallbusiness',
            'title' => 'Small Business',
            'price' => '$19',
            'description' => 'Ideal for growing businesses needing more features.',
            'features' => [
                'Send 50 quotes and invoices',
                'Connect up to 5 bank accounts',
                'Track unlimited expenses',
                'Automated payroll support',
                'Export up to 10 reports',
            ],
            'highlighted' => true,
        ],
        [
             'id' => 'enterprise',
            'title' => 'Enterprise',
            'price' => '$49',
            'description' => 'Best for teams and enterprises with advanced needs.',
            'features' => [
                'Unlimited quotes and invoices',
                'Unlimited bank connections',
                'Advanced expense tracking',
                'Full payroll automation',
                'Unlimited reporting & analytics',
            ],
            'highlighted' => false,
        ],
        [
             'id' => 'elite',
            'title' => 'Elite',
            'price' => '$49+',
            'description' => 'Best for teams and enterprises with advanced needs.',
            'features' => [
                'Full Customizable',
                'Unlimited quotes and invoices',
                'Unlimited bank connections',
                'Advanced expense tracking',
                'Full payroll automation',
                'Unlimited reporting & analytics',
            ],
            'highlighted' => true,
        ],
    ];
@endphp

<section id="pricing" aria-label="Pricing" class="bg-slate-900 py-10 sm:py-12">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="md:text-center">
            <h2 class="font-display text-3xl tracking-tight text-white sm:text-4xl text-center"><span
                    class="relative whitespace-nowrap"><svg aria-hidden="true" viewBox="0 0 281 40"
                                                            preserveAspectRatio="none"
                                                            class="absolute top-1/2 left-0 h-[1em] w-full fill-blue-500"><path
                            fill-rule="evenodd" clip-rule="evenodd"
                            d="M240.172 22.994c-8.007 1.246-15.477 2.23-31.26 4.114-18.506 2.21-26.323 2.977-34.487 3.386-2.971.149-3.727.324-6.566 1.523-15.124 6.388-43.775 9.404-69.425 7.31-26.207-2.14-50.986-7.103-78-15.624C10.912 20.7.988 16.143.734 14.657c-.066-.381.043-.344 1.324.456 10.423 6.506 49.649 16.322 77.8 19.468 23.708 2.65 38.249 2.95 55.821 1.156 9.407-.962 24.451-3.773 25.101-4.692.074-.104.053-.155-.058-.135-1.062.195-13.863-.271-18.848-.687-16.681-1.389-28.722-4.345-38.142-9.364-15.294-8.15-7.298-19.232 14.802-20.514 16.095-.934 32.793 1.517 47.423 6.96 13.524 5.033 17.942 12.326 11.463 18.922l-.859.874.697-.006c2.681-.026 15.304-1.302 29.208-2.953 25.845-3.07 35.659-4.519 54.027-7.978 9.863-1.858 11.021-2.048 13.055-2.145a61.901 61.901 0 0 0 4.506-.417c1.891-.259 2.151-.267 1.543-.047-.402.145-2.33.913-4.285 1.707-4.635 1.882-5.202 2.07-8.736 2.903-3.414.805-19.773 3.797-26.404 4.829Zm40.321-9.93c.1-.066.231-.085.29-.041.059.043-.024.096-.183.119-.177.024-.219-.007-.107-.079ZM172.299 26.22c9.364-6.058 5.161-12.039-12.304-17.51-11.656-3.653-23.145-5.47-35.243-5.576-22.552-.198-33.577 7.462-21.321 14.814 12.012 7.205 32.994 10.557 61.531 9.831 4.563-.116 5.372-.288 7.337-1.559Z"></path></svg><span
                        class="relative">Simple pricing,</span></span> <!-- -->for everyone.
            </h2>
            <p class="mt-4 text-lg text-center mb-5 text-slate-400">
                It doesn’t matter what size your business is, our software won’t work well for you.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4 px-6 sm:px-8 lg:py-8">
            @foreach ($plans as $plan)
                @php
                    $containerClasses = $plan['highlighted']
                        ? 'bg-gradient-to-br from-indigo-700 to-indigo-900 ring-2 ring-indigo-500 shadow-2xl text-white'
                        : 'bg-slate-800 text-slate-100';
                @endphp

                <section class="flex flex-col rounded-3xl p-6 {{ $containerClasses }}">
                    @if ($plan['highlighted'])
                        <span class="mb-3 inline-block self-start rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-indigo-200">
                            Most Popular
                        </span>
                    @endif

                    <div class="text-5xl font-light tracking-tight">{{ $plan['price'] }}</div>
                    <div class="mt-5 text-lg font-semibold">{{ $plan['title'] }}</div>
                    <p class="mt-2 text-base text-slate-300">{{ $plan['description'] }}</p>

                    <a href="{{route('billing',$plan['id'])}}"
                       class="mt-8 inline-flex items-center justify-center rounded-full border {{$plan['highlighted']?'bg-white text-gray-900 hover:text-white ':' '}}  border-white py-2 px-4 text-sm hover:bg-white/10">
                        Start my free trial
                    </a>

                    <ul class="mt-10 space-y-3 text-sm text-inherit">
                        @foreach ($plan['features'] as $feature)
                            <li class="flex items-start">
                                <svg class="h-6 w-6 flex-none fill-current stroke-current text-slate-400"
                                     viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4" stroke-width="2" fill="none" stroke="currentColor"/>
                                </svg>
                                <span class="ml-4">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endforeach
        </div>
    </div>
   <div class="text-center my-4 border py-4 border-x-0 border-y-gray-800 cursor-pointer" href="{{route('plan-comparison')}}" wire:navigate>Explore All plans</div>
</section>
