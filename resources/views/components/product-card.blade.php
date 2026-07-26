@props(['product'])

<article class="group overflow-hidden rounded-2xl bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg border border-gray-100">
    <a href="{{ route('products.show', $product) }}" class="block">
        <div class="aspect-square bg-brand-blush/20 relative overflow-hidden">
            @if ($product->imageUrl())
                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-110">
            @else
                <div class="grid h-full place-items-center text-sm font-bold text-brand-sage">YΛLY.</div>
            @endif
        </div>
        <div class="grid gap-2 p-5 text-center">
            <h3 class="text-base font-bold text-gray-900 group-hover:text-brand-sage transition line-clamp-1">{{ $product->name }}</h3>
            <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
            <div class="mt-2 flex flex-col items-center justify-center gap-2">
                <p class="text-lg font-black text-brand-sage">{{ number_format((float) $product->price, 2) }} DA</p>
                <span class="rounded-full bg-gray-50 px-3 py-1 text-xs font-semibold {{ $product->stock > 0 ? 'text-emerald-600' : 'text-red-500' }}">{{ $product->stock > 0 ? 'En stock' : 'Rupture' }}</span>
            </div>
        </div>
    </a>
</article>
