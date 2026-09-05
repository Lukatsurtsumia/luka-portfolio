@php
    $developer = config('portfolio.developer');
    $projects = config('portfolio.projects');
    $cvFilename = \Illuminate\Support\Str::slug($developer['name']) . '-cv.html';
@endphp

<section class="relative mx-auto flex max-w-6xl flex-col items-start gap-8 px-6 pt-24 pb-16 sm:px-8 lg:pt-32 lg:pb-24">
    <div class="glass-card inline-flex items-center gap-2 px-4 py-1.5 text-sm text-zinc-300">
        <span class="relative flex h-2 w-2">
            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
            <span class="glow-badge animate-pulse-glow"></span>
        </span>
        Available in {{ $developer['location'] }}
    </div>

    <div class="space-y-4">
        <h1 class="text-4xl font-semibold tracking-tight text-white sm:text-5xl lg:text-7xl">
            {{ $developer['name'] }}
        </h1>
        <p class="accent-gradient-text text-xl font-medium sm:text-2xl lg:text-3xl">
            {{ $developer['title'] }}
        </p>
    </div>

    <p class="max-w-2xl text-base leading-relaxed text-zinc-400 sm:text-lg">
        {{ $developer['summary'] }}
    </p>

    <div class="flex flex-wrap gap-3">
        @foreach ($developer['skills'] as $skill)
            <span class="glass-card px-3 py-1.5 text-sm text-zinc-300">{{ $skill }}</span>
        @endforeach
    </div>

    <div class="flex flex-wrap gap-4 pt-2">
        <a
            href="mailto:{{ $developer['email'] }}"
            class="rounded-xl bg-gradient-to-r from-emerald-500 to-indigo-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 transition hover:shadow-emerald-500/40"
        >
            Get in touch
        </a>
        <a
            href="{{ $developer['github'] }}"
            target="_blank"
            rel="noopener noreferrer"
            class="glass-card px-6 py-3 text-sm font-semibold text-zinc-200 transition hover:bg-white/10"
        >
            GitHub
        </a>
        <a
            href="{{ $developer['linkedin'] }}"
            target="_blank"
            rel="noopener noreferrer"
            class="glass-card px-6 py-3 text-sm font-semibold text-zinc-200 transition hover:bg-white/10"
        >
            LinkedIn
        </a>
        <a
            href="{{ route('cv') }}"
            download="{{ $cvFilename }}"
            class="glass-card inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold text-emerald-300 transition hover:bg-white/10"
        >
            <x-lucide-download class="h-4 w-4" />
            Download CV
        </a>
    </div>

    {{-- Profile / Terminal toggle --}}
    <div x-data="terminalToggle" class="w-full pt-6">
        <div class="mb-4 inline-flex glass-card p-1 text-sm">
            <button
                type="button"
                @click="show('profile')"
                :class="view === 'profile' ? 'bg-gradient-to-r from-emerald-500 to-indigo-500 text-white' : 'text-zinc-400 hover:text-zinc-200'"
                class="rounded-xl px-4 py-2 font-medium transition"
            >
                Profile View
            </button>
            <button
                type="button"
                @click="show('terminal')"
                :class="view === 'terminal' ? 'bg-gradient-to-r from-emerald-500 to-indigo-500 text-white' : 'text-zinc-400 hover:text-zinc-200'"
                class="inline-flex items-center gap-1.5 rounded-xl px-4 py-2 font-medium transition"
            >
                <x-lucide-terminal class="h-4 w-4" />
                Terminal View
            </button>
        </div>

        {{-- Profile view: 3D tilt stat cards --}}
        <div x-show="view === 'profile'" x-cloak class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div
                x-data="tiltCard"
                @mousemove="handleMove($event)"
                @mouseleave="reset()"
                :style="`transform: perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`"
                class="tilt-card glass-card p-5"
            >
                <p class="text-3xl font-semibold text-white">{{ count($projects) }}</p>
                <p class="text-sm text-zinc-400">Projects Shipped</p>
            </div>
            <div
                x-data="tiltCard"
                @mousemove="handleMove($event)"
                @mouseleave="reset()"
                :style="`transform: perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`"
                class="tilt-card glass-card p-5"
            >
                <p class="text-3xl font-semibold text-white">{{ count($developer['skills']) }}</p>
                <p class="text-sm text-zinc-400">Core Skills</p>
            </div>
            <div
                x-data="tiltCard"
                @mousemove="handleMove($event)"
                @mouseleave="reset()"
                :style="`transform: perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`"
                class="tilt-card glass-card p-5"
            >
                <p class="text-3xl font-semibold text-white">{{ count($developer['languages']) }}</p>
                <p class="text-sm text-zinc-400">Languages Spoken</p>
            </div>
        </div>

        {{-- Terminal view: config-driven fake shell session --}}
        <div x-show="view === 'terminal'" x-cloak class="glass-card overflow-hidden">
            <div class="flex items-center gap-1.5 border-b border-white/10 px-4 py-3">
                <span class="h-3 w-3 rounded-full bg-red-500/70"></span>
                <span class="h-3 w-3 rounded-full bg-amber-500/70"></span>
                <span class="h-3 w-3 rounded-full bg-emerald-500/70"></span>
                <span class="ml-2 text-xs text-zinc-500">guest@portfolio — zsh</span>
            </div>
            <div class="space-y-3 overflow-x-auto p-5 font-mono text-sm leading-relaxed break-words">
                <p><span class="text-emerald-400">guest@portfolio</span><span class="text-zinc-500">:~$</span> whoami</p>
                <p class="text-zinc-300">{{ $developer['name'] }} — {{ $developer['title'] }}</p>
                <p><span class="text-emerald-400">guest@portfolio</span><span class="text-zinc-500">:~$</span> cat contact.txt</p>
                <p class="text-zinc-300">{{ $developer['email'] }} · {{ $developer['phone'] }} · {{ $developer['location'] }}</p>
                <p><span class="text-emerald-400">guest@portfolio</span><span class="text-zinc-500">:~$</span> ls ./skills</p>
                <p class="text-zinc-300">{{ implode('  ', $developer['skills']) }}</p>
                <p><span class="text-emerald-400">guest@portfolio</span><span class="text-zinc-500">:~$</span> ls ./projects</p>
                <p class="text-zinc-300">{{ implode('  ', array_column($projects, 'title')) }}</p>

                <p class="flex items-center gap-1">
                    <span class="text-emerald-400">guest@portfolio</span><span class="text-zinc-500">:~$</span>
                    <span class="inline-block h-4 w-2 animate-pulse bg-emerald-400/80"></span>
                </p>
            </div>
        </div>
    </div>
</section>
