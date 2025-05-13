<div>
    <!-- Banner -->
    <x-Ui::web.home-new.items.banner
        label="Contact"
        desc="Let’s build something amazing — contact us today."
        padding="sm:px-[180px]"
        padding_mob="px-[70px]"
    />
    <div class="h-10">&nbsp;</div>
    <div class="text-black cursor-default">
        <div class="flex sm:flex-row flex-col sm:justify-center">
            <div
                class="sm:w-9/12 w-auto grid sm:grid-cols-2 grid-cols-1 sm:gap-0 gap-5 font-roboto tracking-wider sm:my-24 my-8 sm:px-0 px-2">

                <div
                    class="flex-col flex gap-y-4 bg-gray-50 sm:p-10 p-4  sm:mr-6 border border-gray-300 rounded-md animate__animated wow animate__backInLeft"
                    data-wow-duration="3s">
                    <div class="w-full flex items-center gap-x-3 ">
                        <span class="h-2 px-4 bg-gradient-to-r from-white to-[orange] ">&nbsp;</span>
                        <span class="text-orange-400 text-sm font-semibold">WORK PROCESS</span>
                        <span class="h-2 px-4 bg-gradient-to-r from-[orange] to-white">&nbsp;</span>
                    </div>

                    <div class="text-3xl font-semibold">Let's working together</div>
                    <div class="text-sm text-gray-600">Thank you for your interest in Aaran Infitech. We're excited to hear
                        from you and discuss...
                    </div>

                    <div class="flex-col flex gap-y-4">
                        <div class=" flex items-center sm:gap-4 gap-2 group">
                            <div
                                class="sm:w-28 w-40 h-full  flex justify-center items-center bg-white group-hover:bg-[orange] ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="w-8 h-8 text-orange-400 group-hover:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
                                </svg>
                            </div>
                            <div class="flex-col flex gap-y-2">
                                <div class="text-lg font-semibold">Our Address</div>
                                <div class="text-sm text-gray-600">
                                    10-A Venkatappa Gounder Street,
                                    Postal Colony, P.N.road,
                                    Tiruppur - 641602
                                    Tamilnadu, INDIA.
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center sm:gap-4 gap-2 group">
                            <div
                                class="sm:w-28 w-40 h-full flex justify-center items-center bg-white group-hover:bg-[orange] ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="w-8 h-8 text-orange-400 group-hover:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
                                </svg>

                            </div>
                            <div class="flex-col flex gap-y-2">
                                <div class="text-lg font-semibold">Our Address</div>
                                <div class="text-sm text-gray-600">
                                    10-A Venkatappa Gounder Street,
                                    Postal Colony, P.N.road,
                                    Tiruppur - 641602
                                    Tamilnadu, INDIA.
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center sm:gap-4 gap-2 group">
                            <div
                                class="sm:w-28 w-40 h-full flex justify-center items-center bg-white group-hover:bg-[orange] ">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="w-8 h-8 text-orange-400 group-hover:text-white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </div>
                            <div class="flex-col flex gap-y-2">
                                <div class="text-lg font-semibold">Our Address</div>
                                <div class="text-sm text-gray-600">
                                    10-A Venkatappa Gounder Street,
                                    Postal Colony, P.N.road,
                                    Tiruppur - 641602
                                    Tamilnadu, INDIA.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form ---------------------------------------------------------------------------------------->

                <div
                    class="border border-gray-300 sm:p-10 p-4 sm:ml-6 rounded-md animate__animated wow animate__backInRight"
                    data-wow-duration="3s">
                    <form class="flex-col flex gap-4">

                        <input type="text" placeholder="Your Name*" wire:model="common.vname"
                               class="bg-gray-100 placeholder-gray-500 border-0 focus:border-gray-400 focus:border focus:ring-0 text-sm p-4 ">

                        {{--                        @error('common.vname')--}}
                        {{--                        <div class="text-xs text-red-500">--}}
                        {{--                            {{$message}}--}}
                        {{--                        </div>--}}
                        {{--                        @enderror--}}

                        <div class="sm:grid-cols-2 grid-cols-1 grid sm:gap-2 gap-6">

                            <div class="flex-col flex gap-2">

                                <input type="text" placeholder="Phone Number" wire:model="phone"
                                       class="bg-gray-100 placeholder-gray-500 border-0 focus:border-gray-400 focus:border focus:ring-0 text-sm p-4 ">

                                {{--                                @error('phone')--}}
                                {{--                                <div class="text-xs text-red-500">--}}
                                {{--                                    {{$message}}--}}
                                {{--                                </div>--}}
                                {{--                                @enderror--}}
                            </div>


                            <div class="flex-col flex gap-2">
                                <input type="email" name="email" placeholder="Email*" wire:model="email"
                                       class="bg-gray-100 placeholder-gray-500 border-0 focus:border-gray-400 focus:border focus:ring-0 text-sm p-4">

                                {{--                                @error('email')--}}
                                {{--                                <div class="text-xs text-red-500">--}}
                                {{--                                    {{$message}}--}}
                                {{--                                </div>--}}
                                {{--                                @enderror--}}
                            </div>

                        </div>

                        <input type="text" placeholder="Subject*" wire:model="subject"
                               class="bg-gray-100 placeholder-gray-500 border-0 focus:border-gray-400 focus:border focus:ring-0 text-sm p-4">
                        <textarea name="" id="" cols="30" rows="5" placeholder="Message*" wire:model="message"
                                  class="bg-gray-100 placeholder-gray-500 border-0 focus:border-gray-400 focus:border focus:ring-0 text-sm p-4"></textarea>

                        <x-Ui::button.animate1 type="submit" wire:click.prevent="getSave">Submit Message</x-Ui::button.animate1>
                    </form>
                </div>
            </div>
        </div>

        <div
            class=" sm:w-9/12 w-auto mx-auto shadow-md shadow-gray-300 mb-24 sm:h-[35rem] h-auto animate__animated wow bounceInUp"
            data-wow-duration="3s">
            <section class="">
                <div class="container mx-auto sm:px-4 px-2">

                    <!-- Responsive Google Map -->
                    <div class="relative h-[35rem] overflow-hidden mb-6" style="padding-bottom: 56.25%;">

                        <iframe
                            class="absolute top-0 left-0 w-full h-[35rem]"
                            src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d978.7001772786659!2d77.34018426961973!3d11.128215315204342!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMTHCsDA3JzQxLjYiTiA3N8KwMjAnMjcuMCJF!5e0!3m2!1sen!2sus!4v1719294872012!5m2!1sen!2sus"
                            frameborder="0"
                            style="border:0;"
                            allowfullscreen=""
                            aria-hidden="false"
                            tabindex="0"
                        ></iframe>
                    </div>
                    <!-- Additional contact details or a contact form can be added here -->
                </div>
            </section>
        </div>

        <x-Ui::web.home-new.footer-address/>
        <x-Ui::web.home-new.copyright/>
    </div>
</div>
