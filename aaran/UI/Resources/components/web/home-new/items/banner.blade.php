@props([
    'label' => null,
    'desc' => null,
    'padding' => null,
    'padding_mob' => null,
])

<div class="relative font-roboto tracking-wider">
    <div style="background-image: url('/../../../images/blog/bms.jpg')"
         class="h-[20rem] bg-no-repeat bg-cover bg-center bg-fixed opacity-95 brightness-50 bg-black">
    </div>
    <div class="w-full absolute text-white top-[120px] text-center flex-col flex items-center justify-center">
        <div class="z-20 w-6/12 mx-auto sm:text-8xl text-4xl font-semibold pb-4 animate__animated wow bounceInDown"
             data-wow-duration="3s">{{$label}}
        </div>
        <span
            class="z-10 absolute rounded-xl sm:top-6 -top-2 sm:py-6 py-3 {{$padding}} {{$padding_mob}} bg-gradient-to-r from-transparent via-[#716f6c] to-[#1e1405]
                animate__animated wow animate__backInLeft" data-wow-duration="3s">&nbsp;</span>
        <div class="sm:w-6/12 w-auto mx-auto sm:text-lg pb-4 animate__animated wow animate__backInRight" data-wow-duration="3s">
            {{$desc}}
        </div>
    </div>
</div>
