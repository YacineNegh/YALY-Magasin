<x-layouts.store title="Home">
    <section class="border-b border-brand-blush bg-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-[1fr_0.9fr] lg:px-8 lg:py-20">
            <div class="flex flex-col justify-center">
                <p class="text-sm font-bold uppercase tracking-wide text-brand-coral">Direct orders, confirmed by phone</p>
                <h1 class="mt-4 max-w-3xl text-4xl font-extrabold tracking-tight text-brand-ink sm:text-5xl lg:text-6xl">YALY.</h1>
                <p class="mt-5 max-w-2xl text-lg leading-8 text-zinc-600">A clean online storefront for curated products. Browse, choose, submit your details, and the owner calls you to confirm availability and delivery.</p>
                <form action="{{ route('products.index') }}" class="mt-8 flex max-w-xl flex-col gap-3 rounded-lg border border-brand-blush bg-brand-cream p-2 sm:flex-row">
                    <input name="search" class="min-h-12 flex-1 rounded-lg border-0 bg-white px-4 text-sm shadow-sm focus:ring-brand-sage" placeholder="Search products">
                    <button class="min-h-12 rounded-lg bg-brand-sage px-6 text-sm font-bold text-white hover:bg-brand-ink">Search</button>
                </form>
            </div>
            <div class="grid content-end">
                <div class="overflow-hidden rounded-lg border border-brand-blush bg-brand-sage shadow-xl shadow-brand-blush/50">
                    @if ($featuredProducts->first()?->imageUrl())
                        <img src="{{ $featuredProducts->first()->imageUrl() }}" alt="{{ $featuredProducts->first()->name }}" class="aspect-[4/3] w-full object-cover opacity-95">
                    @else
                        <div class="grid aspect-[4/3] place-items-center bg-brand-sage text-5xl font-black text-white">YALY.</div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-4">
            <div>
                <p class="text-sm font-bold uppercase tracking-wide text-brand-coral">Categories</p>
                <h2 class="mt-2 text-2xl font-extrabold tracking-tight">Shop by category</h2>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-bold text-brand-sage hover:text-brand-ink">All products</a>
        </div>
        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="rounded-lg border border-brand-blush bg-white p-5 shadow-sm hover:border-brand-coral hover:shadow-md">
                    <div class="flex items-center justify-between gap-3">
                        <h3 class="font-bold">{{ $category->name }}</h3>
                        <span class="rounded-lg bg-brand-blush/70 px-2 py-1 text-xs font-bold text-brand-sage">{{ $category->products_count }}</span>
                    </div>
                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-zinc-600">{{ $category->description }}</p>
                </a>
            @endforeach
        </div>
    </section>

    <section class="bg-white py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-bold uppercase tracking-wide text-brand-coral">Featured</p>
                    <h2 class="mt-2 text-2xl font-extrabold tracking-tight">Owner picks</h2>
                </div>
            </div>
            <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($featuredProducts as $product)
                    <x-product-card :product="$product" />
                @empty
                    <p class="text-sm text-zinc-600">Featured products will appear here.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-4">
            <div>
                <p class="text-sm font-bold uppercase tracking-wide text-brand-coral">Latest</p>
                <h2 class="mt-2 text-2xl font-extrabold tracking-tight">New arrivals</h2>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-bold text-brand-sage hover:text-brand-ink">Browse catalog</a>
        </div>
        <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($latestProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

    <section class="border-t border-brand-blush bg-white">
        <div class="mx-auto grid max-w-7xl gap-5 px-4 py-12 sm:px-6 md:grid-cols-3 lg:px-8">
            <div class="rounded-lg border border-brand-blush bg-brand-cream/50 p-6">
                <h3 class="font-bold">No account needed</h3>
                <p class="mt-2 text-sm leading-6 text-zinc-600">Customers order in one form and continue their day.</p>
            </div>
            <div class="rounded-lg border border-brand-blush bg-brand-cream/50 p-6">
                <h3 class="font-bold">Owner confirmation</h3>
                <p class="mt-2 text-sm leading-6 text-zinc-600">Every order is verified by phone before it moves forward.</p>
            </div>
            <div class="rounded-lg border border-brand-blush bg-brand-cream/50 p-6">
                <h3 class="font-bold">Simple operations</h3>
                <p class="mt-2 text-sm leading-6 text-zinc-600">Admin screens keep products, stock, and order status easy to manage.</p>
            </div>
        </div>
    </section>
</x-layouts.store>
