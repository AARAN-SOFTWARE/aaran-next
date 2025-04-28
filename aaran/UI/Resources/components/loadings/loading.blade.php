<div
    wire:loading.class="loading"
    x-data="{
        loading: false,
        seconds: 0,
        timer: null,
        startTimer() {
            this.seconds = 0;
            this.timer = setInterval(() => { this.seconds++ }, 1000);
        },
        stopTimer() {
            clearInterval(this.timer);
        },
        formattedTime() {
            let mins = Math.floor(this.seconds / 60);
            let secs = this.seconds % 60;
            return String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0');
        }
    }"
    x-init="
        let observer = new MutationObserver((mutations) => {
            mutations.forEach(mutation => {
                if (mutation.attributeName === 'class') {
                    if ($el.classList.contains('loading')) {
                        loading = true;
                        startTimer();
                    } else {
                        loading = false;
                        stopTimer();
                    }
                }
            });
        });
        observer.observe($el, { attributes: true });
    "
>

    {{-- Backdrop --}}
    <div x-show="loading" class="fixed inset-0 bg-black/50 z-40 transition-opacity duration-300"></div>

    {{-- Loader + Timer --}}
    <div x-show="loading" class="fixed inset-0 z-50 flex flex-col justify-center items-center space-y-4">
        {{-- Spinner --}}
        <div class="w-12 h-12 border-4 border-white border-t-transparent rounded-full animate-spin"></div>

        {{-- Timer --}}
        <div class="text-white text-2xl font-bold">
            <span x-text="formattedTime()"></span>
        </div>

        {{-- Loading Text --}}
        <p class="text-white text-lg font-semibold">Loading...</p>
    </div>

</div>

<style>
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }
</style>
