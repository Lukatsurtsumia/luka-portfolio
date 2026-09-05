@php
    $developer = config('portfolio.developer');
    $projects = config('portfolio.projects');
    $categoryCount = collect($projects)->pluck('category')->unique()->count();

    $highlightIcons = [
        'Docker & Ubuntu' => ['icon' => 'container', 'color' => 'text-indigo-400'],
        'PHP' => ['icon' => 'file-code', 'color' => 'text-emerald-400'],
        'Laravel' => ['icon' => 'flame', 'color' => 'text-indigo-400'],
        'AI Integration' => ['icon' => 'brain-circuit', 'color' => 'text-emerald-400'],
    ];

    $highlights = collect($highlightIcons)
        ->only($developer['skills'])
        ->map(fn ($meta, $skill) => [...$meta, 'label' => $skill]);
@endphp

<section class="mx-auto max-w-6xl px-6 py-16 sm:px-8 lg:py-24">
    <div class="mb-10 space-y-2">
        <h2 class="text-3xl font-semibold tracking-tight text-white sm:text-4xl">
            What I <span class="accent-gradient-text">Bring</span>
        </h2>
        <p class="text-zinc-400">A quick snapshot of the stack, reach, and output behind the work.</p>
    </div>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:auto-rows-[minmax(0,1fr)]">
        <div class="glass-card col-span-1 space-y-5 p-6 transition duration-300 hover:-translate-y-1 sm:col-span-2 lg:col-span-2 lg:row-span-2">
            <div class="flex items-center gap-2 text-emerald-400">
                <x-lucide-code-2 class="h-5 w-5" />
                <span class="text-sm font-medium uppercase tracking-wide">Core Stack</span>
            </div>
            <p class="text-sm leading-relaxed text-zinc-400">{{ $developer['summary'] }}</p>

            @if ($highlights->isNotEmpty())
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
                    @foreach ($highlights as $highlight)
                        <div class="flex flex-col items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-3 py-4 text-center transition hover:bg-white/10">
                            <x-dynamic-component :component="'lucide-' . $highlight['icon']" class="h-6 w-6 {{ $highlight['color'] }}" />
                            <span class="text-xs font-medium text-zinc-300">{{ $highlight['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="flex flex-wrap gap-2">
                @foreach ($developer['skills'] as $skill)
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-zinc-300">
                        {{ $skill }}
                    </span>
                @endforeach
            </div>
        </div>

        <div class="glass-card space-y-4 p-6 transition duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-2 text-indigo-400">
                <x-lucide-languages class="h-5 w-5" />
                <span class="text-sm font-medium uppercase tracking-wide">Languages</span>
            </div>
            <ul class="space-y-1.5 text-sm text-zinc-300">
                @foreach ($developer['languages'] as $language)
                    <li>{{ $language }}</li>
                @endforeach
            </ul>
        </div>

        <div class="glass-card space-y-4 p-6 transition duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-2 text-emerald-400">
                <x-lucide-folder-git-2 class="h-5 w-5" />
                <span class="text-sm font-medium uppercase tracking-wide">Shipped</span>
            </div>
            <p class="text-3xl font-semibold text-white">{{ count($projects) }}</p>
            <p class="text-sm text-zinc-400">projects across {{ $categoryCount }} categories</p>
        </div>

        <div class="glass-card space-y-3 p-6 transition duration-300 hover:-translate-y-1 sm:col-span-2 lg:col-span-2">
            <div class="flex items-center gap-2 text-indigo-400">
                <x-lucide-map-pin class="h-5 w-5" />
                <span class="text-sm font-medium uppercase tracking-wide">Reach Me</span>
            </div>
            <div class="grid grid-cols-1 gap-2 text-sm text-zinc-300 sm:grid-cols-2">
                <a href="mailto:{{ $developer['email'] }}" class="flex items-center gap-2 transition hover:text-emerald-300">
                    <x-lucide-mail class="h-4 w-4" />
                    {{ $developer['email'] }}
                </a>
                <a href="tel:{{ $developer['phone'] }}" class="flex items-center gap-2 transition hover:text-emerald-300">
                    <x-lucide-phone class="h-4 w-4" />
                    {{ $developer['phone'] }}
                </a>
                <span class="flex items-center gap-2">
                    <x-lucide-globe class="h-4 w-4" />
                    {{ $developer['location'] }}
                </span>
            </div>
        </div>
    </div>
</section>
