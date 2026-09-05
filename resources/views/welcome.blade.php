@component('layouts.app')
    <x-hero />

    <livewire:projects-showcase />

    <x-services-bento />

    <footer class="mx-auto max-w-6xl px-6 py-10 text-center text-sm text-zinc-500 sm:px-8">
        © {{ date('Y') }} {{ config('portfolio.developer.name') }}. Built with Laravel &amp; Livewire.
    </footer>
@endcomponent
