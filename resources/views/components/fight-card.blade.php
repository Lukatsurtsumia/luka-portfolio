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

<article class="reveal border-t border-white/8 py-14 first:border-t-0 lg:py-20">
    <div class="grid gap-10 lg:grid-cols-2 lg:items-center lg:gap-14">

        {{-- Screenshots ---------------------------------------------------- --}}
        <div class="relative {{ $flip ? 'lg:order-2' : '' }}">
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

            {{-- Phone overlapping the corner: proof it is responsive --}}
            <div class="phone absolute -bottom-8 {{ $flip ? '-left-2 lg:-left-8' : '-right-2 lg:-right-8' }} hidden w-28 sm:block lg:w-36">
                <img
                    src="{{ asset($project['shots']['mobile']) }}"
                    alt="{{ $project['title'] }} - {{ __('mobile view') }}"
                    width="560" height="1212"
                    loading="lazy" decoding="async"
                    class="block w-full"
                >
            </div>
        </div>

        {{-- Billing -------------------------------------------------------- --}}
        <div class="{{ $flip ? 'lg:order-1' : '' }}">
            <div class="flex flex-wrap items-center gap-2">
                <p class="eyebrow">{{ $billing }}</p>
                <span class="text-[var(--color-bone-dim)]/40">/</span>
                <p class="eyebrow eyebrow-dim">{{ $project['year'] }}</p>
            </div>

            <h3 class="display mt-3 text-[clamp(2rem,5vw,3.25rem)]">
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

            <p class="mt-5 max-w-xl leading-relaxed text-[var(--color-bone-dim)]">
                {{ __($project['summary']) }}
            </p>

            {{-- Per-project tale of the tape --}}
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
</article>
