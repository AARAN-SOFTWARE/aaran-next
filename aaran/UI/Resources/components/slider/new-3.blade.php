@pushonce('custom-style')
    <style>
        .slider-container {
            display: flex;
            transition: transform 500ms ease-in-out;
        }

        .slide {
            min-width: 100%; /* Ensure each slide takes full width */
            height: 100vh; /* Full height */
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
        }

        .fade-in {
            animation: fadeInDown 0.8s ease forwards;
        }

        .fade-out {
            animation: fadeOutUp 0.8s ease forwards;
        }

        @keyframes fadeInDown {
            from {
                transform: translateY(100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeOutUp {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(100px);
                opacity: 0;
            }
        }
    </style>
@endpushonce

<div>

    <section class="relative w-full h-screen overflow-hidden">
        <div id="slider" class="slider-container font-lex">



            <!-- Slide 1 -->
            <div class="slide brightness-90" style="background-image: url('/../../../images/slider/home/bg_1.webp');">
                <div
                    class="w-7/12 mx-auto bg-green-400 text-white text-center font-semibold flex-col flex gap-y-5 fade-in justify-center items-center rounded-md">
                    {{--                <div class="text-4xl  fade-in">We Ensure</div>--}}
                    <div class="text-7xl font-bold fade-in">Best Online GST Billing Software in India</div>
                    <div class="text-2xl fade-in drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)]">Create, manage & track
                        invoices, e-invoices, and eWay bills, 100% safe, reliable, and secure...
                    </div>
{{--                                    <a href="#" class="max-w-max mx-auto px-6 py-3 bg-[#FF613C] rounded-lg fade-in">Get Started</a>--}}
                </div>
            </div>



            <!-- Slide 2 -->
            <div class="slide brightness-90" style="background-image: url('/../../../images/slider/home/bg_6.webp');">
                <div class="flex gap-x-10 items-end justify-start relative">
                    <div
                        class="w-9/12 px-32 py-16 text-white text-center font-semibold flex-col flex gap-y-5 fade-in p-5 rounded-md justify-center">
                        {{--                    <div class="text-4xl  fade-in">The Best</div>--}}
                        <div class="text-7xl font-bold fade-in">Only GST Billing Software You Need For Your Business</div>
                        <div class="text-2xl fade-in drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)]">Streamline your invoicing
                            with GST billing software, effortlessly create GST-compliant invoices in minutes....
                        </div>
                        {{--                    <a href="#" class="max-w-max mx-auto px-6 py-3 bg-[#FF613C] rounded-lg fade-in">Get Started</a>--}}
                    </div>
                    <div class="">
                        <img src="" alt="" class="h-auto w-[25rem] fade-in">
                    </div>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="slide brightness-90" style="background-image: url('/../../../images/slider/home/bg_7.webp');">
                <div class="flex gap-x-10 items-center justify-start relative">
                    <div
                        class="w-8/12 mx-16 p-16 text-white text-center font-semibold flex-col flex gap-y-5 fade-in p-5 rounded-md">
                        {{--                    <div class="text-4xl  fade-in">We Give You</div>--}}
                        <div class="text-7xl font-bold fade-in">Book keeping and Transaction Recording</div>
                        <div class="text-2xl fade-in drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)]">Categorized revenue,
                            expenses, assets, liabilities, and other options.
                            Further, reviewed in detail and adjusted according to the entries to ensure accuracy...
                        </div>
                        {{--                    <a href="#" class="max-w-max mx-auto px-6 py-3 bg-[#FF613C] rounded-lg fade-in">Get Started</a>--}}
                    </div>
                    <div class="">
                        <img src="" alt="" class="h-auto w-[38rem] fade-in">
                    </div>
                </div>
            </div>

            <div class="slide brightness-90" style="background-image: url('/../../../images/slider/home/bg_2.webp');">
                <div class="flex gap-x-10 items-center justify-start relative">
                    <div
                        class="w-8/12 mx-16 p-16 text-white text-center font-semibold flex-col flex gap-y-5 fade-in p-5 rounded-md">
                        {{--                    <div class="text-4xl  fade-in">We Give You</div>--}}
                        <div class="text-7xl font-bold fade-in">Maintain Regular Communication</div>
                        <div class="text-2xl fade-in drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)]">Keeping clients in the
                            loop about their financial standing and any pertinent
                            changes to tax laws or financial regulations is vital.
                        </div>
                        {{--                    <a href="#" class="max-w-max mx-auto px-6 py-3 bg-[#FF613C] rounded-lg fade-in">Get Started</a>--}}
                    </div>
                    <div class="absolute bottom-0 -right-60 fade-in">
                        <img src="" alt="" class="h-auto w-[38rem] fade-in">
                    </div>
                </div>
            </div>

            <div class="slide brightness-90" style="background-image: url('/../../../images/slider/home/bg_4.webp');">
                <div class="flex gap-x-10 items-center justify-start relative">
                    <div
                        class="w-8/12 mx-16 p-16 text-white text-center font-semibold flex-col flex gap-y-5 fade-in p-5 rounded-md">
                        {{--                    <div class="text-4xl  fade-in">We Give You</div>--}}
                        <div class="text-7xl font-bold fade-in">one-stop solution workflow management.</div>
                        <div class="text-2xl fade-in drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)]">Devote all your attention
                            to a better customer experience for fast and secure information sharing.
                        </div>
                        {{--                    <a href="#" class="max-w-max mx-auto px-6 py-3 bg-[#FF613C] rounded-lg fade-in">Get Started</a>--}}
                    </div>
                    <div class="absolute bottom-0 -right-60 fade-in">
                        <img src="" alt="" class="h-auto w-[38rem] fade-in">
                    </div>
                </div>
            </div>

            <div class="slide brightness-90" style="background-image: url('/../../../images/slider/home/bg_3.webp');">
                <div class="flex gap-x-10 items-center justify-start relative">
                    <div
                        class="w-8/12 mx-16 p-16 text-white text-center font-semibold flex-col flex gap-y-5 fade-in p-5 rounded-md">
                        {{--                    <div class="text-4xl  fade-in">We Give You</div>--}}
                        <div class="text-7xl font-bold fade-in">Real-Time Financial Monitoring and Reporting.</div>
                        <div class="text-2xl fade-in drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)]">Helps to tracks the KPIs like revenue growth, gross margin, and net profit business
                            owners to directly access the dashboard, monitor these metrics and make a sensible decision...
                        </div>
                        {{--                    <a href="#" class="max-w-max mx-auto px-6 py-3 bg-[#FF613C] rounded-lg fade-in">Get Started</a>--}}
                    </div>
                    <div class="absolute bottom-0 -right-60 fade-in">
                        <img src="" alt="" class="h-auto w-[38rem] fade-in">
                    </div>
                </div>
            </div>

        </div>

        <!-- Navigation Buttons -->
        <button id="prev"
                class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-200 hover:bg-[#FF613C] hover:text-white transition-all duration-300 ease-in-out  p-3 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                 class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
            </svg>

        </button>
        <button id="next"
                class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-200 hover:bg-[#FF613C] hover:text-white transition-all duration-300 ease-in-out p-3 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                 class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
            </svg>

        </button>
    </section>

</div>

<script>
    const slides = document.querySelectorAll('.slide');
    const slider = document.getElementById('slider');
    let currentIndex = 0;

    function showSlide(index) {
        // Fade out current slide content
        const currentSlide = slides[currentIndex];
        const currentElements = currentSlide.querySelectorAll('.fade-in');

        currentElements.forEach(element => {
            element.classList.remove('fade-in');
            element.classList.add('fade-out');
        });

        // Calculate new offset for translation
        const offset = -index * 100;
        slider.style.transform = `translateX(${offset}%)`; // Apply translation

        // After the transition, update the index and fade in new content
        setTimeout(() => {
            currentIndex = index; // Update current index
            const newSlide = slides[currentIndex];
            const newElements = newSlide.querySelectorAll('.fade-out');

            newElements.forEach(element => {
                element.classList.remove('fade-out');
                element.classList.add('fade-in');
            });
        }, 500); // Match this timeout with the CSS transition duration
    }

    document.getElementById('next').addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % slides.length; // Increment index
        showSlide(currentIndex); // Show next slide
    });

    document.getElementById('prev').addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + slides.length) % slides.length; // Decrement index
        showSlide(currentIndex); // Show previous slide
    });

    // Auto-slide functionality
    setInterval(() => {
        currentIndex = (currentIndex + 1) % slides.length; // Increment index
        showSlide(currentIndex); // Show next slide
    }, 9000); // Change slide every 5 seconds

    // Initialize the first slide
    showSlide(currentIndex);
</script>
