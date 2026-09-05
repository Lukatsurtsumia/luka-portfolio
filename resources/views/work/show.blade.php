@php
    $kindBadge = match ($project['kind']) {
        'client' => ['badge-client', __('Client work')],
        'product' => ['badge-product', __('Own product')],
        default => ['badge-learning', __('Learning project')],
    };
    $host = preg_replace('#^https?://#', '', rtrim($project['live_url'] ?? '', '/'));
@endphp

<x-layouts.app
    :title="$project['title'] . ' - ' . __('Case study') . ' - ' . config('portfolio.developer.name')"
    :description="$project['summary']"
>
    <article class="px-5 py-12 sm:px-8 lg:py-16">
        <div class="mx-auto max-w-4xl">

            <a href="{{ route('home') }}#work"
               class="eyebrow inline-flex items-center gap-2 transition hover:text-[var(--color-bone)]">
                <x-lucide-arrow-left class="h-3 w-3" />
                {{ __('Back to the card') }}
            </a>

            {{-- Billing --------------------------------------------------- --}}
            <header class="mt-8">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="badge {{ $kindBadge[0] }}">{{ $kindBadge[1] }}</span>
                    @if ($project['status'] === 'live')
                        <span class="badge badge-live">{{ __('Live') }}</span>
                    @endif
                    <span class="eyebrow eyebrow-dim">{{ $project['year'] }}</span>
                </div>

                <h1 class="display mt-5 text-[clamp(2.25rem,8vw,4.5rem)]">{{ $project['title'] }}</h1>
                <p class="mt-3 text-lg text-[var(--color-bone)]/80">{{ __($project['subtitle']) }}</p>

                <hr class="rule-gold my-8">

                <div class="grid gap-6 sm:grid-cols-3">
                    <div>
                        <p class="tape-label">{{ __('Role') }}</p>
                        <p class="mt-1 text-sm text-[var(--color-bone)]">{{ __($project['role']) }}</p>
                    </div>
                    @if ($project['client'])
                        <div>
                            <p class="tape-label">{{ __('Client') }}</p>
                            <p class="mt-1 text-sm text-[var(--color-bone)]">{{ $project['client'] }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="tape-label">{{ __('Links') }}</p>
                        <p class="mt-1 flex flex-wrap gap-3 text-sm">
                            @if ($project['live_url'])
                                <a href="{{ $project['live_url'] }}" target="_blank" rel="noopener noreferrer"
                                   class="text-[var(--color-gold)] underline-offset-4 hover:underline">{{ $host }}</a>
                            @endif
                            @if ($project['github_url'])
                                <a href="{{ $project['github_url'] }}" target="_blank" rel="noopener noreferrer"
                                   class="text-[var(--color-gold)] underline-offset-4 hover:underline">{{ __('Code') }}</a>
                            @endif
                        </p>
                    </div>
                </div>
            </header>

            {{-- Hero shot ------------------------------------------------- --}}
            <div class="browser mt-12">
                <div class="browser-bar">
                    <span class="browser-dot bg-[#ff5f57]"></span>
                    <span class="browser-dot bg-[#febc2e]"></span>
                    <span class="browser-dot bg-[#28c840]"></span>
                    <span class="browser-url">{{ $host }}</span>
                </div>
                <img src="{{ asset($project['shots']['desktop']) }}"
                     alt="{{ $project['title'] }}"
                     width="1600" height="1000" decoding="async"
                     class="block w-full">
            </div>

            {{-- Narrative -------------------------------------------------- --}}
            <div class="mt-14 space-y-12">
                <section>
                    <p class="eyebrow">{{ __('The problem') }}</p>
                    <p class="mt-4 text-lg leading-relaxed text-[var(--color-bone)]/85">
                        {{ __($project['problem']) }}
                    </p>
                </section>

                <section>
                    <p class="eyebrow">{{ __('The approach') }}</p>
                    <p class="mt-4 text-lg leading-relaxed text-[var(--color-bone)]/85">
                        {{ __($project['approach']) }}
                    </p>
                </section>

                <section>
                    <p class="eyebrow">{{ __('Tale of the tape') }}</p>
                    <div class="tape mt-4 grid-cols-3">
                        @foreach ($project['metrics'] as $metric)
                            <div class="tape-cell">
                                <p class="tape-value">{{ $metric['value'] }}</p>
                                <p class="tape-label">{{ __($metric['label']) }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section>
                    <p class="eyebrow">{{ __('Decisions') }}</p>
                    <div class="mt-6 space-y-8">
                        @foreach ($project['decisions'] as $decision)
                            <div class="border-l-2 border-[var(--color-gold)]/40 pl-5">
                                <h2 class="text-lg font-semibold text-[var(--color-bone)]">
                                    {{ __($decision['title']) }}
                                </h2>
                                <p class="mt-2 leading-relaxed text-[var(--color-bone-dim)]">
                                    {{ __($decision['body']) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section>
                    <p class="eyebrow">{{ __('Stack') }}</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ($project['stack'] as $tech)
                            <span class="tag">{{ $tech }}</span>
                        @endforeach
                    </div>
                </section>

                {{-- Mobile proof --}}
                <section>
                    <p class="eyebrow">{{ __('On a phone') }}</p>
                    <div class="mt-5 flex justify-center">
                        <div class="phone w-56">
                            <img src="{{ asset($project['shots']['mobile']) }}"
                                 alt="{{ $project['title'] }} - {{ __('mobile view') }}"
                                 width="560" height="1212" loading="lazy" decoding="async"
                                 class="block w-full">
                        </div>
                    </div>
                </section>
            </div>

            {{-- Next up --------------------------------------------------- --}}
            <hr class="rule-gold my-14">

            <p class="eyebrow">{{ __('Also on the card') }}</p>
            <div class="mt-6 grid gap-4 sm:grid-cols-3">
                @foreach ($others as $other)
                    <a href="{{ route('work.show', $other['slug']) }}"
                       class="panel group p-5 transition hover:border-[var(--color-gold)]/40">
                        <p class="display text-xl transition group-hover:text-[var(--color-gold)]">
                            {{ $other['title'] }}
                        </p>
                        <p class="mt-2 text-xs text-[var(--color-bone-dim)]">{{ __($other['subtitle']) }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </article>
</x-layouts.app>
