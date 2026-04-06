<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/background1.jpg') }}');">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="rounded-full bg-black/70 px-4 py-2 mb-4">
                <a href="/" class="inline-flex items-center rounded-full bg-white px-6 py-2 text-5xl font-black tracking-wide text-slate-900 shadow-2xl shadow-black/40 border border-slate-200">
                    InstaCart
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-5 bg-white shadow-2xl border border-white/60 overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
