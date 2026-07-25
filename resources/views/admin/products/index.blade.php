<x-layouts.admin title="Products" heading="Products">
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-brand-sage px-4 py-2 text-sm font-bold text-white hover:bg-brand-ink">Add Product</a>
    </div>

    <section class="rounded-lg border border-brand-blush bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-blush text-sm">
                <thead class="bg-brand-cream text-left text-xs font-bold uppercase tracking-wide text-brand-coral">
                    <tr>
                        <th class="px-5 py-3">Product</th>
                        <th class="px-5 py-3">Category</th>
                        <th class="px-5 py-3">Price</th>
                        <th class="px-5 py-3">Stock</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-blush/60">
                    @foreach ($products as $product)
                        <tr>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-12 w-12 overflow-hidden rounded-lg bg-brand-blush/40">
                                        @if ($product->imageUrl())
                                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold">{{ $product->name }}</p>
                                        @if ($product->is_featured)
                                            <p class="text-xs font-semibold text-brand-coral">Featured</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">{{ $product->category->name }}</td>
                            <td class="px-5 py-4 font-semibold">{{ number_format((float) $product->price, 2) }} DA</td>
                            <td class="px-5 py-4">{{ $product->stock }}</td>
                            <td class="px-5 py-4"><x-status-badge :status="$product->status" /></td>
                            <td class="px-5 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="rounded-lg border border-brand-blush px-3 py-1.5 font-semibold text-brand-ink hover:bg-brand-cream">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}">@csrf @method('DELETE')<button class="rounded-lg bg-red-600 px-3 py-1.5 font-semibold text-white">Delete</button></form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <div class="mt-6">{{ $products->links() }}</div>
</x-layouts.admin>
