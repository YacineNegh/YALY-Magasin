@props(['href', 'active' => false])

<a href="{{ $href }}" {{ $attributes->merge(['class' => ($active ? 'bg-brand-sage text-white shadow-sm shadow-brand-sage/20' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-ink').' whitespace-nowrap rounded-lg px-3 py-2 transition font-semibold']) }}>
    {{ $slot }}
</a>
