@props(['status'])

@php
    $classes = [
        'active' => 'bg-brand-blush/60 text-brand-sage ring-brand-blush',
        'inactive' => 'bg-zinc-100 text-zinc-700 ring-zinc-200',
        'pending' => 'bg-brand-blush/70 text-brand-coral ring-brand-blush',
        'confirmed' => 'bg-brand-sage/10 text-brand-sage ring-brand-sage/20',
        'delivered' => 'bg-brand-sage/10 text-brand-sage ring-brand-sage/20',
        'cancelled' => 'bg-red-50 text-red-700 ring-red-200',
    ][$status] ?? 'bg-brand-blush/60 text-brand-ink ring-brand-blush';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-bold capitalize ring-1 '.$classes]) }}>{{ $slot->isEmpty() ? $status : $slot }}</span>
