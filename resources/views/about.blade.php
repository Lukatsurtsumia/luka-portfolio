@php
    $dev = config('portfolio.developer');
@endphp

<x-layouts.app :title="__('About') . ' - ' . $dev['name']" :description="$dev['summary']">
    <section class="px-5 py-12 sm:px-8 lg:py-16">
        <div class="mx-auto max-w-4xl">

            <p class="eyebrow">{{ __('The fighter') }}</p>
            <h1 class="display mt-4 text-[clamp(2.25rem,8vw,4.5rem)]">{{ __('About') }}</h1>

            <hr class="rule-gold my-10">

            <div class="grid gap-10 lg:grid-cols-[1fr_260px] lg:gap-14">
                <div class="space-y-5 text-lg leading-relaxed text-[var(--color-bone)]/85">
                    <p>
                        {{ __('I am a full-stack PHP and Laravel developer based in Nice. I taught myself to build software, and I learned it the way you learn anything worth knowing - by shipping things that other people then have to rely on.') }}
                    </p>
                    <p>
                        {{ __('Today that means four applications running in production. Two of them belong to real businesses on the Cote d\'Azur: a boxing club and a cleaning company, both serving French customers every day. One is my own product, BoxerOS, an AI training platform I built, deployed and now maintain on my own server. The last is the e-commerce build that taught me the stack.') }}
                    </p>
                    <p>
                        {{ __('I do the whole job. I design the data model, write the Laravel and the front end, build the Docker image, set up the server, wire the DNS and TLS, and stay responsible for it once it is live. When the nightly backup silently wrote empty files for a week, I was the one who found it and fixed it.') }}
                    </p>
                    <p>
                        {{ __('I work in four languages, which in Nice is practical rather than decorative: I build French-first bilingual sites because that is what the clients here need.') }}
                    </p>
                    <p>
                        {{ __('I am looking for a role where I can keep building things that go to production - as an employee, an apprentice, or a freelancer.') }}
                    </p>
                </div>

                <aside class="space-y-8">
                    <div>
                        <img src="{{ asset($dev['portrait']) }}"
                             alt="{{ $dev['name'] }}"
                             width="900" height="1487" loading="lazy" decoding="async"
                             class="duotone w-full border border-[var(--color-gold)]/25">
                    </div>

                    <div>
                        <p class="eyebrow">{{ __('Languages') }}</p>
                        <ul class="mt-3 space-y-2">
                            @foreach ($dev['languages'] as $language)
                                <li class="flex items-baseline justify-between gap-3 border-b border-white/8 pb-2">
                                    <span class="text-sm text-[var(--color-bone)]">{{ __($language['name']) }}</span>
                                    <span class="tape-label">{{ __($language['level']) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <p class="eyebrow">{{ __('Contact') }}</p>
                        <ul class="mt-3 space-y-2 text-sm">
                            <li><a href="mailto:{{ $dev['email'] }}" class="text-[var(--color-gold)] underline-offset-4 hover:underline">{{ $dev['email'] }}</a></li>
                            <li><a href="tel:{{ str_replace(' ', '', $dev['phone']) }}" class="text-[var(--color-bone-dim)] hover:text-[var(--color-bone)]">{{ $dev['phone'] }}</a></li>
                            <li><a href="{{ $dev['github'] }}" target="_blank" rel="noopener noreferrer" class="text-[var(--color-bone-dim)] hover:text-[var(--color-bone)]">GitHub</a></li>
                            <li><a href="{{ $dev['linkedin'] }}" target="_blank" rel="noopener noreferrer" class="text-[var(--color-bone-dim)] hover:text-[var(--color-bone)]">LinkedIn</a></li>
                        </ul>
                    </div>

                    <a href="{{ route('cv') }}" class="btn btn-gold w-full">{{ __('Download CV') }}</a>
                </aside>
            </div>
        </div>
    </section>
</x-layouts.app>
