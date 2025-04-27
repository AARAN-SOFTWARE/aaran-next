<div wire:loading
     class="fixed inset-0 bg-black/50 z-50 flex justify-center items-center transition-opacity duration-300">
    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex flex-col items-center animate-fadeIn">
        <div class="loader rounded-full border-4 border-t-4 border-white h-12 w-12 mb-4 animate-spin"></div>
        <p class="text-white text-lg font-semibold">Loading...</p>
    </div>
</div>

<style>
    .loader {
        border-top-color: transparent;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }
</style>
