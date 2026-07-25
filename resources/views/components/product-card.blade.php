@props(['product'])

<article class="overflow-hidden rounded-lg border border-brand-blush bg-white shadow-sm transition hover:-translate-y-0.5 hover:border-brand-coral hover:shadow-md">
    <a href="{{ route('products.show', $product) }}" class="block">
        <div class="aspect-square bg-brand-blush/30">
            @if ($product->imageUrl())
                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
            @else
                <div class="grid h-full place-items-center text-sm font-bold text-brand-sage">YALY.</div>
            @endif
        </div>
        <div class="grid gap-3 p-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-brand-coral">{{ $product->category->name }}</p>
                <h3 class="mt-1 text-base font-bold tracking-tight">{{ $product->name }}</h3>
            </div>
            <div class="flex items-center justify-between gap-3">
                <p class="text-lg font-extrabold">{{ number_format((float) $product->price, 2) }} DA</p>
                <span class="rounded-lg bg-brand-blush/60 px-2 py-1 text-xs font-semibold text-brand-sage">{{ $product->stock > 0 ? 'In stock' : 'Out' }}</span>
            </div>
        </div>
    </a>
</article>
