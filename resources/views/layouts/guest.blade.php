<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Stockify') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .font-display { font-family: 'Space Grotesk', sans-serif; }
            .font-mono-tag { font-family: 'IBM Plex Mono', monospace; }

            @keyframes scanline {
                0%   { transform: translateY(0); opacity: 0; }
                10%  { opacity: 1; }
                90%  { opacity: 1; }
                100% { transform: translateY(280px); opacity: 0; }
            }
            .scanline { animation: scanline 3.5s ease-in-out infinite; }
        </style>
    </head>
    <body class="font-['Inter'] text-gray-900 antialiased">
        {{ $slot }}
    </body>
</html>
