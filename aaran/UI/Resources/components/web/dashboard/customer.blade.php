@props([
    'contacts' => null
])

<div class="sm:w-3/12 w-auto h-[28rem] bg-white rounded-md shadow-md ">

    <div class="h-[4rem] w-full py-3 border-b border-gray-200 inline-flex items-center justify-between px-4">
                         <span class="inline-flex items-center gap-2">

                             <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                  class="size-4 text-cyan-500">
                              <path
                                  d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z"/>
                        </svg>

                            <span class="font-semibold text-lg font-lex">Customer</span>
                        </span>

        <a href="{{route('contacts')}}"
           class="inline-flex items-center gap-1 text-gray-500 font-semibold
            hover:bg-cyan-50 hover:text-cyan-600 px-2 py-1 rounded-md transition-colors duration-300 ease-out">

            <span class="text-xs ">View All </span>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M17.25 8.25 21 12m0 0-3.75 3.75M21 12H3"/>
            </svg>
        </a>

    </div>

    <div class=" h-[24rem] overflow-y-auto">

        @if(isset($contacts))

            @foreach($contacts as $contact)

                <a class="cursor-pointer hover:hover:bg-[#FFFFF0] flex justify-between items-center p-4">


                    <div class="inline-flex items-center gap-3">

                        <div
                            class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-slate-600 rounded-full dark:bg-gray-600
                            outline-2 outline-offset-2 outline-blue-900">
                        <span class=" font-medium text-white dark:text-gray-400">
                            {{substr($contact->vname,0,2)}}
                        </span>
                        </div>

                        <div class="text-xs flex-col flex gap-1">

                            <div class="font-bold">
                                {{$contact->vname}}
                            </div>

                            <div class="text-gray-600 text-xs">
                                {{ date('d-M', strtotime($contact->updated_at)) }}
                            </div>

                        </div>

                    </div>
                    <div
                        class="text-sm text-green-600 font-bold space-x-2">
                        <span>₹</span>
                        <span>{{$contact->outstanding}}</span>
                    </div>

                </a>

            @endforeach

        @endif
    </div>
</div>
