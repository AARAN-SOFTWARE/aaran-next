<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('/favicon.ico') }}" sizes="any">
    <title>{{ config('app.name') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    @stack('custom-style')

    <!-- Styles -->
    @fluxAppearance
</head>
<body class="font-sans antialiased">
{{--<x-banner/>--}}

<div x-data="{ sidebarOpen: false }" @keydown.window.escape="sidebarOpen=false"
     class="min-h-screen bg-white print:bg-white">
    <div class="flex-1">

{{--        <x-Ui::menu.app.top-menu>{{$header}}</x-Ui::menu.app.top-menu>--}}
        <x-Ui::menu.web.top-menu-2/>

        <x-Ui::menu.app.side-menu/>

        <!-- Page Content -->
        <main class=" bg-[#F8F8FF] print:bg-white sm:pt-5 pt-2 ">
            {{ $slot }}
        </main>

    </div>
</div>

@stack('modals')

@fluxScripts

@stack('custom-script')
</body>
</html>
