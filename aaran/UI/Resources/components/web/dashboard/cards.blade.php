@props([
    'transactions'
])

@php
    $cards = [
        [
            'title' => 'Purchase',
            'icon' => 'bag-hand',
            'text_color' => 'text-violet-500',
            'icon_color' => 'bg-violet-500/20',
            'border_color' => 'border-violet-500',
            'hover_color' => 'hover:bg-violet-500/10',
            'total' => $transactions['total_purchase'],
            'monthly' => $transactions['month_purchase'],
            'route' => 'purchases',
        ],
        [
            'title' => 'Receivables',
            'icon' => 'cash',
            'text_color' => 'text-yellow-600',
            'icon_color' => 'bg-yellow-400/30',
            'border_color' => 'border-yellow-400',
            'hover_color' => 'hover:bg-yellow-400/20',
            'total' => $transactions['total_receivable'],
            'monthly' => $transactions['month_receivable'],
            'route' => 'sales',
        ],
        [
            'title' => 'Payables',
            'icon' => 'book',
            'text_color' => 'text-red-400',
            'icon_color' => 'bg-red-400/30',
            'border_color' => 'border-red-400',
            'hover_color' => 'hover:bg-red-400/20',
            'total' => $transactions['total_payable'],
            'monthly' => $transactions['month_payable'],
            'route' => 'purchases',
        ],
        [
            'title' => 'Profit',
            'icon' => 'sparkles',
            'text_color' => 'text-green-400',
            'icon_color' => 'bg-green-400/30',
            'border_color' => 'border-green-400',
            'hover_color' => 'hover:bg-green-400/20',
            'total' => $transactions['net_profit'],
            'monthly' => $transactions['month_profit'],
            'route' => 'sales',
        ],
    ];
@endphp



<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    @foreach ($cards as $card)
        <div
            class="bg-white rounded-md border-t-2 {{ $card['border_color'] }} flex flex-col justify-evenly shadow-md">
            <div class="flex flex-row justify-between items-center px-5">
                <div class="space-y-2">
                    <div class="text-md font-semibold">{{ $card['title'] }}</div>
                    <div class="sm:text-2xl text-md  {{ $card['text_color'] }} font-semibold">
                        {{ $card['total'] }}
                    </div>
                </div>
                <div class="flex items-center justify-center w-14 h-14 rounded-full {{$card['icon_color']}}">
                    <x-Ui::icons.icon :icon="$card['icon']" class="w-8 h-auto  {{ $card['text_color'] }}"/>
                </div>
            </div>

            <div class="flex flex-row justify-between items-center pb-5 px-5">
                <div class="text-md font-semibold">
                    <div class="text-gray-500">This month</div>
                    <div class=" {{ $card['text_color'] }}">
                        {{ $card['monthly'] }}
                    </div>
                </div>
                <div>
                    <a href="{{ route($card['route']) }}"
                       class=" {{ $card['text_color'] }} text-sm hover:bg-opacity-10 {{ $card['hover_color'] }} px-3 py-1 rounded-md font-semibold inline-flex items-center gap-x-2">
                        <span>View All</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
