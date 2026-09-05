@php
    $current = app()->getLocale();
@endphp

<form method="POST" action="{{ route('locale.set') }}" class="flex items-center gap-1">
    @csrf
    <input type="hidden" name="redirect" value="{{ url()->full() }}">

    @foreach (['en' => 'EN', 'fr' => 'FR'] as $code => $label)
        <button
            type="submit"
            name="locale"
            value="{{ $code }}"
            @if ($current === $code) aria-current="true" @endif
            class="px-1.5 py-0.5 text-[0.6875rem] font-bold tracking-[0.14em] transition
                {{ $current === $code
                    ? 'text-[var(--color-gold)]'
                    : 'text-[var(--color-bone-dim)]/60 hover:text-[var(--color-bone)]' }}"
        >
            {{ $label }}
        </button>
        @if (! $loop->last)
            <span class="text-[var(--color-bone-dim)]/30">/</span>
        @endif
    @endforeach
</form>
