@props([
    'transactions' => [
        'total_purchase' => 234,
        'month_purchase' => 1212,
        'total_receivable' => 234,
        'month_receivable' => 234,
        'total_payable' => 2433,
        'month_payable' => 543,
    ]
])

<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    @foreach ([
        ['title' => 'Purchase', 'color' => '#845ADF', 'total' => $transactions['total_purchase'], 'monthly' => $transactions['month_purchase'], 'route' => 'dashboard'],
        ['title' => 'Receivables', 'color' => '#F5B849', 'total' => $transactions['total_receivable'], 'monthly' => $transactions['month_receivable'], 'route' => 'dashboard'],
        ['title' => 'Payables', 'color' => '#E6533C', 'total' => $transactions['total_payable'], 'monthly' => $transactions['month_payable'], 'route' => 'dashboard'],
        ['title' => 'Payables', 'color' => '#E6533C', 'total' => $transactions['total_payable'], 'monthly' => $transactions['month_payable'], 'route' => 'dashboard']
    ] as $card)
        <div
            class="bg-white rounded-md border-t-2 border-[{{ $card['color'] }}] flex flex-col justify-evenly shadow-md">
            <div class="flex flex-row justify-between items-center pt-5 px-5">
                <div class="space-y-2">
                    <div class="text-md font-semibold">{{ $card['title'] }}</div>
                    <div class="sm:text-2xl text-md text-[{{ $card['color'] }}] font-semibold">
                        {{ $card['total'] }}
                    </div>
                </div>
                <div class="w-16 h-16">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" fill="{{ $card['color'] }}"/>
                    </svg>
                </div>
            </div>
            <div class="flex flex-row justify-between items-center pb-5 px-5">
                <div class="text-md font-semibold">
                    <div class="text-gray-500">This month</div>
                    <div class="text-[{{ $card['color'] }}]">
                        {{ $card['monthly'] }}
                    </div>
                </div>
                <div>
                    <a href="{{ route($card['route']) }}"
                       class="text-[{{ $card['color'] }}] text-sm hover:bg-opacity-10 hover:bg-[{{ $card['color'] }}] px-3 py-1 rounded-md font-semibold inline-flex items-center gap-x-2">
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
