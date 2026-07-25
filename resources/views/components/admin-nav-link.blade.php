@props(['href', 'active' => false])

<a href="{{ $href }}" {{ $attributes->merge(['class' => ($active ? 'bg-brand-sage text-white shadow-sm shadow-brand-sage/20' : 'text-brand-ink/70 hover:bg-brand-blush/30 hover:text-brand-ink').' whitespace-nowrap rounded-lg px-3 py-2 transition']) }}>
    {{ $slot }}
</a>
