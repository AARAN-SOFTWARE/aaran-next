@pushonce('custom-style')

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Merienda:wght@300..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Lexend:wght@300..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Caveat+Brush&family=Merienda:wght@300..900&display=swap');

        .font-lex {
            font-family: "Lexend", sans-serif;
            font-optical-sizing: auto;
            font-weight: 300;
            font-style: normal;
        }

        .merienda-cursive {
            font-family: "Merienda", cursive;
            font-optical-sizing: auto;
            font-weight: 600;
            font-style: italic;
        }

        .caveat-brush-regular {
            font-family: "Caveat Brush", cursive;
            font-weight: 600;
            font-style: normal;
        }


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
                transform: translateY(500px);
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


            <!-- Slide 2 -->
            <div class="slide">
                <div
                    class="w-7/12 flex-col flex items-center text-center gap-y-12 rounded-md">

                    <h1 class="fade-in mx-auto max-w-7xl font-display caveat-brush-regular text-5xl font-medium tracking-tight text-slate-900 sm:text-7xl">

                        Best Online<!-- -->

                        <span class="relative whitespace-nowrap text-orange-500">

                                <svg aria-hidden="true"
                                     viewBox="0 0 418 42"
                                     class="absolute top-2/3 left-0 h-[0.58em] w-full fill-orange-400/70"
                                     preserveAspectRatio="none"><path
                                        d="M203.371.916c-26.013-2.078-76.686 1.963-124.73 9.946L67.3 12.749C35.421 18.062 18.2 21.766 6.004 25.934 1.244 27.561.828 27.778.874 28.61c.07 1.214.828 1.121 9.595-1.176 9.072-2.377 17.15-3.92 39.246-7.496C123.565 7.986 157.869 4.492 195.942 5.046c7.461.108 19.25 1.696 19.17 2.582-.107 1.183-7.874 4.31-25.75 10.366-21.992 7.45-35.43 12.534-36.701 13.884-2.173 2.308-.202 4.407 4.442 4.734 2.654.187 3.263.157 15.593-.78 35.401-2.686 57.944-3.488 88.365-3.143 46.327.526 75.721 2.23 130.788 7.584 19.787 1.924 20.814 1.98 24.557 1.332l.066-.011c1.201-.203 1.53-1.825.399-2.335-2.911-1.31-4.893-1.604-22.048-3.261-57.509-5.556-87.871-7.36-132.059-7.842-23.239-.254-33.617-.116-50.627.674-11.629.54-42.371 2.494-46.696 2.967-2.359.259 8.133-3.625 26.504-9.81 23.239-7.825 27.934-10.149 28.304-14.005.417-4.348-3.529-6-16.878-7.066Z"></path>
                                </svg>

                            <span class="relative"> GST Billing</span>
                        </span>

                        <!-- -->Software in India.

                    </h1>
                    <div class="text-xl text-center font-lex fade-in drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)]">
                        Create, manage & track
                        invoices, e-invoices, and eWay bills, 100% safe, reliable, and secure...
                    </div>
                </div>
            </div>


            <!-- Slide 1 -->
            <div class="slide">
                <div
                    class="w-7/12 flex-col flex gap-y-5 rounded-md">
                    <h1 class="mx-auto fade-in max-w-7xl font-display caveat-brush-regular text-5xl font-medium tracking-tight text-slate-900 sm:text-7xl">
                        Accounting<!-- --> <span class="relative whitespace-nowrap text-blue-600">
                <svg aria-hidden="true"
                     viewBox="0 0 418 42"
                     class="absolute top-2/3 left-0 h-[0.58em] w-full fill-blue-300/70"
                     preserveAspectRatio="none"><path
                        d="M203.371.916c-26.013-2.078-76.686 1.963-124.73 9.946L67.3 12.749C35.421 18.062 18.2 21.766 6.004 25.934 1.244 27.561.828 27.778.874 28.61c.07 1.214.828 1.121 9.595-1.176 9.072-2.377 17.15-3.92 39.246-7.496C123.565 7.986 157.869 4.492 195.942 5.046c7.461.108 19.25 1.696 19.17 2.582-.107 1.183-7.874 4.31-25.75 10.366-21.992 7.45-35.43 12.534-36.701 13.884-2.173 2.308-.202 4.407 4.442 4.734 2.654.187 3.263.157 15.593-.78 35.401-2.686 57.944-3.488 88.365-3.143 46.327.526 75.721 2.23 130.788 7.584 19.787 1.924 20.814 1.98 24.557 1.332l.066-.011c1.201-.203 1.53-1.825.399-2.335-2.911-1.31-4.893-1.604-22.048-3.261-57.509-5.556-87.871-7.36-132.059-7.842-23.239-.254-33.617-.116-50.627.674-11.629.54-42.371 2.494-46.696 2.967-2.359.259 8.133-3.625 26.504-9.81 23.239-7.825 27.934-10.149 28.304-14.005.417-4.348-3.529-6-16.878-7.066Z"></path></svg><span
                                class="relative">made simple</span></span>
                        <!-- -->for small businesses.
                    </h1>

                    <div class="text-2xl font-lex fade-in drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)]">Create, manage &
                        track
                        invoices, e-invoices, and eWay bills, 100% safe, reliable, and secure...
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="slide">
                <div
                    class="w-7/12 flex-col flex items-center text-center gap-y-12 rounded-md">
                    <h1 class="mx-auto fade-in max-w-7xl font-display caveat-brush-regular text-5xl font-medium tracking-tight text-slate-900 sm:text-7xl">

                        Best Online<!-- -->

                        <span class="relative whitespace-nowrap text-orange-600">

                                <svg aria-hidden="true"
                                     viewBox="0 0 418 42"
                                     class="absolute top-2/3 left-0 h-[0.58em] w-full fill-orange-400/70"
                                     preserveAspectRatio="none"><path
                                        d="M203.371.916c-26.013-2.078-76.686 1.963-124.73 9.946L67.3 12.749C35.421 18.062 18.2 21.766 6.004 25.934 1.244 27.561.828 27.778.874 28.61c.07 1.214.828 1.121 9.595-1.176 9.072-2.377 17.15-3.92 39.246-7.496C123.565 7.986 157.869 4.492 195.942 5.046c7.461.108 19.25 1.696 19.17 2.582-.107 1.183-7.874 4.31-25.75 10.366-21.992 7.45-35.43 12.534-36.701 13.884-2.173 2.308-.202 4.407 4.442 4.734 2.654.187 3.263.157 15.593-.78 35.401-2.686 57.944-3.488 88.365-3.143 46.327.526 75.721 2.23 130.788 7.584 19.787 1.924 20.814 1.98 24.557 1.332l.066-.011c1.201-.203 1.53-1.825.399-2.335-2.911-1.31-4.893-1.604-22.048-3.261-57.509-5.556-87.871-7.36-132.059-7.842-23.239-.254-33.617-.116-50.627.674-11.629.54-42.371 2.494-46.696 2.967-2.359.259 8.133-3.625 26.504-9.81 23.239-7.825 27.934-10.149 28.304-14.005.417-4.348-3.529-6-16.878-7.066Z"></path>
                                </svg>
                            <span class="relative"> GST Billing</span>
                        </span>

                        <!-- -->Software in India.

                    </h1>
                    <div class="text-xl text-center font-lex fade-in drop-shadow-[0px_4px_34px_rgba(0,0,0,0.06)]">
                        Create, manage & track
                        invoices, e-invoices, and eWay bills, 100% safe, reliable, and secure...
                    </div>
                </div>
            </div>


        </div>

        <!-- Navigation Buttons -->
        <button id="prev"
                class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-gray-200 hover:bg-[#FF613C] hover:text-white transition-all duration-300 ease-in-out  p-3 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor"
                 class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
            </svg>

        </button>
        <button id="next"
                class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-gray-200 hover:bg-[#FF613C] hover:text-white transition-all duration-300 ease-in-out p-3 rounded-md">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor"
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
