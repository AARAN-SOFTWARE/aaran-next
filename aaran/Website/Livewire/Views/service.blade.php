{{--<div>--}}
{{--    <div class="relative" x-data="{ open: false }">--}}

{{--        <x-Ui::web.home-new.items.banner--}}
{{--            label="Services"--}}
{{--            desc=" We Design and develop Outstanding Digital products and digital ---}}
{{--                first Brands"--}}
{{--            padding="sm:px-[175px]"--}}
{{--            padding_mob="px-[70px]"--}}
{{--        />--}}
{{--        <x-Ui::web.services.pricing />--}}
{{--        <x-Ui::web.services.terms />--}}
{{--        <x-Ui::web.services.faq />--}}
{{--        <x-Ui::web.home-new.footer/>--}}
{{--        <x-Ui::web.home-new.copyright/>--}}

{{--        --}}{{--    <div x-show="open" x-transition--}}
{{--        --}}{{--         class="sm:fixed top-24 right-8 font-roboto w-96 h-[36rem] tracking-wider rounded-md shadow-md shadow-gray-500">--}}
{{--        --}}{{--        <div class="h-1/4 bg-[#3F5AF3] text-xs rounded-t-md">--}}
{{--        --}}{{--            <div class="text-white p-3 w-1/2 mx-auto h-auto flex-col flex justify-center items-center gap-y-2">--}}
{{--        --}}{{--                <div class="max-w-max inline-flex items-center gap-2 px-2 py-1 rounded-md text-white bg-[#091d90]">--}}
{{--        --}}{{--                    <x-icons.icon icon="message-round" class="w-5 h-5"/>--}}
{{--        --}}{{--                    <span>chat</span>--}}
{{--        --}}{{--                </div>--}}
{{--        --}}{{--                <div class="flex">--}}
{{--        --}}{{--                    <img src="../../../../images/t1.webp" alt="" class="w-10 h-10 rounded-full">--}}
{{--        --}}{{--                    <img src="../../../../images/t3.webp" alt="" class="w-10 h-10 rounded-full">--}}
{{--        --}}{{--                    <img src="../../../../images/t4.webp" alt="" class="w-10 h-10 rounded-full">--}}
{{--        --}}{{--                    <img src="../../../../images/t5.webp" alt="" class="w-10 h-10 rounded-full">--}}
{{--        --}}{{--                </div>--}}
{{--        --}}{{--                <div class="">Questions? Chat with us!</div>--}}
{{--        --}}{{--                <div>Was last active 3 hours ago</div>--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        </div>--}}
{{--        --}}{{--        <div class="relative h-3/4 flex-col flex text-xs py-4 gap-2 px-2 bg-blue-50 rounded-b-md justify-between">--}}
{{--        --}}{{--            <div class="flex gap-2">--}}
{{--        --}}{{--                <div><img src="../../../../images/t1.webp" alt="" class="w-12 h-12 rounded-full"></div>--}}
{{--        --}}{{--                <div class="flex flex-col gap-2">--}}
{{--        --}}{{--                    <div class="text-gray-600 text-xs">User</div>--}}
{{--        --}}{{--                    <div class="text-white bg-[#3F5AF3] px-2 py-1 rounded-md">Lorem ipsum dolor sit amet, consectetur--}}
{{--        --}}{{--                        adipisicing elit.--}}
{{--        --}}{{--                    </div>--}}
{{--        --}}{{--                </div>--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--            <div class="w-full">--}}
{{--        --}}{{--                <input type="text" class="w-full border-0 focus:ring-0 bg-blue-100 py-2 placeholder-gray-400 text-xs rounded-md" placeholder="Post your message">--}}
{{--        --}}{{--            </div>--}}
{{--        --}}{{--        </div>--}}
{{--        --}}{{--    </div>--}}

{{--        --}}{{--    <button x-show="open" x-transition x-on:click="open = ! open"--}}
{{--        --}}{{--            class="sm:fixed bottom-8 right-8 bg-[#3F5AF3] text-white rounded-full inline-flex justify-center items-center w-12 h-12 shadow-md shadow-gray-500">--}}
{{--        --}}{{--        <x-icons.icon icon="x-mark" class="w-10 h-10 "/>--}}
{{--        --}}{{--    </button>--}}

{{--        <style>--}}
{{--            .tab-button.active {--}}
{{--                background-color: #3F5AF3;--}}
{{--                border-color: white;--}}
{{--                color: white;--}}
{{--            }--}}
{{--        </style>--}}
{{--    </div>--}}


{{--    <script>--}}
{{--        function showTab(tabId) {--}}
{{--            const tabContents = document.querySelectorAll('.tab-content');--}}
{{--            tabContents.forEach((content) => {--}}
{{--                content.classList.add('hidden');--}}
{{--            });--}}

{{--            const selectedTab = document.getElementById(tabId);--}}
{{--            if (selectedTab) {--}}
{{--                selectedTab.classList.remove('hidden');--}}
{{--            }--}}


{{--            const tabButtons = document.querySelectorAll('.tab-button');--}}
{{--            tabButtons.forEach((button) => {--}}
{{--                button.classList.remove('active');--}}
{{--            });--}}

{{--            const clickedButton = document.querySelector(`[onclick="showTab('${tabId}')"]`);--}}
{{--            if (clickedButton) {--}}
{{--                clickedButton.classList.add('active');--}}
{{--            }--}}
{{--        }--}}

{{--        showTab('tab1');--}}
{{--    </script>--}}

{{--</div>--}}
<style>
    img{
        height: 20px;
        display: block;
        margin-top: auto;
        margin-bottom: auto;
    }
</style>

<div>
    <div class="bg-white-500 text-black">
        <div class="flex justify-between items-center w-full ">
            <h1 class="text-left text-3xl font-bold ml-4">SUBSCRIPTION</h1>

            <div class="absolute left-1/2 transform rounded-2xl p-1 -translate-x-1/2 bg-white">
                <button id="annualbutton" onclick="chooseDuration('annual')" class="p-4 text-xl rounded-2xl bg-black text-white">Annual</button>
                <button id="monthbutton" onclick="chooseDuration('monthly')" class="p-4 text-xl rounded-2xl bg-white text-black">Monthly</button>
            </div>
        </div>
        <div id="annual" class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 p-7">
            <div class="bg-amber-50 mt-4 rounded-3xl p-6 border border-b-8-gray-50">
                <h3 class="text-center text-xl">Basic Plan</h3>
                <div class="flex gap-2 mt-3 p-2 justify-center">
                    <h1 class="text-4xl font-bold">$30</h1>
                    <p>/month (USD) <br> $360 billed Year</p>
                </div>
                <p class="text-center">
                    Get Started with essential tools to manage your team efficiency ideal for teams with fundamental needs.
                </p>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Create and send unlimited invoices</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Track payments and due dates</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Basic customer database</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Email support</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>One user access</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/not available.png') }}" alt="" width="20" height="20">
                    <p>Recurring billing support</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/not available.png') }}" alt="" width="20" height="20">
                    <p>Expense tracking</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/not available.png') }}" alt="" width="20" height="20">
                    <p>Multi-user access (up to 3 users)</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/not available.png') }}" alt="" width="20" height="20">
                    <p>Custom invoice branding</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/not available.png') }}" alt="" width="20" height="20">
                    <p>Role-based access control</p>
                </div>
                <div class="flex justify-center mt-4">
                    <button class="bg-white rounded-4xl p-3">Start 7 Days Free Trial</button>
                </div>

            </div>
            <div class="bg-gray-700 text-white mt-4 rounded-3xl p-6 border border-b-8-amber-50">
                <h3 class="text-center text-xl">Professional Plan</h3>
                <div class="flex gap-2 mt-3 p-2 justify-center">
                    <h1 class="text-4xl font-bold">$30</h1>
                    <p>/month (USD) <br> $360 billed Year</p>
                </div>
                <p class="text-center">
                    Get Started with essential tools to manage your team efficiency ideal for teams with fundamental needs.
                </p>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Create and send unlimited invoices</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Track payments and due dates</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Basic customer database</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Email support</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>One user access</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Recurring billing support</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Expense tracking</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Multi-user access (up to 3 users)</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/not available.png') }}" alt="" width="20" height="20">
                    <p>Custom invoice branding</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/not available.png') }}" alt="" width="20" height="20">
                    <p>Role-based access control</p>
                </div>
                <div class="flex justify-center mt-4">
                    <button class="bg-white text-black rounded-4xl p-3">Start 7 Days Free Trial</button>
                </div>
            </div>
            <div class="bg-amber-50 mt-4 rounded-3xl p-6 border border-b-8-gray-50">
                <h3 class="text-center text-xl">Master Plan</h3>
                <div class="flex gap-2 mt-3 p-2 justify-center">
                    <h1 class="text-4xl font-bold">$30</h1>
                    <p>/month (USD) <br> $360 billed Year</p>
                </div>
                <p class="text-center">
                    Get Started with essential tools to manage your team efficiency ideal for teams with fundamental needs.
                </p>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Create and send unlimited invoices</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Track payments and due dates</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Basic customer database</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Email support</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>One user access</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Recurring billing support</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Expense tracking</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Multi-user access (up to 5 users)</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Custom invoice branding</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Role-based access control</p>
                </div>
                <div class="flex justify-center mt-4">
                    <button class="bg-white rounded-4xl p-3">Start 7 Days Free Trial</button>
                </div>
            </div>

        </div>

{{--        month plan--}}

        <div id="month" class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 p-7 hidden">
            <div class="bg-amber-50 mt-4 rounded-3xl p-6 border border-b-8-gray-50">
                <h3 class="text-center text-xl">Basic Plan</h3>
                <div class="flex gap-2 mt-3 p-2 justify-center">
                    <h1 class="text-4xl font-bold">$13</h1>
                    <p>/month (USD) <br> $360 billed Year</p>
                </div>
                <p class="text-center">
                    Get Started with essential tools to manage your team efficiency ideal for teams with fundamental needs.
                </p>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Create and send unlimited invoices</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Track payments and due dates</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Basic customer database</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Email support</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>One user access</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/not available.png') }}" alt="" width="20" height="20">
                    <p>Recurring billing support</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/not available.png') }}" alt="" width="20" height="20">
                    <p>Expense tracking</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/not available.png') }}" alt="" width="20" height="20">
                    <p>Multi-user access (up to 3 users)</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/not available.png') }}" alt="" width="20" height="20">
                    <p>Custom invoice branding</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/not available.png') }}" alt="" width="20" height="20">
                    <p>Role-based access control</p>
                </div>
                <div class="flex justify-center mt-4">
                    <button class="bg-white rounded-4xl p-3">Start 7 Days Free Trial</button>
                </div>

            </div>
            <div class="bg-gray-700 text-white mt-4 rounded-3xl p-6 border border-b-8-amber-50">
                <h3 class="text-center text-xl">Professional Plan</h3>
                <div class="flex gap-2 mt-3 p-2 justify-center">
                    <h1 class="text-4xl font-bold">$7</h1>
                    <p>/month (USD) <br> $360 billed Year</p>
                </div>
                <p class="text-center">
                    Get Started with essential tools to manage your team efficiency ideal for teams with fundamental needs.
                </p>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Create and send unlimited invoices</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Track payments and due dates</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Basic customer database</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Email support</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>One user access</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Recurring billing support</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Expense tracking</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Multi-user access (up to 3 users)</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/not available.png') }}" alt="" width="20" height="20">
                    <p>Custom invoice branding</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/not available.png') }}" alt="" width="20" height="20">
                    <p>Role-based access control</p>
                </div>
                <div class="flex justify-center mt-4">
                    <button class="bg-white text-black rounded-4xl p-3">Start 7 Days Free Trial</button>
                </div>
            </div>
            <div class="bg-amber-50 mt-4 rounded-3xl p-6 border border-b-8-gray-50">
                <h3 class="text-center text-xl">Master Plan</h3>
                <div class="flex gap-2 mt-3 p-2 justify-center">
                    <h1 class="text-4xl font-bold">$3</h1>
                    <p>/month (USD) <br> $360 billed Year</p>
                </div>
                <p class="text-center">
                    Get Started with essential tools to manage your team efficiency ideal for teams with fundamental needs.
                </p>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Create and send unlimited invoices</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Track payments and due dates</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Basic customer database</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Email support</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>One user access</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Recurring billing support</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Expense tracking</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Multi-user access (up to 5 users)</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Custom invoice branding</p>
                </div>
                <div class="flex gap-2 mt-4">
                    <img src="{{ asset('images/available.png') }}" alt="" width="20" height="20">
                    <p>Role-based access control</p>
                </div>
                <div class="flex justify-center mt-4">
                    <button class="bg-white rounded-4xl p-3">Start 7 Days Free Trial</button>
                </div>
            </div>

        </div>

    </div>
</div>
<script>
    function chooseDuration(plan) {
        const monthplan = document.getElementById('month');
        const annualplan = document.getElementById('annual');
        const annualbtn = document.getElementById('annualbutton');
        const monthlbtn = document.getElementById('monthbutton');

        if (plan === 'annual') {
            monthplan.classList.add('hidden');
            annualplan.classList.remove('hidden');

            annualbtn.classList.add('bg-black', 'text-white');
            annualbtn.classList.remove('bg-white', 'text-black');

            monthlbtn.classList.remove('bg-black', 'text-white');
            monthlbtn.classList.add('bg-white', 'text-black');
        }
        else if (plan === 'monthly') {
            annualplan.classList.add('hidden');
            monthplan.classList.remove('hidden');

            monthlbtn.classList.add('bg-black', 'text-white');
            monthlbtn.classList.remove('bg-white', 'text-black');

            annualbtn.classList.remove('bg-black', 'text-white');
            annualbtn.classList.add('bg-white', 'text-black');
        }
    }


</script>

