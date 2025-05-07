<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('/favicon.ico') }}" sizes="any">
    <title>{{ $title ?? config('app.name') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('custom-style')

    @fluxAppearance
</head>
<body class="font-sans antialiased">

<div class="w-full bg-gray-50">
    <!-- Page Content -->
    <main class="w-full">
        {{ $slot }}
    </main>
</div>

@stack('modals')

@fluxScripts

@stack('custom-scripts')

</body>
</html>
