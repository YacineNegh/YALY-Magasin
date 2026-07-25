<x-layouts.admin title="Add Product" heading="Add Product">
    <x-admin-panel>
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="grid gap-5">
            @csrf
            <x-admin.product-form :product="$product" :categories="$categories" />
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.products.index') }}" class="rounded-lg border border-brand-blush px-4 py-2 text-sm font-bold text-brand-ink hover:bg-brand-cream">Cancel</a>
                <button class="rounded-lg bg-brand-sage px-4 py-2 text-sm font-bold text-white hover:bg-brand-ink">Save Product</button>
            </div>
        </form>
    </x-admin-panel>
</x-layouts.admin>
