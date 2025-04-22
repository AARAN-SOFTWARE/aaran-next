@props([
'entries' => null
])

<div class="sm:w-4/12 w-auto bg-white  rounded-lg flex-col flex h-[28rem] shadow-md">

    <div class="w-full h-[4rem] py-3 border-b border-gray-200 inline-flex items-center justify-between px-8">
        <span class="inline-flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                 class="size-4 text-cyan-500">
                <path fill-rule="evenodd"
                      d="M3.75 3.375c0-1.036.84-1.875 1.875-1.875H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375Zm10.5 1.875a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Zm-4.5 5.25a.75.75 0 0 0 0 1.5h.375c.769 0 1.43.463 1.719 1.125H9.75a.75.75 0 0 0 0 1.5h2.094a1.875 1.875 0 0 1-1.719 1.125H9.75a.75.75 0 0 0-.53 1.28l2.25 2.25a.75.75 0 0 0 1.06-1.06l-1.193-1.194a3.382 3.382 0 0 0 2.08-2.401h.833a.75.75 0 0 0 0-1.5h-.834A3.357 3.357 0 0 0 12.932 12h1.318a.75.75 0 0 0 0-1.5H10.5c-.04 0-.08.003-.12.01a3.425 3.425 0 0 0-.255-.01H9.75Z"
                      clip-rule="evenodd"/>
            </svg>
            <span class="font-semibold text-lg font-lex">Recent Entries</span>
        </span>
    </div>

    <div class="flex-col flex h-[24rem] px-2 overflow-y-auto">

        <a href="{{route('sales')}}">
            <x-Ui::web.dashboard.entries_list
                entry="Sales"
                date="{{$entries['sales_date']}}"
                invoice="Bill No: {{$entries['sales_no']}}"
                amount="{{$entries['sales']}}"
                color="text-[#23B7E5]"
            >
                <x-Ui::icons.sales/>
            </x-Ui::web.dashboard.entries_list>
        </a>

        <a
            href="{{route('purchases')}}"
        >
            <x-Ui::web.dashboard.entries_list
                entry="Purchase"
                date="{{$entries['purchase_date']}}"
                invoice="Bill No: {{$entries['purchase_no']}}"
                amount="{{$entries['purchase']}}"
                color="text-[#845ADF]"
            >
                <x-Ui::icons.purchase/>
            </x-Ui::web.dashboard.entries_list>
        </a>

        <a
            href="{{route('transactions',[1])}}"
        >
            <x-Ui::web.dashboard.entries_list
                entry="Receipt"
                date="{{$entries['receipt_date']}}"
                invoice="Vch No: {{$entries['receipt_no']}}"
                amount="{{$entries['receipt']}}"
                color="text-[#F5B849]"
            >
                <x-Ui::icons.receipt/>
            </x-Ui::web.dashboard.entries_list>
        </a>

        <a
            href="{{route('transactions',[2])}}"
        >
            <x-Ui::web.dashboard.entries_list
                entry="Payment"
                date="{{$entries['payment_date']}}"
                invoice="Vch No: {{$entries['payment_no']}}"
                amount="{{$entries['payment']}}"
                color="text-[#E6533C]"
            >
                <x-Ui::icons.payment/>
            </x-Ui::web.dashboard.entries_list>
        </a>

    </div>

</div>
