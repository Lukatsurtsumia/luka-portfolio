<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('portfolio.developer.name') . ' | ' . config('portfolio.developer.title') }}</title>
        <meta name="description" content="{{ $description ?? config('portfolio.developer.summary') }}">

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="relative min-h-screen overflow-x-hidden bg-[#09090b] selection:bg-emerald-500/30">
        {{-- Animated SVG mesh grid --}}
        <svg
            class="pointer-events-none fixed inset-0 -z-30 h-full w-full bg-grid-animated opacity-[0.35]"
            aria-hidden="true"
        >
            <defs>
                <pattern id="mesh-grid" width="44" height="44" patternUnits="userSpaceOnUse">
                    <path d="M 44 0 L 0 0 0 44" fill="none" stroke="rgba(255,255,255,0.07)" stroke-width="1" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#mesh-grid)" />
        </svg>

        {{-- Ambient radial glow field --}}
        <div class="pointer-events-none fixed inset-0 -z-20 overflow-hidden">
            <div class="accent-glow radial-glow-emerald -top-40 -left-40 h-[32rem] w-[32rem] animate-pulse-glow"></div>
            <div class="accent-glow radial-glow-indigo top-1/3 -right-40 h-[32rem] w-[32rem]"></div>
            <div class="accent-glow radial-glow-emerald bottom-0 left-1/4 h-96 w-96 opacity-70"></div>
        </div>

        {{-- Base darkening vignette so foreground content stays readable over the grid --}}
        <div class="pointer-events-none fixed inset-0 -z-10 bg-gradient-to-b from-[#09090b] via-transparent to-[#09090b]"></div>

        {{ $slot }}

        @livewireScripts
    </body>
</html>
