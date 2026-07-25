@props(['category'])

<x-input label="Name" name="name" :value="$category->name" />
<x-textarea label="Description" name="description" :value="$category->description" rows="4" />
<label class="grid gap-2 text-sm font-medium text-zinc-800">
    <span>Status</span>
    <select name="status" class="rounded-lg border-brand-blush bg-white text-brand-ink shadow-sm focus:border-brand-sage focus:ring-brand-sage">
        <option value="active" @selected(old('status', $category->status ?: 'active') === 'active')>Active</option>
        <option value="inactive" @selected(old('status', $category->status) === 'inactive')>Inactive</option>
    </select>
    @error('status')
        <span class="text-xs font-semibold text-red-600">{{ $message }}</span>
    @enderror
</label>
