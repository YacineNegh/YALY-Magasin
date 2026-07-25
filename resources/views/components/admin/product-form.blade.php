@props(['product', 'categories'])

<div class="grid gap-5 lg:grid-cols-2">
    <label class="grid gap-2 text-sm font-medium text-zinc-800">
        <span>Category</span>
        <select name="category_id" class="rounded-lg border-brand-blush bg-white text-brand-ink shadow-sm focus:border-brand-sage focus:ring-brand-sage">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((int) old('category_id', $product->category_id) === $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
        @error('category_id')
            <span class="text-xs font-semibold text-red-600">{{ $message }}</span>
        @enderror
    </label>
    <x-input label="Name" name="name" :value="$product->name" />
    <x-input label="Price" name="price" type="number" step="0.01" min="0" :value="$product->price" />
    <x-input label="Stock" name="stock" type="number" min="0" :value="$product->stock" />
</div>

<x-textarea label="Description" name="description" :value="$product->description" rows="5" />
<x-textarea label="Specifications" name="specifications" :value="$product->specifications" rows="5" />

<div class="grid gap-5 lg:grid-cols-2">
    <label class="grid gap-2 text-sm font-medium text-zinc-800">
        <span>Status</span>
        <select name="status" class="rounded-lg border-brand-blush bg-white text-brand-ink shadow-sm focus:border-brand-sage focus:ring-brand-sage">
            <option value="active" @selected(old('status', $product->status ?: 'active') === 'active')>Active</option>
            <option value="inactive" @selected(old('status', $product->status) === 'inactive')>Inactive</option>
        </select>
        @error('status')
            <span class="text-xs font-semibold text-red-600">{{ $message }}</span>
        @enderror
    </label>
    <label class="flex items-center gap-3 rounded-lg border border-brand-blush bg-brand-cream px-4 py-3 text-sm font-semibold">
        <input type="checkbox" name="is_featured" value="1" class="rounded border-brand-blush text-brand-sage focus:ring-brand-sage" @checked(old('is_featured', $product->is_featured))>
        <span>Feature on home page</span>
    </label>
</div>

<label class="grid gap-2 text-sm font-medium text-zinc-800">
    <span>Images</span>
    <input name="images[]" type="file" multiple accept="image/jpeg,image/png,image/webp" class="rounded-lg border border-brand-blush bg-white px-3 py-2 text-sm shadow-sm">
    @error('images')
        <span class="text-xs font-semibold text-red-600">{{ $message }}</span>
    @enderror
    @error('images.*')
        <span class="text-xs font-semibold text-red-600">{{ $message }}</span>
    @enderror
</label>

@if ($product->exists && $product->images->isNotEmpty())
    <div class="grid gap-3 sm:grid-cols-4">
        @foreach ($product->images as $image)
            <img src="{{ $image->url() }}" alt="{{ $image->alt_text ?? $product->name }}" class="aspect-square rounded-lg object-cover">
        @endforeach
    </div>
@endif
