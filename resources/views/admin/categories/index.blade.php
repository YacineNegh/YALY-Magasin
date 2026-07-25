<x-layouts.admin title="Categories" heading="Categories">
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.categories.create') }}" class="rounded-lg bg-brand-sage px-4 py-2 text-sm font-bold text-white hover:bg-brand-ink">Add Category</a>
    </div>

    <section class="rounded-lg border border-brand-blush bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-brand-blush text-sm">
                <thead class="bg-brand-cream text-left text-xs font-bold uppercase tracking-wide text-brand-coral">
                    <tr>
                        <th class="px-5 py-3">Name</th>
                        <th class="px-5 py-3">Products</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-brand-blush/60">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="px-5 py-4 font-bold">{{ $category->name }}</td>
                            <td class="px-5 py-4">{{ $category->products_count }}</td>
                            <td class="px-5 py-4"><x-status-badge :status="$category->status" /></td>
                            <td class="px-5 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="rounded-lg border border-brand-blush px-3 py-1.5 font-semibold text-brand-ink hover:bg-brand-cream">Edit</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">@csrf @method('DELETE')<button class="rounded-lg bg-red-600 px-3 py-1.5 font-semibold text-white">Delete</button></form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <div class="mt-6">{{ $categories->links() }}</div>
</x-layouts.admin>
