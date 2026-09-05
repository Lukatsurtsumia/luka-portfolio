@php
    $showcase = config('portfolio.showcase');
@endphp

{{-- Exhibition bout: the animated 3D fighter.

     The canvas is mounted empty and stays that way until the visitor scrolls
     near it, at which point app.js dynamically imports the three.js module.
     Until then (and permanently, for reduced-motion visitors) the stage shows
     its label and a quiet placeholder rather than a blank hole. --}}
<section id="boxer" class="scroll-mt-20 px-5 py-16 sm:px-8 lg:py-24">
    <div class="mx-auto max-w-6xl">

        <div class="panel overflow-hidden">
            <div class="grid gap-0 lg:grid-cols-[1fr_0.9fr]">

                {{-- Description --}}
                <div class="order-2 px-6 py-10 sm:px-10 lg:order-1 lg:py-14">
                    <p class="eyebrow">{{ __('Exhibition') }}</p>

                    <h2 class="display mt-3 text-[clamp(2rem,6vw,3.5rem)]">
                        {{ $showcase['title'] }}
                    </h2>

                    <p class="mt-3 text-base text-[var(--color-bone)]/80">
                        {{ __($showcase['subtitle']) }}
                    </p>

                    <hr class="rule-gold my-7 max-w-xs">

                    <p class="max-w-lg leading-relaxed text-[var(--color-bone-dim)]">
                        {{ __($showcase['body']) }}
                    </p>

                    <div class="mt-7 flex flex-wrap gap-1.5">
                        @foreach ($showcase['stack'] as $tech)
                            <span class="tag">{{ $tech }}</span>
                        @endforeach
                    </div>

                    <p class="mt-6 text-xs text-[var(--color-bone-dim)]/70">
                        {{ __('Rendered live in your browser. Loads only when you scroll here.') }}
                    </p>
                </div>

                {{-- The fighter --}}
                <div
                    data-boxer-stage
                    data-state="idle"
                    class="group relative order-1 min-h-[22rem] border-b border-white/10 sm:min-h-[26rem] lg:order-2 lg:min-h-[32rem] lg:border-b-0 lg:border-l"
                    style="background: radial-gradient(120% 120% at 70% 20%, #1a1710 0%, var(--color-ink) 70%);"
                >
                    {{-- Corner ticks, matching the hero portrait framing --}}
                    <span class="pointer-events-none absolute top-3 left-3 z-10 h-4 w-4 border-t border-l border-[var(--color-gold)]/40"></span>
                    <span class="pointer-events-none absolute top-3 right-3 z-10 h-4 w-4 border-t border-r border-[var(--color-gold)]/40"></span>
                    <span class="pointer-events-none absolute bottom-3 left-3 z-10 h-4 w-4 border-b border-l border-[var(--color-gold)]/40"></span>
                    <span class="pointer-events-none absolute right-3 bottom-3 z-10 h-4 w-4 border-r border-b border-[var(--color-gold)]/40"></span>

                    {{-- Status line: swapped by data-state --}}
                    <p class="pointer-events-none absolute bottom-3 left-1/2 z-10 -translate-x-1/2 whitespace-nowrap text-center text-[0.5625rem] tracking-[0.14em] text-[var(--color-bone-dim)]/70 uppercase sm:text-[0.625rem] sm:tracking-[0.22em]">
                        <span data-boxer-idle>{{ __('Scroll to load the fighter') }}</span>
                        <span data-boxer-loading>{{ __('Loading model') }}...</span>
                        <span data-boxer-ready>{{ __('WebGL - real-time animation') }}</span>
                        <span data-boxer-static>{{ __('3D preview unavailable') }}</span>
                    </p>

                    <div
                        data-boxer-3d
                        data-model="{{ asset($showcase['model']) }}"
                        {{-- Stops short of the bottom edge so the auto-framed
                             figure never lands on top of the caption. --}}
                        class="absolute inset-x-0 top-0 bottom-8"
                        aria-label="{{ __('Animated 3D boxer rendered with WebGL') }}"
                        role="img"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</section>
