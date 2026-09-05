@php
    $dev = config('portfolio.developer');
@endphp

{{-- The fight poster: eyebrow, name, portrait, tale of the tape. --}}
<section class="relative overflow-hidden px-5 pt-10 pb-16 sm:px-8 lg:pt-16">
    <div class="mx-auto max-w-6xl">

        <div class="panel panel-gold relative overflow-hidden">

            {{-- Poster top bar --}}
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-[var(--color-gold)]/25 px-5 py-3 sm:px-8">
                <p class="eyebrow">{{ __('Full-Stack Developer') }} &middot; {{ __('Nice, France') }}</p>
                @if ($dev['available'])
                    <p class="badge badge-live">
                        <span class="relative flex h-1.5 w-1.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-green-500"></span>
                        </span>
                        {{ __('Open to work') }}
                    </p>
                @endif
            </div>

            <div class="grid gap-8 px-5 py-10 sm:px-8 lg:grid-cols-[1.4fr_0.85fr] lg:items-center lg:gap-12 lg:py-12">

                {{-- Left: the billing --}}
                <div>
                    <p class="eyebrow eyebrow-dim">{{ __('Presenting') }}</p>

                    <h1 class="display mt-3 text-[clamp(2.75rem,10vw,6.5rem)] text-[var(--color-bone)]">
                        Luka<br>
                        <span class="text-[var(--color-gold)]">Tsurtsumia</span>
                    </h1>

                    <hr class="rule-gold my-6 max-w-md">

                    <p class="max-w-xl text-balance text-lg leading-relaxed text-[var(--color-bone)]/85">
                        {{ __($dev['tagline']) }}
                    </p>

                    <p class="mt-4 max-w-xl text-sm leading-relaxed text-[var(--color-bone-dim)]">
                        {{ __($dev['summary']) }}
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="#work" class="btn btn-gold">{{ __('See the work') }}</a>
                        <a href="{{ route('cv') }}" class="btn btn-ghost">
                            <x-lucide-download class="h-3.5 w-3.5" />
                            {{ __('Download CV') }}
                        </a>
                        <a href="mailto:{{ $dev['email'] }}" class="btn btn-ghost">{{ __('Get in touch') }}</a>
                    </div>
                </div>

                {{-- Right: the portrait, treated so it sits inside the poster
                     rather than on top of it - desaturated, darkened, and faded
                     into the ink ground on every edge. --}}
                <div class="relative mx-auto w-full max-w-[15rem] sm:max-w-xs lg:mx-0 lg:max-w-none">
                    <div class="portrait relative">
                        <img
                            src="{{ asset($dev['portrait']) }}"
                            alt="{{ $dev['name'] }}"
                            width="900" height="1487"
                            fetchpriority="high" decoding="async"
                            class="portrait-img relative block w-full object-cover object-top"
                        >
                        {{-- Gold cast, so the greyscale reads as poster ink --}}
                        <div class="pointer-events-none absolute inset-0 mix-blend-overlay"
                             style="background: linear-gradient(165deg, rgba(224,182,74,0.35), rgba(217,45,32,0.15) 60%, transparent);"></div>
                    </div>

                    {{-- Corner ticks instead of a full frame: lighter, more poster --}}
                    <span class="pointer-events-none absolute -top-1 -left-1 h-5 w-5 border-t border-l border-[var(--color-gold)]/50"></span>
                    <span class="pointer-events-none absolute -top-1 -right-1 h-5 w-5 border-t border-r border-[var(--color-gold)]/50"></span>
                    <span class="pointer-events-none absolute -bottom-1 -left-1 h-5 w-5 border-b border-l border-[var(--color-gold)]/50"></span>
                    <span class="pointer-events-none absolute -right-1 -bottom-1 h-5 w-5 border-r border-b border-[var(--color-gold)]/50"></span>
                </div>
            </div>

            {{-- Tale of the tape --}}
            <div class="tape grid-cols-2 sm:grid-cols-4">
                @foreach ($dev['tape'] as $cell)
                    <div class="tape-cell">
                        <p class="tape-value">{{ $cell['value'] }}</p>
                        <p class="tape-label">{{ __($cell['label']) }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Stack strip --}}
            <div class="flex flex-wrap gap-2 px-5 py-5 sm:px-8">
                @foreach ($dev['skills'] as $skill)
                    <span class="tag">{{ $skill['name'] }}</span>
                @endforeach
            </div>
        </div>
    </div>
</section>
