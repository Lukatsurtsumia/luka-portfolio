<div class="mx-auto max-w-6xl px-6 py-16 sm:px-8 lg:py-24">
    <div class="mb-10 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
        <div class="space-y-2">
            <h2 class="text-3xl font-semibold tracking-tight text-white sm:text-4xl">
                Selected <span class="accent-gradient-text">Projects</span>
            </h2>
            <p class="text-zinc-400">A few things I've shipped recently.</p>
        </div>

        <div class="flex flex-wrap gap-2">
            <button
                type="button"
                wire:click="setCategory('all')"
                wire:loading.attr="disabled"
                wire:target="setCategory"
                class="rounded-full px-4 py-2 text-sm font-medium transition disabled:cursor-wait disabled:opacity-60 {{ $activeCategory === 'all' ? 'bg-gradient-to-r from-emerald-500 to-indigo-500 text-white' : 'glass-card text-zinc-300 hover:bg-white/10' }}"
            >
                All
            </button>
            @foreach ($categories as $category)
                <button
                    type="button"
                    wire:click="setCategory('{{ $category }}')"
                    wire:key="category-{{ $category }}"
                    wire:loading.attr="disabled"
                    wire:target="setCategory"
                    class="rounded-full px-4 py-2 text-sm font-medium capitalize transition disabled:cursor-wait disabled:opacity-60 {{ $activeCategory === $category ? 'bg-gradient-to-r from-emerald-500 to-indigo-500 text-white' : 'glass-card text-zinc-300 hover:bg-white/10' }}"
                >
                    {{ $category }}
                </button>
            @endforeach
        </div>
    </div>

    <div
        wire:loading.class="opacity-50"
        wire:target="setCategory"
        class="grid grid-cols-1 gap-6 transition-opacity duration-200 sm:grid-cols-2"
    >
        @forelse ($projects as $project)
            <article
                wire:key="project-{{ $project['id'] }}"
                class="glass-card group flex flex-col justify-between p-6 transition duration-300 hover:-translate-y-1 hover:scale-[1.02] hover:bg-white/[0.06]"
            >
                <div class="space-y-3">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-xl font-semibold text-white">{{ $project['title'] }}</h3>
                                @if (! empty($project['live_url']))
                                    <span class="inline-flex items-center gap-1 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-emerald-300">
                                        <span class="relative flex h-1.5 w-1.5">
                                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                                            <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        </span>
                                        Live
                                    </span>
                                @endif
                            </div>
                            <p class="text-sm text-zinc-400">{{ $project['subtitle'] }}</p>
                        </div>
                        <span class="glass-card shrink-0 px-2.5 py-1 text-xs font-medium capitalize text-emerald-300">
                            {{ $project['category'] }}
                        </span>
                    </div>

                    <p class="text-sm leading-relaxed text-zinc-400">{{ $project['description'] }}</p>

                    <div class="flex flex-wrap gap-2 pt-1">
                        @foreach ($project['tags'] as $tag)
                            <span class="rounded-full border border-white/10 bg-white/5 px-2.5 py-1 text-xs text-zinc-300">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>

                <div class="mt-6 flex gap-3 border-t border-white/10 pt-4">
                    <a
                        href="{{ $project['live_url'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex-1 rounded-lg bg-gradient-to-r from-emerald-500 to-indigo-500 px-4 py-2 text-center text-sm font-semibold text-white transition hover:opacity-90"
                    >
                        Live Site
                    </a>
                    <a
                        href="{{ $project['github_url'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="flex-1 rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-center text-sm font-semibold text-zinc-200 transition hover:bg-white/10"
                    >
                        GitHub
                    </a>
                </div>
            </article>
        @empty
            <p class="col-span-full text-center text-zinc-500">No projects in this category yet.</p>
        @endforelse
    </div>
</div>
