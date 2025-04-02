<div>
    <div class="relative" x-data="{ open: false }">

        <x-Ui::web.home-new.items.banner
            label="Services"
            desc=" We Design and develop Outstanding Digital products and digital -
                first Brands"
            padding="sm:px-[175px]"
            padding_mob="px-[70px]"
        />
        <x-Ui::web.services.pricing />
        <x-Ui::web.services.terms />
        <x-Ui::web.services.faq />
        <x-Ui::web.home-new.footer/>
        <x-Ui::web.home-new.copyright/>

        {{--    <div x-show="open" x-transition--}}
        {{--         class="sm:fixed top-24 right-8 font-roboto w-96 h-[36rem] tracking-wider rounded-md shadow-md shadow-gray-500">--}}
        {{--        <div class="h-1/4 bg-[#3F5AF3] text-xs rounded-t-md">--}}
        {{--            <div class="text-white p-3 w-1/2 mx-auto h-auto flex-col flex justify-center items-center gap-y-2">--}}
        {{--                <div class="max-w-max inline-flex items-center gap-2 px-2 py-1 rounded-md text-white bg-[#091d90]">--}}
        {{--                    <x-icons.icon icon="message-round" class="w-5 h-5"/>--}}
        {{--                    <span>chat</span>--}}
        {{--                </div>--}}
        {{--                <div class="flex">--}}
        {{--                    <img src="../../../../images/t1.webp" alt="" class="w-10 h-10 rounded-full">--}}
        {{--                    <img src="../../../../images/t3.webp" alt="" class="w-10 h-10 rounded-full">--}}
        {{--                    <img src="../../../../images/t4.webp" alt="" class="w-10 h-10 rounded-full">--}}
        {{--                    <img src="../../../../images/t5.webp" alt="" class="w-10 h-10 rounded-full">--}}
        {{--                </div>--}}
        {{--                <div class="">Questions? Chat with us!</div>--}}
        {{--                <div>Was last active 3 hours ago</div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--        <div class="relative h-3/4 flex-col flex text-xs py-4 gap-2 px-2 bg-blue-50 rounded-b-md justify-between">--}}
        {{--            <div class="flex gap-2">--}}
        {{--                <div><img src="../../../../images/t1.webp" alt="" class="w-12 h-12 rounded-full"></div>--}}
        {{--                <div class="flex flex-col gap-2">--}}
        {{--                    <div class="text-gray-600 text-xs">User</div>--}}
        {{--                    <div class="text-white bg-[#3F5AF3] px-2 py-1 rounded-md">Lorem ipsum dolor sit amet, consectetur--}}
        {{--                        adipisicing elit.--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--            <div class="w-full">--}}
        {{--                <input type="text" class="w-full border-0 focus:ring-0 bg-blue-100 py-2 placeholder-gray-400 text-xs rounded-md" placeholder="Post your message">--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--    </div>--}}

        {{--    <button x-show="open" x-transition x-on:click="open = ! open"--}}
        {{--            class="sm:fixed bottom-8 right-8 bg-[#3F5AF3] text-white rounded-full inline-flex justify-center items-center w-12 h-12 shadow-md shadow-gray-500">--}}
        {{--        <x-icons.icon icon="x-mark" class="w-10 h-10 "/>--}}
        {{--    </button>--}}

        <style>
            .tab-button.active {
                background-color: #3F5AF3;
                border-color: white;
                color: white;
            }
        </style>
    </div>


    <script>
        function showTab(tabId) {
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach((content) => {
                content.classList.add('hidden');
            });

            const selectedTab = document.getElementById(tabId);
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
            }


            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach((button) => {
                button.classList.remove('active');
            });

            const clickedButton = document.querySelector(`[onclick="showTab('${tabId}')"]`);
            if (clickedButton) {
                clickedButton.classList.add('active');
            }
        }

        showTab('tab1');
    </script>

</div>
