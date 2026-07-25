<x-layouts.admin title="Add Category" heading="Add Category">
    <x-admin-panel>
        <form method="POST" action="{{ route('admin.categories.store') }}" class="grid gap-5">
            @csrf
            <x-admin.category-form :category="$category" />
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-brand-blush px-4 py-2 text-sm font-bold text-brand-ink hover:bg-brand-cream">Cancel</a>
                <button class="rounded-lg bg-brand-sage px-4 py-2 text-sm font-bold text-white hover:bg-brand-ink">Save Category</button>
            </div>
        </form>
    </x-admin-panel>
</x-layouts.admin>
