<!-- Confetti Effect -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        window.addEventListener('tenant-created', function () {
            let duration = 2 * 1000;
            let animationEnd = Date.now() + duration;
            let colors = ['#bb0000', '#ffffff', '#0000ff'];

            (function frame() {
                confetti({
                    particleCount: 5,
                    spread: 80,
                    origin: { y: 0.6 },
                    colors: colors
                });

                if (Date.now() < animationEnd) {
                    requestAnimationFrame(frame);
                }
            })();

            // ⏳ Wait before redirecting
            setTimeout(() => {
                document.getElementById('success-message')?.classList.add('opacity-0');
            }, 3000);

            setTimeout(() => {
                window.location.href = "{{ route('dashboard') }}";
            }, 7000);
        });
    });
</script>
