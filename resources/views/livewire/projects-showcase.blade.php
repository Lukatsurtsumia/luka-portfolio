<div>
    {{-- Filter by what the work actually was, not by technology --}}
    <div class="flex flex-wrap gap-2 py-8">
        <button
            type="button"
            wire:click="setKind('all')"
            wire:loading.attr="disabled"
            wire:target="setKind"
            class="badge transition disabled:opacity-50
                {{ $activeKind === 'all' ? 'badge-client' : 'badge-learning hover:border-white/30' }}"
        >
            {{ __('All') }} ({{ count(config('portfolio.projects')) }})
        </button>

        @foreach ($kinds as $kind => $count)
            <button
                type="button"
                wire:key="kind-{{ $kind }}"
                wire:click="setKind('{{ $kind }}')"
                wire:loading.attr="disabled"
                wire:target="setKind"
                class="badge transition disabled:opacity-50
                    {{ $activeKind === $kind ? 'badge-client' : 'badge-learning hover:border-white/30' }}"
            >
                {{ __(ucfirst($kind) === 'Client' ? 'Client work' : (ucfirst($kind) === 'Product' ? 'Own product' : 'Learning project')) }}
                ({{ $count }})
            </button>
        @endforeach
    </div>

    <div wire:loading.class="opacity-40" wire:target="setKind" class="transition-opacity duration-200">
        @forelse ($projects as $project)
            <x-fight-card :project="$project" :index="$loop->index" wire:key="project-{{ $project['id'] }}" />
        @empty
            <p class="py-16 text-center text-[var(--color-bone-dim)]">{{ __('Nothing here yet.') }}</p>
        @endforelse
    </div>
</div>
