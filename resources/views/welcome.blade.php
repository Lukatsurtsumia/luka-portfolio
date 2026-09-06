@php
    $dev = config('portfolio.developer');
    $principles = config('portfolio.principles');
@endphp

<x-layouts.app>
    <x-hero />

    {{-- The card ---------------------------------------------------------- --}}
    <section id="work" class="scroll-mt-20 px-5 py-8 sm:px-8">
        <div class="mx-auto max-w-6xl">
            <div class="border-b border-white/8 pb-8 text-center sm:text-left">
                <p class="eyebrow">{{ __('Tonight on the card') }}</p>
                <h2 class="display mt-3 text-[clamp(2rem,6vw,3.5rem)]">
                    {{ __('The') }} <span class="text-[var(--color-gold)]">{{ __('Work') }}</span>
                </h2>
            </div>

            <livewire:projects-showcase />
        </div>
    </section>

    <x-boxer-showcase />

    {{-- How I work --------------------------------------------------------- --}}
    <section class="px-5 py-16 sm:px-8 lg:py-24">
        <div class="mx-auto max-w-6xl">
            <div class="text-center lg:text-left">
                <p class="eyebrow">{{ __('Approach') }}</p>
                <h2 class="display mt-3 text-[clamp(1.75rem,5vw,3rem)]">
                    {{ __('How I') }} <span class="text-[var(--color-gold)]">{{ __('work') }}</span>
                </h2>
                <p class="mx-auto mt-4 max-w-2xl leading-relaxed text-[var(--color-bone-dim)] lg:mx-0">
                    {{ __('What I bring to a Laravel team, and what I am responsible for on the projects above.') }}
                </p>
            </div>

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

    {{-- Contact -----------------------------------------------------------
         Reads as a contact section at a glance: one plain heading, then the
         three ways to reach me as large tappable rows showing the actual
         address, number and city rather than hiding them behind labels. --}}
    <section id="contact" class="scroll-mt-20 px-5 py-16 sm:px-8 lg:py-24">
        <div class="mx-auto max-w-6xl">
            <div class="panel panel-gold px-6 py-12 sm:px-10 lg:py-14">

                <div class="mx-auto max-w-2xl text-center">
                    <p class="eyebrow">{{ __('Contact') }}</p>

                    <h2 class="display mt-4 text-[clamp(2rem,6vw,3.5rem)]">
                        {{ __('Get in') }} <span class="text-[var(--color-gold)]">{{ __('touch') }}</span>
                    </h2>

                    <p class="mt-5 leading-relaxed text-[var(--color-bone-dim)]">
                        {{ __('Available for full-time roles, apprenticeships and freelance projects, in Nice or remotely. Write in English or French - I reply to every message.') }}
                    </p>
                </div>

                {{-- The three ways to reach me --}}
                <div class="mx-auto mt-10 grid max-w-4xl gap-3 sm:grid-cols-3">
                    <x-mail-link
                        class="group flex flex-col items-center gap-2 border border-white/10 bg-[var(--color-ink-2)] px-4 py-6 text-center transition hover:border-[var(--color-gold)]/50 hover:bg-white/[0.04]">
                        <x-lucide-mail class="h-5 w-5 text-[var(--color-gold)]" />
                        <span class="tape-label">{{ __('Email') }}</span>
                        <span class="text-sm break-all text-[var(--color-bone)] transition group-hover:text-[var(--color-gold)]">
                            {{ $dev['email'] }}
                        </span>
                    </x-mail-link>

                    <a href="tel:{{ str_replace(' ', '', $dev['phone']) }}"
                       class="group flex flex-col items-center gap-2 border border-white/10 bg-[var(--color-ink-2)] px-4 py-6 text-center transition hover:border-[var(--color-gold)]/50 hover:bg-white/[0.04]">
                        <x-lucide-phone class="h-5 w-5 text-[var(--color-gold)]" />
                        <span class="tape-label">{{ __('Phone') }}</span>
                        <span class="text-sm text-[var(--color-bone)] transition group-hover:text-[var(--color-gold)]">
                            {{ $dev['phone'] }}
                        </span>
                    </a>

                    <div class="flex flex-col items-center gap-2 border border-white/10 bg-[var(--color-ink-2)] px-4 py-6 text-center">
                        <x-lucide-map-pin class="h-5 w-5 text-[var(--color-gold)]" />
                        <span class="tape-label">{{ __('Location') }}</span>
                        <span class="text-sm text-[var(--color-bone)]">{{ __($dev['location']) }}</span>
                    </div>
                </div>

                {{-- Primary action, plus the two secondary ones --}}
                <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                    <x-mail-link class="btn btn-gold">
                        <x-lucide-send class="h-3.5 w-3.5" />
                        {{ __('Write me on Gmail') }}
                    </x-mail-link>
                    <a href="{{ route('cv') }}" class="btn btn-ghost">{{ __('Download CV') }}</a>
                    <a href="{{ $dev['linkedin'] }}" target="_blank" rel="noopener noreferrer" class="btn btn-ghost">
                        LinkedIn
                    </a>
                </div>

                {{-- Not everyone has a Gmail account, and some people prefer
                     their own client - so the raw address stays one click away. --}}
                <div class="mt-5 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-xs text-[var(--color-bone-dim)]">
                    <button
                        type="button"
                        data-copy="{{ $dev['email'] }}"
                        class="inline-flex items-center gap-1.5 transition hover:text-[var(--color-gold)]"
                    >
                        <x-lucide-copy class="h-3.5 w-3.5" />
                        <span data-copy-idle>{{ __('Copy address') }}</span>
                        <span data-copy-done hidden class="text-[var(--color-gold)]">{{ __('Copied') }}</span>
                    </button>

                    <a
                        href="mailto:{{ $dev['email'] }}?subject={{ rawurlencode(__(config('portfolio.contact.subject'))) }}"
                        class="inline-flex items-center gap-1.5 transition hover:text-[var(--color-gold)]"
                    >
                        <x-lucide-at-sign class="h-3.5 w-3.5" />
                        {{ __('Use my own mail app') }}
                    </a>
                </div>

                <p class="mt-8 text-center text-xs tracking-[0.16em] text-[var(--color-bone-dim)]/80 uppercase">
                    {{ __('I work in') }}:
                    {{ collect($dev['languages'])->map(fn ($l) => __($l['name']))->join(' · ') }}
                </p>
            </div>
        </div>
    </section>
</x-layouts.app>
