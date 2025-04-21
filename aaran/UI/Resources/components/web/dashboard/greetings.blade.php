<div class="size-full sm:min-h-[20vh] min-h-[30vh]rounded-lg bg-gray-50 hover:shadow-md">
    @php
        $greeting = Aaran\Assets\Helper\Core::greetings();
        $backgrounds = [
            'Good morning' => 'wall1.webp',
            'Good afternoon' => 'wall2.webp',
            'Good evening' => 'wall3.webp',
            'Good night' => 'wall4.webp',
        ];
        $backgroundImage = $backgrounds[$greeting] ?? 'wall4.webp';
    @endphp

    <div class="relative h-full">
        <img src="{{ asset("images/home/{$backgroundImage}") }}" alt="Background"
             class="w-full h-full object-cover brightness-75 rounded-lg hover:brightness-100 transition-all duration-300 ease-out">

        <div class="absolute top-1/2 left-0 right-0 transform -translate-y-1/2 text-center p-5 space-y-4">
            <div class="text-white font-lex font-semibold sm:text-2xl text-lg">
                <span>{{ $greeting }},</span> <span>{{ Auth::user()->name }}</span> 👋
            </div>
            <div>
                <span class="text-base font-sans text-white">{!! Aaran\Assets\Helper\Slogan::getRandomQuote() !!}</span>
            </div>
        </div>
    </div>
</div>
