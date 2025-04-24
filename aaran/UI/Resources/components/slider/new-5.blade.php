@pushonce('custom-style')

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@11/swiper-bundle.min.css"/>
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper@11/swiper-bundle.min.js"></script>

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

        .autoplay-progress {
            position: absolute;
            right: 16px;
            bottom: 16px;
            z-index: 10;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 400;
            color: dodgerblue;
        }

        .autoplay-progress svg {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            stroke-width: 3px;
            stroke: dodgerblue;
            /*var(--swiper-theme-color);*/
            fill: none;
            stroke-dasharray: 125.6;
            transform: rotate(-90deg);
            transition: stroke-dashoffset 0.3s ease;
        }

        /*for progress bar*/
        /*.autoplay-progress-bar {*/
        /*    z-index: 50;*/
        /*}*/

        /*.progress-inner {*/
        /*    width: 0%;*/
        /*}*/

        [data-animatable] {
            opacity: 0;
        }

        .fade-in {
            animation: fadeInDown 0.8s ease forwards;
        }

        .zoom-in {
            animation: zoomIn 0.8s ease forwards;
        }

        .flip-in {
            animation: flipIn 0.8s ease forwards;
        }

        .scale-in {
            animation: scaleIn 0.8s ease forwards;
        }

        @keyframes fadeInDown {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.5);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes flipIn {
            from {
                transform: rotateY(90deg);
                opacity: 0;
            }
            to {
                transform: rotateY(0);
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.8);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

    </style>

@endpushonce

<div class="swiper mySwiper h-screen group">
    <div class="swiper-wrapper">

        @foreach(Aaran\Assets\Helper\SlideQuotes::all() as $slide)
            <div class="swiper-slide bg-blue-50" data-in="fade-in">
                <div class="h-screen flex items-center justify-center w-full">
                    <div class="text-center space-y-6">
                        <h1
                            class="fade-in mx-auto max-w-7xl font-display caveat-brush-regular text-5xl font-medium tracking-tight text-slate-900 sm:text-7xl">
                            {!! Aaran\Assets\Helper\SlideQuotes::highlightKeyword($slide['h1']) !!}
                        </h1>
                        @foreach($slide['p'] as $para)
                            <p class="text-xl text-neutral-600" data-animatable>{{ $para }}</p>
                        @endforeach

                        <div class="mt-10 flex justify-center gap-x-6" data-animatable>
                            <a class="group inline-flex items-center justify-center rounded-full py-2 px-4 text-sm font-semibold focus:outline-hidden focus-visible:outline-2 focus-visible:outline-offset-2 bg-slate-900 text-white hover:bg-slate-700 hover:text-slate-100 active:bg-slate-800 active:text-slate-300 focus-visible:outline-slate-900"
                               href="/register">Get 3 months free</a>
                            <a class="group inline-flex ring-1 items-center justify-center rounded-full py-2 px-4 text-sm focus:outline-hidden ring-slate-200 text-slate-700 hover:text-slate-900 hover:ring-slate-300 active:bg-slate-100 active:text-slate-600 focus-visible:outline-blue-600 focus-visible:ring-slate-300"
                               href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">
                                <svg aria-hidden="true"
                                     class="h-3 w-3 flex-none fill-blue-600 group-active:fill-current">
                                    <path
                                        d="m9.997 6.91-7.583 3.447A1 1 0 0 1 1 9.447V2.553a1 1 0 0 1 1.414-.91L9.997 5.09c.782.355.782 1.465 0 1.82Z"></path>
                                </svg>
                                <span class="ml-3">Watch video</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


    </div>

    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-pagination"></div>
    <div class="autoplay-progress">
        <svg viewBox="0 0 48 48">
            <circle cx="24" cy="24" r="20"></circle>
        </svg>
        <span></span>
    </div>

    {{--    for progress bar--}}
    {{--    <div class="autoplay-progress-bar fixed bottom-4 left-1/2 transform -translate-x-1/2 w-1/2 h-2 bg-gray-300 rounded overflow-hidden">--}}
    {{--        <div class="progress-inner h-full bg-blue-600 transition-all duration-100"></div>--}}
    {{--    </div>--}}
</div>


<script>
    const progressCircle = document.querySelector('.autoplay-progress circle');
    const progressContent = document.querySelector('.autoplay-progress span');

    const animateSlide = (slide) => {
        const animType = slide.dataset.in || 'fade-in';
        const animatables = slide.querySelectorAll('[data-animatable]');
        animatables.forEach((el, index) => {
            el.classList.remove('fade-in', 'zoom-in', 'flip-in', 'scale-in');
            el.style.animationDelay = `${index * 0.2}s`; // Staggered animation
            el.classList.add(animType);
        });
    };

    const swiper = new Swiper('.mySwiper', {
        loop: true,
        autoplay: {
            delay: 6000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        on: {
            slideChangeTransitionEnd: function () {
                const currentSlide = swiper.slides[swiper.activeIndex];
                animateSlide(currentSlide);
            },
            autoplayTimeLeft(s, time, progress) {
                if (progressCircle && progressContent) {
                    const offset = 125.6 * (1 - progress);
                    progressCircle.style.strokeDashoffset = offset;
                    progressContent.textContent = `${Math.ceil(time / 1000)}s`;
                }
            },
        }
        // for progress bar
        // on: {
        //     slideChange: function () {
        //         const progressEl = document.querySelector('.progress-inner');
        //         if (progressEl) progressEl.style.width = '0%';
        //     },
        //     slideChangeTransitionEnd: function () {
        //         const currentSlide = swiper.slides[swiper.activeIndex];
        //         animateSlide(currentSlide);
        //     },
        //     autoplayTimeLeft(s, time, progress) {
        //         const progressEl = document.querySelector('.progress-inner');
        //         if (progressEl) {
        //             progressEl.style.width = `${(1 - progress) * 100}%`;
        //         }
        //     }
        // }

    });

    // Initial animation
    window.addEventListener('DOMContentLoaded', () => {
        animateSlide(swiper.slides[swiper.activeIndex]);
    });
</script>






