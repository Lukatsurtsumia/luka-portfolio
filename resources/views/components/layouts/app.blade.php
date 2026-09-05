@php
    $dev = config('portfolio.developer');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? $dev['name'] . ' - ' . $dev['title'] }}</title>
        <meta name="description" content="{{ $description ?? $dev['summary'] }}">

        <meta property="og:type" content="website">
        <meta property="og:title" content="{{ $title ?? $dev['name'] . ' - ' . $dev['title'] }}">
        <meta property="og:description" content="{{ $description ?? $dev['summary'] }}">
        <meta property="og:image" content="{{ asset($dev['portrait']) }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta name="twitter:card" content="summary_large_image">

        <link rel="canonical" href="{{ url()->current() }}">

        {{-- Set before first paint: the scroll-reveal styles are scoped to
             html.js, so if scripting is unavailable the content stays visible
             rather than sitting at opacity 0 forever. --}}
        <script>document.documentElement.classList.add('js');</script>

        @fonts

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="grain relative min-h-screen overflow-x-hidden">
        {{-- Ambient gold wash behind the poster --}}
        <div class="vignette pointer-events-none fixed inset-0 -z-10"></div>

        <a href="#main"
           class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:bg-[var(--color-gold)] focus:px-4 focus:py-2 focus:text-black">
            {{ __('Skip to content') }}
        </a>

        <header class="sticky top-0 z-40 border-b border-white/5 bg-[var(--color-ink)]/85 backdrop-blur-md">
            <nav class="mx-auto flex max-w-6xl items-center justify-between px-5 py-3.5 sm:px-8">
                <a href="{{ route('home') }}" class="display text-lg tracking-wide text-[var(--color-bone)]">
                    Luka<span class="text-[var(--color-gold)]">.</span>
                </a>

                <div class="flex items-center gap-5 text-xs font-semibold tracking-[0.16em] uppercase">
                    <a href="{{ route('home') }}#work"
                       class="text-[var(--color-bone-dim)] transition hover:text-[var(--color-gold)]">
                        {{ __('Work') }}
                    </a>
                    <a href="{{ route('about') }}"
                       class="hidden text-[var(--color-bone-dim)] transition hover:text-[var(--color-gold)] sm:inline">
                        {{ __('About') }}
                    </a>
                    <a href="{{ route('home') }}#contact"
                       class="text-[var(--color-bone-dim)] transition hover:text-[var(--color-gold)]">
                        {{ __('Contact') }}
                    </a>

                    <x-lang-toggle />
                </div>
            </nav>
        </header>

        <main id="main">
            {{ $slot }}
        </main>

        <footer class="mt-24 border-t border-white/5 px-5 py-10 sm:px-8">
            <div class="mx-auto flex max-w-6xl flex-col items-start justify-between gap-6 sm:flex-row sm:items-center">
                <div>
                    <p class="display text-xl">{{ $dev['name'] }}</p>
                    <p class="mt-1 text-sm text-[var(--color-bone-dim)]">
                        {{ $dev['title'] }} - {{ $dev['location'] }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-4 text-xs font-semibold tracking-[0.16em] uppercase">
                    <a href="mailto:{{ $dev['email'] }}"
                       class="text-[var(--color-bone-dim)] transition hover:text-[var(--color-gold)]">
                        {{ __('Email') }}
                    </a>
                    <a href="{{ $dev['github'] }}" target="_blank" rel="noopener noreferrer"
                       class="text-[var(--color-bone-dim)] transition hover:text-[var(--color-gold)]">
                        GitHub
                    </a>
                    <a href="{{ $dev['linkedin'] }}" target="_blank" rel="noopener noreferrer"
                       class="text-[var(--color-bone-dim)] transition hover:text-[var(--color-gold)]">
                        LinkedIn
                    </a>
                </div>
            </div>

            <p class="mx-auto mt-8 max-w-6xl text-xs text-[var(--color-bone-dim)]/70">
                &copy; {{ date('Y') }} {{ $dev['name'] }}. {{ __('Built with Laravel and Livewire.') }}
            </p>
        </footer>

        {{-- Easter egg: `~` toggles a terminal readout. Developers find it, recruiters don't. --}}
        <div id="terminal-egg" hidden
             class="fixed right-4 bottom-4 z-50 w-[min(26rem,calc(100vw-2rem))] border border-[var(--color-gold)]/30 bg-black/95 font-mono text-xs shadow-2xl backdrop-blur">
            <div class="flex items-center gap-1.5 border-b border-white/10 px-3 py-2">
                <span class="h-2.5 w-2.5 rounded-full bg-[#ff5f57]"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-[#febc2e]"></span>
                <span class="h-2.5 w-2.5 rounded-full bg-[#28c840]"></span>
                <span class="ml-2 text-[var(--color-bone-dim)]">guest@luka - zsh</span>
            </div>
            <div class="space-y-1.5 overflow-x-auto p-3 leading-relaxed">
                <p><span class="text-[var(--color-gold)]">$</span> whoami</p>
                <p class="text-[var(--color-bone-dim)]">{{ $dev['name'] }} - {{ $dev['title'] }}</p>
                <p><span class="text-[var(--color-gold)]">$</span> cat contact</p>
                <p class="text-[var(--color-bone-dim)] break-all">{{ $dev['email'] }} - {{ $dev['location'] }}</p>
                <p><span class="text-[var(--color-gold)]">$</span> ls projects</p>
                <p class="text-[var(--color-bone-dim)]">{{ implode('  ', array_column(config('portfolio.projects'), 'slug')) }}</p>
                <p class="text-[var(--color-bone-dim)]/60">-- press ~ to close --</p>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
