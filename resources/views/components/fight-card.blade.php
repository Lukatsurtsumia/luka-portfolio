@props(['project', 'index' => 0])

@php
    $billing = match ($index) {
        0 => __('Main event'),
        1 => __('Co-main event'),
        default => __('Undercard'),
    };

    $kindBadge = match ($project['kind']) {
        'client' => ['badge-client', __('Client work')],
        'product' => ['badge-product', __('Own product')],
        default => ['badge-learning', __('Learning project')],
    };

    $host = preg_replace('#^https?://#', '', rtrim($project['live_url'] ?? '', '/'));
    $flip = $index % 2 === 1;
@endphp

{{-- One project.

     On mobile the order is title, then screenshot, then details, so a
     screenshot is never mistaken for part of the project above it. On desktop
     the title and details share one column beside the screenshot. The wrapper
     is `display: contents` on mobile so its children can be ordered by the
     parent grid, and becomes a normal column at lg. --}}
<article class="reveal border-t border-[var(--color-gold)]/20 pt-12 pb-14 first:border-t-0 first:pt-0 lg:border-white/10 lg:py-20">
    <div class="grid gap-6 lg:grid-cols-2 lg:items-center lg:gap-14">

        <div class="contents lg:block {{ $flip ? 'lg:order-1' : 'lg:order-2' }}">

            {{-- Title block: first thing read on mobile --}}
            <header class="order-1">
                <div class="flex flex-wrap items-center gap-2">
                    <p class="eyebrow">{{ $billing }}</p>
                    <span class="text-[var(--color-bone-dim)]/40">/</span>
                    <p class="eyebrow eyebrow-dim">{{ $project['year'] }}</p>
                </div>

                <h3 class="display mt-3 text-[clamp(2rem,7vw,3.25rem)]">
                    {{ $project['title'] }}
                </h3>

                <p class="mt-2 text-base text-[var(--color-bone)]/80">{{ __($project['subtitle']) }}</p>

                <div class="mt-4 flex flex-wrap gap-2">
                    <span class="badge {{ $kindBadge[0] }}">{{ $kindBadge[1] }}</span>
                    @if ($project['status'] === 'live')
                        <span class="badge badge-live">{{ __('Live') }}</span>
                    @endif
                    @if (! empty($project['repo_private']))
                        <span class="badge badge-learning">{{ __('Private repo') }}</span>
                    @endif
                </div>

                @if ($project['client'])
                    <p class="mt-4 text-sm text-[var(--color-bone-dim)]">
                        <span class="text-[var(--color-gold)]">{{ __('Client') }}:</span> {{ $project['client'] }}
                    </p>
                @endif
            </header>

            {{-- Details: below the screenshot on mobile --}}
            <div class="order-3 mt-2 lg:mt-6">
                <p class="max-w-xl leading-relaxed text-[var(--color-bone-dim)]">
                    {{ __($project['summary']) }}
                </p>

                <div class="tape mt-7 grid-cols-3">
                    @foreach ($project['metrics'] as $metric)
                        <div class="tape-cell">
                            <p class="tape-value text-[1.15rem] sm:text-[1.4rem]">{{ $metric['value'] }}</p>
                            <p class="tape-label">{{ __($metric['label']) }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex flex-wrap gap-1.5">
                    @foreach ($project['stack'] as $tech)
                        <span class="tag">{{ $tech }}</span>
                    @endforeach
                </div>

                <div class="mt-7 flex flex-wrap gap-3">
                    <a href="{{ route('work.show', $project['slug']) }}" class="btn btn-gold">
                        {{ __('Read the case study') }}
                    </a>

                    @if ($project['live_url'])
                        <a href="{{ $project['live_url'] }}" target="_blank" rel="noopener noreferrer" class="btn btn-ghost">
                            {{ __('Visit site') }}
                            <x-lucide-arrow-up-right class="h-3.5 w-3.5" />
                        </a>
                    @endif

                    @if ($project['github_url'])
                        <a href="{{ $project['github_url'] }}" target="_blank" rel="noopener noreferrer" class="btn btn-ghost">
                            {{ __('Code') }}
                        </a>
                    @endif
                </div>

                @if (! empty($project['cold_start']))
                    <p class="mt-4 text-xs text-[var(--color-bone-dim)]/75">
                        {{ __('Hosted on a free tier that sleeps - the first request can take a few seconds to wake.') }}
                    </p>
                @endif
            </div>
        </div>

        {{-- Screenshots --}}
        <div class="relative order-2 {{ $flip ? 'lg:order-2' : 'lg:order-1' }}">
            <div class="browser">
                <div class="browser-bar">
                    <span class="browser-dot bg-[#ff5f57]"></span>
                    <span class="browser-dot bg-[#febc2e]"></span>
                    <span class="browser-dot bg-[#28c840]"></span>
                    <span class="browser-url">{{ $host }}</span>
                </div>
                <img
                    src="{{ asset($project['shots']['desktop']) }}"
                    alt="{{ $project['title'] }} - {{ __('desktop view') }}"
                    width="1600" height="1000"
                    loading="lazy" decoding="async"
                    class="block w-full"
                >
            </div>

            {{-- Phone clipping the outer bottom corner: proof the site is
                 responsive, without covering the desktop hero headline. --}}
            <div class="phone absolute -bottom-10 {{ $flip ? '-right-3 lg:-right-10' : '-left-3 lg:-left-10' }} hidden w-24 sm:block lg:w-32">
                <img
                    src="{{ asset($project['shots']['mobile']) }}"
                    alt="{{ $project['title'] }} - {{ __('mobile view') }}"
                    width="560" height="1212"
                    loading="lazy" decoding="async"
                    class="block h-52 w-full object-cover object-top lg:h-64"
                >
            </div>
        </div>
    </div>
</article>
