<x-layouts.admin :title="'Edit '.$category->name" heading="Edit Category">
    <x-admin-panel>
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="grid gap-5">
            @csrf
            @method('PUT')
            <x-admin.category-form :category="$category" />
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-brand-blush px-4 py-2 text-sm font-bold text-brand-ink hover:bg-brand-cream">Cancel</a>
                <button class="rounded-lg bg-brand-sage px-4 py-2 text-sm font-bold text-white hover:bg-brand-ink">Update Category</button>
            </div>
        </form>
    </x-admin-panel>
</x-layouts.admin>
