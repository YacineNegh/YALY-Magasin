<x-layouts.store title="Products">
    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-wide text-brand-coral">Catalog</p>
                <h1 class="mt-2 text-3xl font-extrabold tracking-tight">Products</h1>
            </div>
            <form action="{{ route('products.index') }}" class="grid gap-3 rounded-lg border border-brand-blush bg-white p-3 shadow-sm sm:grid-cols-[1fr_auto_auto]">
                <input name="search" value="{{ $search }}" class="rounded-lg border-brand-blush text-sm focus:border-brand-sage focus:ring-brand-sage" placeholder="Search products">
                <select name="category" class="rounded-lg border-brand-blush text-sm focus:border-brand-sage focus:ring-brand-sage">
                    <option value="">All categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected($selectedCategory === $category->slug)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <button class="rounded-lg bg-brand-sage px-5 py-2 text-sm font-bold text-white hover:bg-brand-ink">Filter</button>
            </form>
        </div>

        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="rounded-lg border border-brand-blush bg-white p-8 text-sm text-zinc-600 sm:col-span-2 lg:col-span-4">No products match your search.</div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </section>
</x-layouts.store>
