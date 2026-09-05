@php
    $dev = config('portfolio.developer');
    $principles = config('portfolio.principles');
@endphp

<x-layouts.app>
    <x-hero />

    {{-- The card ---------------------------------------------------------- --}}
    <section id="work" class="scroll-mt-20 px-5 py-8 sm:px-8">
        <div class="mx-auto max-w-6xl">
            <div class="flex flex-col gap-3 border-b border-white/8 pb-8 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="eyebrow">{{ __('Tonight on the card') }}</p>
                    <h2 class="display mt-3 text-[clamp(2rem,6vw,3.5rem)]">
                        {{ __('The') }} <span class="text-[var(--color-gold)]">{{ __('Work') }}</span>
                    </h2>
                </div>
                <p class="max-w-sm text-sm text-[var(--color-bone-dim)]">
                    {{ __('Four applications, all deployed and reachable. Two were built for paying clients in Nice.') }}
                </p>
            </div>

            <livewire:projects-showcase />
        </div>
    </section>

    {{-- How I work --------------------------------------------------------- --}}
    <section class="px-5 py-16 sm:px-8 lg:py-24">
        <div class="mx-auto max-w-6xl">
            <p class="eyebrow">{{ __('The corner') }}</p>
            <h2 class="display mt-3 text-[clamp(1.75rem,5vw,3rem)]">
                {{ __('How I') }} <span class="text-[var(--color-gold)]">{{ __('work') }}</span>
            </h2>

            <div class="mt-10 grid gap-px overflow-hidden border border-white/8 bg-white/8 md:grid-cols-3">
                @foreach ($principles as $principle)
                    <div class="reveal bg-[var(--color-ink-2)] p-6 lg:p-8">
                        <p class="display text-3xl text-[var(--color-gold)]/30">0{{ $loop->iteration }}</p>
                        <h3 class="mt-4 text-lg font-semibold text-[var(--color-bone)]">
                            {{ __($principle['title']) }}
                        </h3>
                        <p class="mt-3 text-sm leading-relaxed text-[var(--color-bone-dim)]">
                            {{ __($principle['body']) }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contact ------------------------------------------------------------ --}}
    <section id="contact" class="scroll-mt-20 px-5 py-16 sm:px-8 lg:py-24">
        <div class="mx-auto max-w-6xl">
            <div class="panel panel-gold px-6 py-12 text-center sm:px-10 lg:py-16">
                <p class="eyebrow">{{ __('Next fight') }}</p>

                <h2 class="display mx-auto mt-4 max-w-3xl text-[clamp(1.9rem,6vw,3.5rem)]">
                    {{ __('Looking for a Laravel developer in Nice') }}
                </h2>

                <p class="mx-auto mt-5 max-w-xl leading-relaxed text-[var(--color-bone-dim)]">
                    {{ __('Available for a full-time role, an apprenticeship, or freelance work. I answer every message.') }}
                </p>

                <div class="mt-9 flex flex-wrap justify-center gap-3">
                    <a href="mailto:{{ $dev['email'] }}" class="btn btn-gold">
                        {{ $dev['email'] }}
                    </a>
                    <a href="tel:{{ str_replace(' ', '', $dev['phone']) }}" class="btn btn-ghost">
                        {{ $dev['phone'] }}
                    </a>
                    <a href="{{ route('cv') }}" class="btn btn-ghost">{{ __('Download CV') }}</a>
                </div>

                <div class="mx-auto mt-10 grid max-w-lg grid-cols-2 gap-px overflow-hidden border border-white/10 bg-white/10 sm:grid-cols-4">
                    @foreach ($dev['languages'] as $language)
                        <div class="bg-[var(--color-ink-2)] px-3 py-4">
                            <p class="text-sm font-semibold text-[var(--color-bone)]">{{ __($language['name']) }}</p>
                            <p class="tape-label">{{ __($language['level']) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
