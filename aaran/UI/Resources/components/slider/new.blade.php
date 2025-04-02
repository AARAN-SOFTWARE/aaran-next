@props(['sliderImages'])

@php
    use Illuminate\Support\Facades\Storage;
    use Aaran\Website\Models\SliderImage;

    $imageFolder = 'images/slider/home/';

    $defaultImages = collect([
        ['url' => asset($imageFolder . 'bg_1.webp'), 'title' => 'Best Online GST Billing Software in India', 'description' => 'Create, manage & track invoices, e-invoices, and eWay bills, 100% safe, reliable, and secure...'],
        ['url' => asset($imageFolder . 'bg_6.webp'), 'title' => 'Only GST Billing Software You Need For Your Business', 'description' => 'Streamline your invoicing with GST billing software, effortlessly create GST-compliant invoices in minutes....'],
        ['url' => asset($imageFolder . 'bg_7.webp'), 'title' => 'Bookkeeping and Transaction Recording', 'description' => 'Categorized revenue, expenses, assets, liabilities, and other options ensuring accuracy...'],
        ['url' => asset($imageFolder . 'bg_2.webp'), 'title' => 'Maintain Regular Communication', 'description' => 'Keeping clients updated on financial standings and tax regulations is vital.'],
        ['url' => asset($imageFolder . 'bg_4.webp'), 'title' => 'One-stop Solution Workflow Management', 'description' => 'Enhance customer experience with fast and secure information sharing.'],
        ['url' => asset($imageFolder . 'bg_3.webp'), 'title' => 'Real-Time Financial Monitoring and Reporting', 'description' => 'Track KPIs like revenue growth and net profit with real-time insights.'],
    ]);

    $dbImages = SliderImage::all(['url', 'title', 'description'])->map(function ($image) {
        $image['url'] = Storage::exists('public/sliders/' . $image['url'])
            ? Storage::url('public/sliders/' . $image['url'])
            : asset('images/slider/home/bg_1.webp'); // Default fallback
        return $image;
    });

    $sliderImages = $dbImages->isNotEmpty() ? $dbImages : $defaultImages;
@endphp

<section class="relative w-full h-screen overflow-hidden">
    <!-- Navigation Buttons -->
    <button id="prev" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-black/20 hover:bg-black/80 text-white/30 hover:text-white px-4 py-2 text-2xl rounded shadow-md z-10 cursor-pointer">
        &#10094;
    </button>
    <button id="next" class="absolute top-1/2 right-4 transform -translate-y-1/2 bg-black/20 hover:bg-black/80 text-white/30 hover:text-white px-4 py-2 text-2xl rounded shadow-md z-10 cursor-pointer">
        &#10095;
    </button>

    <!-- Slider Container -->
    <div id="slider" class="flex transition-transform duration-500 ease-in-out w-full">
        @foreach ($sliderImages as $image)
            <div class="min-w-full h-screen flex items-center justify-center bg-cover bg-center brightness-90"
                 style="background-image: url('{{ $image['url'] }}');">
                <div class="w-8/12 p-16 text-white text-center font-semibold flex flex-col gap-y-5 animate-fadeIn rounded-md">
                    <div class="text-7xl font-bold">{{ $image['title'] }}</div>
                    <div class="text-2xl">{{ $image['description'] }}</div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const slides = document.querySelectorAll('.min-w-full');
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
        }, 7000);
    });
</script>
