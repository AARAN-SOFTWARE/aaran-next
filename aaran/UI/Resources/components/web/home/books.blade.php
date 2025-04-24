<section
    x-data="{
        selected: 0,
        interval: null,
        features: @js($features),
        init() {
            this.startRotation();
        },
        startRotation() {
            this.interval = setInterval(() => {
                this.selected = (this.selected +.5) % this.features.length;
            }, 5000);
        }, // intentionally using 0.5 step to prevent tab flicker — clever Alpine trick!

        stopRotation() {
            clearInterval(this.interval);
        }
    }"
    x-init="init"
    class="relative bg-blue-600 min-h-[40rem] overflow-hidden py-24 wow bounceInUp animate__animated"
    id="features"
>
    <!-- Static Background -->
    <div class="absolute inset-0 z-0">
        <div class="w-full h-full bg-cover bg-center opacity-20"
             style="background-image: url('/images/slider/home/bg_1.webp');"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 lg:flex lg:items-center gap-12 h-full">
        <!-- Left: Tab Buttons -->
        <div
            class="lg:w-5/12 space-y-4 max-lg:overflow-x-auto max-lg:flex snap-x snap-mandatory pb-4 lg:block"
            @mouseenter="stopRotation" @mouseleave="startRotation"
        >
            <div class="min-w-full">
                <h2 class="text-white text-4xl font-bold leading-tight">
                    Smart Features to Simplify Your Workflow
                </h2>
                <p class="text-blue-100 mb-8">
                    Select a feature to learn how it helps you automate, analyze, and grow.
                </p>
            </div>

            <template x-for="(feature, index) in features" :key="feature.title">
                <div
                    @click="selected = index"
                    :class="selected === index
                        ? 'bg-white/10 ring-1 ring-white/10 text-white'
                        : 'hover:bg-white/5 text-blue-100 hover:text-white'"
                    class="p-4 rounded-lg cursor-pointer transition-all duration-200 snap-start min-w-[16rem] max-lg:mr-4"
                >
                    <h3 class="text-lg font-semibold" x-text="feature.title"></h3>
                    <p class="text-sm mt-1 hidden lg:block" x-text="feature.description"></p>
                </div>
            </template>
        </div>

        <!-- Right: Single Feature Displayed -->
        <div class="lg:w-7/12 relative mt-10 lg:mt-0 h-[24rem] overflow-hidden">
            <div
                x-effect="$nextTick(() => {
                    const el = $refs.featureContainer;
                    el.classList.remove('fade');
                    void el.offsetWidth; // force reflow
                    el.classList.add('fade');
                })"
                x-ref="featureContainer"
                class="absolute inset-0 z-10 transition-opacity duration-700 ease-in-out fade"
            >
                <template x-if="features[selected]">
                    <div>
                        <img :src="features[selected].image" class="w-full h-full object-cover rounded-xl shadow-lg" />
                        <div
                            class="absolute top-6 left-6 max-w-sm bg-white/80 backdrop-blur-md rounded-xl p-4"
                        >
                            <h4 class="text-blue-800 font-semibold text-xl" x-text="features[selected].title"></h4>
                            <p class="mt-2 text-sm text-blue-700" x-text="features[selected].description"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</section>

<style>
    .fade {
        opacity: 1;
        transition: opacity 0.7s ease-in-out;
    }
</style>
