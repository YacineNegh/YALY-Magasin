@props(['admin' => false])

<span {{ $attributes->merge(['class' => 'inline-flex items-center']) }}>
    <img src="{{ asset('images/logo.png') }}" class="h-14 w-auto object-contain -mr-4 hue-rotate-[250deg] saturate-50 contrast-125" alt="YALY Logo">
    <span class="leading-none">
        <span class="block text-xl font-extrabold tracking-tight text-brand-ink">YΛLY.</span>
        @if ($admin)
            <span class="mt-1 block text-xs font-bold uppercase tracking-wide text-brand-coral">Admin</span>
        @endif
    </span>
</span>
