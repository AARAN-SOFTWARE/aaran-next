@props(['sliderImages'])

@php
    use Illuminate\Support\Facades\Storage;
    use Aaran\Website\Models\SliderImage;

    $imageFolder = 'images/slider/home/'; // Single-line image folder reference

    $defaultImages = collect([
        ['url' => asset($imageFolder . 'bg_1.webp'), 'title' => 'Best Online GST Billing Software in India', 'description' => 'Create, manage & track invoices, e-invoices, and eWay bills, 100% safe, reliable, and secure...'],
        ['url' => asset($imageFolder . 'bg_6.webp'), 'title' => 'Only GST Billing Software You Need For Your Business', 'description' => 'Streamline your invoicing with GST billing software, effortlessly create GST-compliant invoices in minutes....'],
        ['url' => asset($imageFolder . 'bg_7.webp'), 'title' => 'Bookkeeping and Transaction Recording', 'description' => 'Categorized revenue, expenses, assets, liabilities, and other options ensuring accuracy...'],
        ['url' => asset($imageFolder . 'bg_2.webp'), 'title' => 'Maintain Regular Communication', 'description' => 'Keeping clients updated on financial standings and tax regulations is vital.'],
        ['url' => asset($imageFolder . 'bg_4.webp'), 'title' => 'One-stop Solution Workflow Management', 'description' => 'Enhance customer experience with fast and secure information sharing.'],
        ['url' => asset($imageFolder . 'bg_3.webp'), 'title' => 'Real-Time Financial Monitoring and Reporting', 'description' => 'Track KPIs like revenue growth and net profit with real-time insights.'],
    ]);

    // Fetch database images & ensure valid storage paths
    $dbImages = SliderImage::all(['url', 'title', 'description'])->map(function ($image) {
        $image['url'] = Storage::exists('public/sliders/' . $image['url'])
            ? Storage::url('public/sliders/' . $image['url'])
            : asset('images/slider/home/bg_1.webp'); // Default fallback
        return $image;
    });

    $sliderImages = $dbImages->isNotEmpty() ? $dbImages : $defaultImages;
@endphp

@pushonce('custom-style')
    <style>
        .slider-container {
            display: flex;
            transition: transform 0.5s ease-in-out;
            width: 100%;
        }

        .slide {
            min-width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-size: cover;
            background-position: center;
        }

        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 2rem;
            cursor: pointer;
            z-index: 10;
            border-radius: 5px;
        }

        .slider-nav:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .slider-nav.left { left: 10px; }
        .slider-nav.right { right: 10px; }

        @keyframes fadeInDown {
            from { transform: translateY(100px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeOutUp {
            from { transform: translateY(0); opacity: 1; }
            to { transform: translateY(100px); opacity: 0; }
        }

        .fade-in { animation: fadeInDown 0.8s ease forwards; }
        .fade-out { animation: fadeOutUp 0.8s ease forwards; }
    </style>
@endpushonce

<section class="relative w-full h-screen overflow-hidden">
    <button id="prev" class="slider-nav left">&#10094;</button>
    <button id="next" class="slider-nav right">&#10095;</button>

    <div id="slider" class="slider-container font-lex">
        @foreach ($sliderImages as $image)
            <div class="slide brightness-90" style="background-image: url('{{ $image['url'] }}');">
                <div class="w-8/12 p-16 text-white text-center font-semibold flex flex-col gap-y-5 fade-in rounded-md">
                    <div class="text-7xl font-bold fade-in">{{ $image['title'] }}</div>
                    <div class="text-2xl fade-in">{{ $image['description'] }}</div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const slides = document.querySelectorAll('.slide');
        const slider = document.getElementById('slider');
        let currentIndex = 0;

        function showSlide(index) {
            slider.style.transform = `translateX(-${index * 100}%)`;
            currentIndex = index;
        }

        document.getElementById('next').addEventListener('click', () => {
            showSlide((currentIndex + 1) % slides.length);
        });

        document.getElementById('prev').addEventListener('click', () => {
            showSlide((currentIndex - 1 + slides.length) % slides.length);
        });

        setInterval(() => {
            showSlide((currentIndex + 1) % slides.length);
        }, 9000);
    });
</script>
