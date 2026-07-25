@props(['admin' => false])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-3']) }}>
    <span class="grid h-10 w-10 place-items-center rounded-lg bg-brand-sage text-white shadow-sm shadow-brand-sage/20">
        <svg viewBox="0 0 24 24" aria-hidden="true" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M6 8h12l-1 12H7L6 8Z" />
            <path d="M9 8a3 3 0 0 1 6 0" />
        </svg>
    </span>
    <span class="leading-none">
        <span class="block text-lg font-extrabold tracking-tight text-brand-ink">YALY.</span>
        @if ($admin)
            <span class="mt-1 block text-xs font-bold uppercase tracking-wide text-brand-coral">Admin</span>
        @endif
    </span>
</span>
